<?php 

require(__DIR__ .'/getDataReadable.php');

function findCounterOfChamp($roleId, $champion) {

    $data = returnData(); // get pro match stat
    $defeatCounter = []; // defeat by champ counter
    $allCounters = []; // all counters from lane

    foreach ($data as $game) { // on each game find when champ lsoe the game
        if (strtolower($game[1][$roleId]) === strtolower($champion)) {
            if(array_key_exists($game[0][$roleId], $defeatCounter)){
                $defeatCounter[$game[0][$roleId]] = $defeatCounter[$game[0][$roleId]] + 1;
            } else {
                $defeatCounter[$game[0][$roleId]] = 1;  
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

                }else {
                    break;
                }
            } else {
                break;
            }
        }
        return $allCounters;
    } else {
        return [];
    }
}

function counters(String $top,String $jungle,String $mid,String $adc,String $support){

    $champions = [ // all champion
        strtolower($top),
        strtolower($jungle),
        strtolower($mid),
        strtolower($adc),
        strtolower($support)
    ];

    $counter = []; // set counters array
    
    foreach ($champions as $index => $champion) { // loop on all champ

        $answer = findCounterOfChamp($index, $champion);
        array_push($counter, $answer);

    }
    return $counter;
}

function simpleCounter(String $champion, String $role) {

    $data = returnData(); // get pro match stat
    $counter = []; // set counters array

    switch (strtolower($role)) {
        case "top":
            $roleId = 0;
            break;
        case "jungle":
            $roleId = 1;
            break;
        case "mid":
            $roleId = 2;
            break;
        case "adc":
            $roleId = 3;
            break;
        case "support":
            $roleId = 4;
            break;
    }

    $defeatCounter = []; // set the defeat counter to tell you what to pick
    $allCounters = [];

    $answer = findCounterOfChamp($roleId, $champion);
    array_push($counter, $answer);

    return $counter;
}

function allLaneCounter(String $champion) {

    $counter = []; // set counters array

    $laneCount = 0;

    for ($i=0; $i <= 4; $i++) { 

        $answer = findCounterOfChamp($i, $champion);

        array_push($counter, $answer);
        $laneCount += 1;
    }

    return $counter;
}

$result = counters("gwen", "nidalee", "ahri", "Samira", "Renata Glasc"); // function test
$result2 = simpleCounter("janna", "top"); // function test
$result3 = allLaneCounter("janna"); // function test
// var_dump($result);
// var_dump($result2);
// var_dump($result3);

?>