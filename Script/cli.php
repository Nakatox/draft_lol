#!/usr/bin/php

<?php
if (php_sapi_name() !== 'cli') {
    exit;
}

require(__DIR__ .'/../counter.php');

require(__DIR__ . '/vendor/autoload.php');

use Draftcli\App;

$app = new App();

$app->registerCommand('Draft', function (array $argv) use ($app) {    
    
    function isAChampion( $championGiven ) {
        $champions = file_get_contents("../scrapping/champions.json");
        $decoded_json = json_decode($champions, false);
        $response = false;
        foreach($decoded_json as $value) {
            if (strtolower($value->name) == strtolower($championGiven)) {
                $response = true;
                break;
            }
        }
        return $response;
    }

    function showItemAndChampion ($championGiven) {
        $champions = file_get_contents("../scrapping/champions.json");
        $decoded_json = json_decode($champions, false);

        $result = '';
        foreach($decoded_json as $value) {
            if (strtolower($value->name) == strtolower($championGiven)) {
                $ItemOfChamp = '';
                foreach($value->popularItems as $item){
                    $ItemOfChamp .= $item->name . ' ; ';
                }
                $resultAdd = $championGiven.' '.': '.'[PopularItems] => '. $ItemOfChamp.' [Boots] => '.$value->boot->name."\n"."\n" ;
                $result .= $resultAdd;
            }
        }
        return $result;
    }

    for ($i=0; $i < 5; $i++) {
        switch ($i) {
            case 0:
                $line = readline("Qui est le Top : ");

                readline_add_history($line);
                $isChampion = isAChampion(readline_list_history()[$i]);
                if ( !$isChampion) {
                    return;
                } 

                break;
            case 1:
                $line = readline("Qui est le Jungle : ");

                if (!in_array($line,readline_list_history())) {
                    readline_add_history($line);
                    $isChampion = isAChampion(readline_list_history()[$i]);
                    if (!$isChampion) {
                        return;
                    } 
                } else {
                    return;
                }

                break;
            case 2:
                $line = readline("Qui est le Mid : ");

                if (!in_array($line,readline_list_history())) {
                    readline_add_history($line);
                    $isChampion = isAChampion(readline_list_history()[$i]);
                    if (!$isChampion) {
                        return;
                    } 
                } else {
                    return;
                }
                break;
            case 3:
                $line = readline("Qui est l'Adc : ");

                if (!in_array($line,readline_list_history())) {
                    readline_add_history($line);
                    $isChampion = isAChampion(readline_list_history()[$i]);
                    if ( !$isChampion) {
                        return;
                    } 
                } else {
                    return;
                }
                break;
            case 4:
                $line = readline("Qui est le Support : ");

                if (!in_array($line,readline_list_history())) {
                    readline_add_history($line);
                    $isChampion = isAChampion(readline_list_history()[$i]);
                    if ( !$isChampion) {
                        return;
                    } 
                } else {
                    return;
                }
                break;
        }
    }

    $top = strtolower(readline_list_history()[0]) ;
    $jungle = strtolower(readline_list_history()[1]);
    $mid = strtolower(readline_list_history()[2]);
    $adc = strtolower(readline_list_history()[3]);
    $support = strtolower(readline_list_history()[4]);


    // ------------------------------------------------------------------------------------------

    $counterMatchup = counters($top, $jungle, $mid, $adc, $support);
    $stock = '';
    foreach($counterMatchup as $counteredChamp ) {
        foreach($counteredChamp as $champion) {
            $stock .= showItemAndChampion($champion);
        }
    }
    $app->getPrinter()->display("Here are the champions and items that counter the compo given : \n \n".$stock);
    // var_dump($stock);
});

$app->registerCommand('help', function (array $argv) use ($app) {
    $app->getPrinter()->display("usage: minicli hello [ your-name ]");
});

$app->runCommand($argv);