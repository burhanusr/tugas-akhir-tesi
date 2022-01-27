<?php

class Fitness
{
    public $budget;

    function __construct($budget)
    {
        $this->budget = $budget;
    }

    function calculateFitnessValue($individu)
    {
        $catalogue = new Catalogue;
        $ret = [];
        $ret[] = $catalogue->catalogue()["processor"][$individu[0]]["price"];
        $ret[] = $catalogue->catalogue()["motherboard"][$individu[1]]["price"];
        $ret[] = $catalogue->catalogue()["memory"][$individu[2]]["price"];
        $ret[] = $catalogue->catalogue()["vga"][$individu[3]]["price"];
        $ret[] = $catalogue->catalogue()["hdd"][$individu[4]]["price"];

        return array_sum($ret);
    }

    function isFit($individu, $fitnessValue)
    {
        $catalogue = new Catalogue;

        $processorSocket = $catalogue->catalogue()["processor"][$individu[0]]["socket"];
        $motherboardSocket = $catalogue->catalogue()["motherboard"][$individu[1]]["socket"];

        $motherboardSlotType = $catalogue->catalogue()["motherboard"][$individu[1]]["memorySlotType"];
        $memorySlotType = $catalogue->catalogue()["memory"][$individu[2]]["memorySlotType"];

        if($processorSocket === $motherboardSocket) {
            if($motherboardSlotType === $memorySlotType) {
                if($fitnessValue <= $this->budget) {
                    return true;
                }
            }
        }

    }

    function searchBestIndividu($fits, $maxFitness, $numberOfIndividuHasMaxFitness)
    {
        if ($numberOfIndividuHasMaxFitness === 1) {
            return $fits[array_search($maxFitness, array_column($fits, 'fitnessValue'))];
        } else {
            foreach ($fits as $key => $val) {
                if ($val['fitnessValue'] === $maxFitness) {
                    $ret[] = [
                        'individuKey' => $key,
                        'fitnessValue' => $val['fitnessValue'],
                        'chromosome' => $val['chromosome']
                    ];
                }
            }
            if (count(array_unique(array_column($ret, 'fitnessValue'))) === 1) {
                $index = rand(0, count($ret) - 1);
            } else {
                $index = array_search(max(array_column($ret, 'fitnessValue')), array_column($ret, 'fitnessValue'));
            }
            return $ret[$index];
        }
    }

    function bestIndividus($fits)
    {
        $countedMaxFitness = array_count_values(array_column($fits, 'fitnessValue'));
        $maxFitness = max(array_keys($countedMaxFitness));
        $numberOfIndividuHasMaxFitness = $countedMaxFitness[$maxFitness];
        $bestFitnessValue = $this->searchBestIndividu($fits, $maxFitness, $numberOfIndividuHasMaxFitness);
        return $bestFitnessValue;
    }

    function fitnessEvaluation($population)
    {
        $fits = [];
        foreach($population as $listOfIndividuKey => $listOfIndividu) {
            $fitnessValue = $this->calculateFitnessValue($listOfIndividu);

            if ($this->isFit($listOfIndividu, $fitnessValue)) {
                $fits[] = [
                    'individuKey' => $listOfIndividuKey,
                    'fitnessValue' => $fitnessValue,
                    'chromosome' => $listOfIndividu
                ];
            }
        }
        return $fits;
    }
}