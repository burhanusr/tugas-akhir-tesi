<?php

class Randomizer
{
    static function getRandomIndexOfGen()
    {
        return rand(0, count((new Individu())->createRandomIndividu()) - 1);
    }

    function getRandomIndexOfIndividu($popSize)
    {
        return rand( 0, ($popSize - 1));
    }
}