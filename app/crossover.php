<?php

class Crossover
{
    public $populations;
    public $popSize;
    public $crossoverRate;

    function __construct($populations, $popSize, $crossoverRate)
    {
        $this->populations = $populations;
        $this->popSize = $popSize;
        $this->crossoverRate = $crossoverRate;
    }

    function randomZeroToOne()
    {
        return (float) rand() / (float) getrandmax();
    }

    function randomizingParents()
    {
        for ($i = 0; $i < $this->popSize; $i++) {
            $randomZeroToOne = $this->randomZeroToOne();
            if ($randomZeroToOne < $this->crossoverRate) {
                $parents[$i] = $randomZeroToOne;
            }
        }
        return $parents;
    }

    function generateCrossover()
    {
        $parents = $this->randomizingParents();
        foreach (array_keys($parents) as $key) {
            foreach (array_keys($parents) as $subkey) {
                if ($key !== $subkey) {
                    $ret[] = [$key, $subkey];
                }
            }
            // array_shift($parents);
            unset($parents[$key]);
        }
        return $ret;
    }

    ## TODO refaktor karena agak duplikat code
    function offspring($parent1, $parent2, $cutPointIndex, $offspring)
    {
        if ($offspring === 1) {
            for ($i = 0; $i <= count((new Individu())->createRandomIndividu()) - 1; $i++) {
                if ($i <= $cutPointIndex) {
                    $ret[] = $parent1[$i];
                }
                if ($i > $cutPointIndex) {
                    $ret[] = $parent2[$i];
                }
            }
        }

        if ($offspring === 2) {
            for ($i = 0; $i <= count((new Individu())->createRandomIndividu()) - 1; $i++) {
                if ($i <= $cutPointIndex) {
                    $ret[] = $parent2[$i];
                }
                if ($i > $cutPointIndex) {
                    $ret[] = $parent1[$i];
                }
            }
        }
        return $ret;
    }

    function cutPointRandom()
    {
        return rand(0, count((new Individu())->createRandomIndividu()) - 1);
    }

    function crossover()
    {
        $cutPointIndex = $this->cutPointRandom();
        foreach ($this->generateCrossover() as $listOfCrossover) {
            $parent1 = $this->populations[$listOfCrossover[0]];
            $parent2 = $this->populations[$listOfCrossover[1]];
            $offspring1 = $this->offspring($parent1, $parent2, $cutPointIndex, 1);
            $offspring2 = $this->offspring($parent1, $parent2, $cutPointIndex, 2);
            $offsprings[] = $offspring1;
            $offsprings[] = $offspring2;
        }
        return $offsprings;
    }
}