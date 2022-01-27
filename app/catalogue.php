<?php


class Catalogue
{
    // method untuk mengubah key/index dari array lama
    function motherboardColumn($listOfRawData) {
        $column = ["name", "socket", "memorySlotType", "price"];
        foreach(array_keys($listOfRawData) as $listOfRawDataKeys) {
            $listOfRawData[$column[$listOfRawDataKeys]] = $listOfRawData[$listOfRawDataKeys];
            unset($listOfRawData[$listOfRawDataKeys]);
        }
        return $listOfRawData;
    }

    function processorColumn($listOfRawData)
    {
        $column = ["name", "socket", "price"];
        foreach(array_keys($listOfRawData) as $listOfRawDataKeys) {
            $listOfRawData[$column[$listOfRawDataKeys]] = $listOfRawData[$listOfRawDataKeys];
            unset($listOfRawData[$listOfRawDataKeys]);
        }
        return $listOfRawData;
    }

    function memoryColumn($listOfRawData)
    {
        $column = ["name", "memorySlotType", "price"];
        foreach(array_keys($listOfRawData) as $listOfRawDataKeys) {
            $listOfRawData[$column[$listOfRawDataKeys]] = $listOfRawData[$listOfRawDataKeys];
            unset($listOfRawData[$listOfRawDataKeys]);
        }
        return $listOfRawData;
    }

    function createNewColumn($listOfRawData)
    {
        $column = ["name", "price"];
        foreach(array_keys($listOfRawData) as $listOfRawDataKeys) {
            $listOfRawData[$column[$listOfRawDataKeys]] = $listOfRawData[$listOfRawDataKeys];
            unset($listOfRawData[$listOfRawDataKeys]);
        }
        return $listOfRawData;
    }

    // method untuk memproses data dari file
    function catalogue(){

        $processorRawData = file("data/processor.txt");
        $motherboardRawData = file("data/motherboard.txt");
        $memoryRawData = file("data/memori.txt");
        $vgaRawData = file("data/vga.txt");
        $hddRawData = file("data/hdd.txt");
        
        foreach($processorRawData as $listOfRawData) {
            $collectionProcessor[] = $this->processorColumn(explode(",", $listOfRawData));
            $collectionListOfMenu["processor"] = $collectionProcessor;
        }

        foreach($motherboardRawData as $listOfRawData) {
            $collectionMotherboard[] = $this->motherboardColumn(explode(",", $listOfRawData));
            $collectionListOfMenu["motherboard"] = $collectionMotherboard;
        }

        foreach($memoryRawData as $listOfRawData) {
            $collectionMemory[] = $this->memoryColumn(explode(",", $listOfRawData));
            $collectionListOfMenu["memory"] = $collectionMemory;
        }

        foreach($vgaRawData as $listOfRawData) {
            $collectionVga[] = $this->createNewColumn(explode(",", $listOfRawData));
            $collectionListOfMenu["vga"] = $collectionVga;
        }

        foreach($hddRawData as $listOfRawData) {
            $collectionHdd[] = $this->createNewColumn(explode(",", $listOfRawData));
            $collectionListOfMenu["hdd"] = $collectionHdd;
        }

        return $collectionListOfMenu;
    }
}

//  