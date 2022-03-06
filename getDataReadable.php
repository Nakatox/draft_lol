<?php

function returnData(){

    $file = fopen("data.csv", "r");
    $wintab = [];
    $loosetab = [];
    $games = [];
    
    while(($line = fgetcsv($file, 0, ";")) !== FALSE) {
        if ($line[5] != ""){
            if ($line[9] == 1){
                array_push($wintab, $line[8]); 
            } else {
                array_push($loosetab, $line[8]); 
            }
            if ((count($wintab) == 5) and (count($loosetab) == 5)){
                $games[] = [
                    $wintab,
                    $loosetab
                ];
                $wintab = [];
                $loosetab = [];
            }
        }
    }

    return $games;
}