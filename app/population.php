<?php

class Population
{
    function createRandomPopulation($popSize) {
        $individu = new Individu;

        for($i = 0; $i <= $popSize - 1; $i++) {
            $ret[] = $individu->createRandomIndividu();
        }

        return $ret;
    }
}