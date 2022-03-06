<?php 

require(__DIR__ .'/getDataReadable.php');


function counters(String $top,String $jungle,String $mid,String $adc,String $support){

    $data = returnData(); // get pro match stat

    $champions = [ // all champion
        strtolower($top),
        strtolower($jungle),
        strtolower($mid),
        strtolower($adc),
        strtolower($support)
    ];

    $counter = []; // set counters array
    
    foreach ($champions as $index => $champion) { // loop on all champ
        $defeatCounter = []; // set the defeat counter to tell you what to pick
        $allCounters = [];

        foreach ($data as $game) { // on each game
            if (strtolower($game[1][$index]) === $champion) {
                if(array_key_exists($game[0][$index], $defeatCounter)){
                    $defeatCounter[$game[0][$index]] = $defeatCounter[$game[0][$index]] + 1;
                } else {
                    $defeatCounter[$game[0][$index]] = 1;  
                }
            }
        }

        if (count($defeatCounter) > 0) {

            $hightestDefeat = max($defeatCounter);
    
            while (true) { // get all counters

                if (count($defeatCounter) > 0) {
                    $newHighestDefeat = max($defeatCounter);
                    $hightestChampion = array_search($hightestDefeat, $defeatCounter);
                    if ($hightestDefeat === $newHighestDefeat){
                        array_push($allCounters, $hightestChampion);
                        unset($defeatCounter[$hightestChampion]);
                    } else {
                        break;
                    }
                } else {
                    break;
                }

            }
    
            array_push($counter, $allCounters);
            $allCounters = [];

        } else {
            array_push($counter, []);
        }

    }
    return $counter;
}

// $result = counters("", "Viego", "ahri", "Samira", "Leona"); // function test
// var_dump($result);
?>