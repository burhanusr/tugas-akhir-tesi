<?php

class Selection
{
    public $population;
    public $combinedOffsprings;
    public $popSize;
    public $budget;

    function __construct($population, $combinedOffsprings, $popSize, $budget)
    {
        $this->population = $population;
        $this->combinedOffsprings = $combinedOffsprings;
        $this->popSize = $popSize;
        $this->budget = $budget;
    }

    function createTemporaryPopulation()
    {
        foreach ($this->combinedOffsprings as $offspring) {
            $this->population[] = $offspring;
        }
        return $this->population;
    }

    function getVariableValue($basePopulation, $fitTemporaryPopulation)
    {
        foreach ($fitTemporaryPopulation as $val) {
            $ret[] = $basePopulation[$val[1]];
        }
        return $ret;
    }

    function sortFitTemporaryPopulation()
    {
        $tempPopulation = $this->createTemporaryPopulation();
        $fitness = new Fitness($this->budget);
        foreach ($tempPopulation as $key => $individu) {
            $fitnessValue = $fitness->calculateFitnessValue($individu);
            if ($fitness->isFit($individu, $fitnessValue)) {
                $fitTemporaryPopulation[] = [
                    $fitnessValue,
                    $key
                ];
            }
        }
        rsort($fitTemporaryPopulation);
        $fitTemporaryPopulation = array_slice($fitTemporaryPopulation, 0, $this->popSize);

        return $this->getVariableValue($tempPopulation, $fitTemporaryPopulation);
    }

    function selectingInvididus()
    {
        return $this->sortFitTemporaryPopulation();
    }
}

class RouleteWheel
{
    function __construct($population, $popSize)
    {
        $this->population = $population;
        $this->popSize = $popSize;
    }

    function getFitness($population)
    {
        $fitness = new Fitness($this->budget);
        foreach($this->population as $individu) {
            $fitnessValue[] = $fitness->calculateFitnessValue($individu);
        }
        return $fitnessValue;
    }

    function probabilityIndividu($population)
    {
        $fitnessValue = $this->getFitness($population);
        $totalFitness = array_sum($fitnessValue);
        
        foreach($fitnessValue as $individuFitness) {
            $ret[] = $individuFitness / $totalFitness;
        }
        return $ret;
    }

    function cumulativeProbability($population)
    {
        $temp = 0;
        $probability = $this->probabilityIndividu($population);
        foreach($probability as $val) {
            $temp = $temp + $val;
            $cumulative[] = $temp;
        }
        return $cumulative;
    }

    function randomZeroToOne()
    {
        return (float) rand() / (float) getrandmax();
    }

    function selectionIndividu()
    {
        $cumulative = $this->cumulativeProbability($this->population);
        for($i=0; $i < $this->popSize; $i++) {
            $randomZeroToOne = $this->randomZeroToOne();
            
            foreach($cumulative as $key => $val) {
                if($randomZeroToOne < $val) {
                    $newChromosome[] = ($this->population)[$key];
                    break;
                }
            }
        }
        return $newChromosome;
    }
}

