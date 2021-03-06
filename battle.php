<?php
declare(strict_types=1);

require "vendor/autoload.php";

use Battleship\Main;
// OK Gestion du placement des bateaux
// OK Gestion de réception du tir
// TODO Init plateau avec distributions de probabilités
// TODO Gestion du traitement de la réponse
// TODO Gestion du tir
    // Ajout des coordonnées du tir dans la memoïzation
    // Update plateau avec distributions de probabiltés

$game = new Main([10,10]);

$count = 5;
while (true) {
    $command = fgets(STDIN);
    if ($command === false) {
        die('error could not read STDIN');
    }
    $command = trim($command);

    
    // Tirer
    if ($command === 'your turn') {

        $game->shoot();

    } elseif (preg_match('`^([A-J](?:[1-9]|10))$`i', $command)) { // Recevoir un coup

        try {
            echo $game->handlingEnemyFire($command);
        } catch (\Throwable $th) {
            echo 'Impossible de traiter le tir ennemi';
        }

    } elseif (preg_match('`^hit|miss|sunk$`i', $command)) { // Recevoir un résultat de l'adversaire
        $game->handlingEnemyAnswer($command);
        echo "ok\n";
    } elseif ($command === 'won') { // Recevoir le résultat de victoire
        echo "ok\n";
        break;
    } else { // Sinon recevoir un message d'erreur avec explication
        die("error Can't understand '$command'\n");
    }
}