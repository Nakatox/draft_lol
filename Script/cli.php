#!/usr/bin/php

<?php
if (php_sapi_name() !== 'cli') {
    exit;
}

require(__DIR__ .'/../counter.php');

require(__DIR__ . '/vendor/autoload.php');

use Draftcli\App;

$app = new App();

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
    if ($championGiven) {
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
}

function printTheCounter($data,$app) {
    $stock = '';
    $state = true;
    if ($data) {
        foreach($data as $counteredChamp ) {
            foreach($counteredChamp as $champion) {
                count($counteredChamp) > 0  ? $state = true : $state = false;
                $stock .= showItemAndChampion($champion);
            }
        }
        $state ? $app->getPrinter()->display("Here are the champions and items that counter the compo given : \n \n".$stock): $app->getPrinter()->display("There is no counter found for this matchup. \n \n");
        return;
    } 
}

function printTheSimpleCounter($data,$app) {
    $stock = '';
    $state = true;
    if ($data) {
        foreach($data as $counteredChamp ) {
            count($counteredChamp) > 0  ? $state = true : $state = false;
            foreach($counteredChamp as $champion) {
                $stock .= showItemAndChampion($champion);
            }
        }
        $state ? $app->getPrinter()->display("Here are the champions and items that counter the compo given : \n \n".$stock): $app->getPrinter()->display("There is no counter found for this matchup. \n \n");
        return;
    } 
}

$app->registerCommand('draft', function (array $argv) use ($app) {    
    


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
    return printTheCounter($counterMatchup,$app);
});




$app->registerCommand('simple-counter', function (array $argv) use ($app) {
    $lane = ['top','jungle','mid','adc','support'];

    for($i=0;$i <2; $i++){
        switch ($i){
            case 0:
                $line = readline("Quelle est le champion que vous voulez counter : ");
                readline_add_history($line);
                $isChampion = isAChampion(readline_list_history()[$i]);
                if (!$isChampion) {
                    return;
                } 
                break;
            case 1:
                $line = readline("Sur quelle lane : ");
                if (in_array($line,$lane)) {
                    readline_add_history($line);
                    break;
                }
                return;
        }
    }

    $champion = strtolower(readline_list_history()[0]) ;
    $role = strtolower(readline_list_history()[1]);

    $counterMatchup = simpleCounter($champion, $role);

    return printTheSimpleCounter($counterMatchup,$app);

});


$app->registerCommand('all-counter', function (array $argv) use ($app) {

    $line = readline("Quelle est le champion que vous voulez counter : ");
    readline_add_history($line);
    $isChampion = isAChampion(readline_list_history()[0]);
    if (!$isChampion) {
        return;
    } 
    $champion = strtolower(readline_list_history()[0]) ;
    
    $counterMatchup = allLaneCounter($champion);
    var_dump($counterMatchup);
    return;
    printTheCounter($counterMatchup,$app);

});



$app->registerCommand('help', function (array $argv) use ($app) {
    $app->getPrinter()->display("./cli.php [ draft ] | [ simple-counter ] | [ all-counter ] \n \n");
});


$app->runCommand($argv);
