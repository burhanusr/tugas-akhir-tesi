<?php

$start = microtime(true);

require "app/catalogue.php";
require "app/individu.php";
require "app/population.php";
require "app/fitness.php";
require "app/randomizer.php";
require "app/crossover.php";
require "app/mutation.php";
require "app/selection.php";

class Algen
{
    public $maxIter;
    public $popSize;
    public $budget;
    public $stoppingValue;
    public $crossoverRate;

    function isFound($bestIndividus)
    {
        $residual = $this->budget - $bestIndividus['fitnessValue'];
        if ($residual <= $this->stoppingValue && $residual > 0) {
            return TRUE;
        }
    }


    function analytics($iter, $analitics)
    {
        $numOfLastResults = 10;
        if ($iter >= ($numOfLastResults - 1)) {
            $residual = count($analitics) - $numOfLastResults;
            
            if ($residual === 0 && count(array_unique($analitics)) === 1) {
                return true;
            }

            if ($residual > 0) {
                for ($i = 0; $i < $residual; $i++) {
                    array_shift($analitics);
                }
                if (count(array_unique($analitics)) === 1) {
                    return true;
                }
            }
        }
    }

    function algen()
    {
        $fitness = new Fitness($this->budget, $this->stoppingValue);
        $population = (new Population($this))->createRandomPopulation($this->popSize);
        $fitIndividus = $fitness->fitnessEvaluation($population);
        $bestIndividus = $fitness->bestIndividus($fitIndividus);
        $bestIndividuIsFound = $this->isFound($bestIndividus);

        $iter = 0;
        while ($iter < $this->maxIter || $bestIndividuIsFound === FALSE) {

            $crossoverOffsprings = (new Crossover($population, $this->popSize, $this->crossoverRate))->crossover();
            $mutation = new Mutation($population, $this->popSize);

            if ($mutation->isMutationExist()) {
                $mutationOffsprings = $mutation->mutation();
                foreach ($mutationOffsprings as $mutationOffspring) {
                    $crossoverOffsprings[] = $mutationOffspring;
                }
            }
            $selection = new Selection($population, $crossoverOffsprings, $this->popSize, $this->budget);
            $population = [];
            $population = $selection->selectingInvididus();
            $fitIndividus = [];
            $fitIndividus = $fitness->fitnessEvaluation($population);
            $bestIndividus = $fitness->bestIndividus($fitIndividus);

            $bestIndividuIsFound = $this->isFound($bestIndividus);

            if ($bestIndividuIsFound) {
                return $bestIndividus;
                // return $population[$index];
            }
            $bests[] = $bestIndividus;
            $analitics[] = $bestIndividus['fitnessValue'];
            if ($this->analytics($iter, $analitics)) {
                break;
            }
            $iter++;
        }

        $maxItems = max(array_column($bests, 'fitnessValue'));
        $index = array_search($maxItems, array_column($bests, 'fitnessValue'));
        return $bests[$index];
    }
}

// function saveToFile($maxIter, $fitnessValue)
// {
//     $pathToFile = 'parcel.txt';
//     $data = array($maxIter, $fitnessValue);
//     $fp = fopen($pathToFile, 'a');
//     fputcsv($fp, $data);
//     fclose($fp);
// }


// for ($i = 0; $i < 30; $i++){
//     echo 'PopSize: ' . 8;
    
//     $algen = new Algen;
//     $algen->budget = 7000000;
//     $algen->crossoverRate = 0.8;
//     $algen->popSize = 8;
//     $algen->stoppingValue = 500000;
//     $algen->maxIter = 250;
//     $algenKnapsack = $algen->algen();

//     print_r($algenKnapsack);

//     // echo ' Individu Key: ' . $algenKnapsack['fitnessValue'];
//     // // print_r($algenKnapsack);
//     // echo "\n";
//     // saveToFile(250, $algenKnapsack['fitnessValue']);
// }


// $end = microtime(true);

// echo 'Time: '. ($end - $start);
