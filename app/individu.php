<?php

class Individu
{
    function getProcessor($catalogue)
    {
        $processorIndex = rand(0, count($catalogue["processor"]) - 1);
        return $processorIndex; 
    }

    function getMotherboard($catalogue, $socket)
    {
        foreach($catalogue["motherboard"] as $key => $val) {
            if($val["socket"] === $socket) {
                $ret[] = $key;
            }
        }

        $key = array_rand($ret);
        $motherboardIndex = $ret[$key];
        
        return $motherboardIndex;
    }

    function getMemory($catalogue, $slotType)
    {
        foreach($catalogue["memory"] as $key => $val) {
            if($val["memorySlotType"] === $slotType) {
                $ret[] = $key;
            }
        }

        $key = array_rand($ret);
        $memoryIndex = $ret[$key];
        
        return $memoryIndex;
    }

    function createRandomIndividu()
    {
        $catalogue = new Catalogue;
        $listCatalogue = $catalogue->catalogue();

        $processorIndex = $this->getProcessor($listCatalogue);
        $ret[] = $processorIndex;
        $processorSocket = $catalogue->catalogue()["processor"][$processorIndex]["socket"];

        $motherboardIndex = $this->getMotherboard($listCatalogue, $processorSocket);
        $ret[] = $motherboardIndex;
        $memorySlotType = $catalogue->catalogue()["motherboard"][$motherboardIndex]["memorySlotType"];

        $memoryIndex = $this->getMemory($listCatalogue, $memorySlotType);
        $ret[] = $memoryIndex;

        $ret[] = rand(0, count($catalogue->catalogue()["vga"]) - 1);
        $ret[] = rand(0, count($catalogue->catalogue()["hdd"]) - 1);
        

        return $ret;

    }
}

// $individu = new Individu;
// print_r($individu->createRandomIndividu());