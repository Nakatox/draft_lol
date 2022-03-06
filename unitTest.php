<?php

require(__DIR__ .'/counter.php');


class DraftTest {


    function arrayStructure(array $structure = null, array $array, &$errors = []){
        foreach ($structure as $key => $value) {
            if (is_array($value)) {
                if (!array_key_exists($key, $array)) $errors[] = false;
                $this->arrayStructure($structure[$key], $array[$key], $errors);
            } else {
                if (!array_key_exists($value, $array)) $errors[] = false;
            }
        }

        return empty($errors);
    }

    public function  testModel(): bool {
        $gamesData = returnData();

        $model = [
            ["Gragas","Viego","Viktor","Jinx","Alistar",],["Renekton","Xin Zhao","LeBlanc","Samira","Leona",]
        ];

        $gamesStruct = [
            [],[]
        ];

        $checkStruct = $this->arrayStructure($gamesStruct, $gamesData, $errors);

        return $gamesData[0] == $model and $checkStruct;
    }

    public function testCounter(): bool {
        $counterData = counters("darius", "gragas", "zed", "jinx", "lulu");

        $countersModel = [
            ["Camille"],["Lee Sin"],["Graves", "Syndra"],["Aphelios"],["Nautilus"]
        ];

        $countersDataHandelError = counters("", "gragas", "zed", "jinx", "lulu");
        $countersDataHandelError2 = counters("TANGUY", "gragas", "zed", "jinx", "lulu");
        

        $countersModelHandelError = [
            [],[  "Lee Sin"],["Graves","Syndra"],["Aphelios"],["Nautilus"]
        ];

        $countersStruct = [
            [],[],[],[],[]
        ];

        $checkStruct = $this->arrayStructure($countersStruct, $counterData, $errors);


        return $counterData == $countersModel and $countersModelHandelError == $countersDataHandelError and $countersModelHandelError == $countersDataHandelError2 and $checkStruct;
    }

    public function testSimpleCounter(){
        $simpleCounterData = simpleCounter("darius", "top");

        $simpleCounterModel = [
            ["Camille"]
        ];
        $simpleCounterStruct = [
            []
        ];

        $checkStruct = $this->arrayStructure($simpleCounterStruct, $simpleCounterData, $errors);

        return $simpleCounterModel == $simpleCounterData and $checkStruct;
    }

    public function testAllLaneCounter(){
        $allLaneCounterData = allLaneCounter("janna");


        $allLaneCounterModel = [
            [ "Yorick", "Gragas", "Gwen", "Kennen", "Jayce"],[ "Jarvan IV"],[],[],[ "Rakan", "Leona"]
        ];
        $allLaneCounterStruct = [
            [],[],[],[],[]
        ];
        $checkStruct = $this->arrayStructure($allLaneCounterStruct, $allLaneCounterData, $errors);

        return $allLaneCounterModel == $allLaneCounterData and $checkStruct;
    }
}
$test = new DraftTest();
var_dump($test->testModel());
var_dump($test->testCounter());
var_dump($test->testSimpleCounter());
var_dump($test->testAllLaneCounter());
