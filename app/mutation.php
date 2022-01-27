<?php

class Mutation
{
    function __construct($population, $popSize)
    {
        $this->population = $population;
        $this->popSize = $popSize;
    }

    function calculateMutationRate()
    {
        return 1 / count((new Individu())->createRandomIndividu());
    }

    function calculateNumOfMutation()
    {
        return round($this->calculateMutationRate() * $this->popSize);
    }

    function generateMutation($valueOfGen)
    {
        if ($valueOfGen === 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function isMutationExist()
    {
        if ($this->calculateNumOfMutation() > 0) {
            return TRUE;
        }
    }

    function mutation()
    {
        if ($this->isMutationExist()) {
            for ($i = 0; $i <= $this->calculateNumOfMutation() - 1; $i++) {
                $indexOfIndividu = (new Randomizer())->getRandomIndexOfIndividu($this->popSize);
                $indexOfGen = Randomizer::getRandomIndexOfGen();
                $selectedIndividu = $this->population[$indexOfIndividu];
                $valueOfGen = $selectedIndividu[$indexOfGen];
                $mutatedGen = $this->generateMutation($valueOfGen);
                $selectedIndividu[$indexOfGen] = $mutatedGen;
                $ret[] = $selectedIndividu;
            }
            return $ret;
        }
    }
}