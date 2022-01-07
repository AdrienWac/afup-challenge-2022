<?php
declare(strict_types=1);

require "vendor/autoload.php";

use Battleship\Game;
// TODO Gestion du placement des bateaux
// TODO Init plateau avec distributions de probabilités
// TODO Gestion du tir
    // Ajout des coordonnées du tir dans la memoïzation
    // Update plateau avec distributions de probabiltés
// TODO Gestion de réception du tir

$game = new Game([10,10]);

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

        // Si dernier bateau coulé, l'adversaire gagne
        if ($count-- === 0) {
            echo "won\n";
        } else { // Sinon en fonction du tir => envoie d'un résultat à l'adversaire
            // miss\n : quand aucun bateau n'est touché
            // hit\n : quand un bateau est touché mais pas coulé
            // sunk\n : quand un bateau est coulé
            // won\n : quand le dernier bateau a été coulé
            // error [message d'explication]\n : quand votre concurrent n'a pas envoyé ce que vous attendiez
            echo mt_rand(0, 3) === 0 ? "hit\n" : "miss\n";
        }
    } elseif (preg_match('`^hit|miss|sunk$`i', $command)) { // Recevoir un résultat de l'adversaire
        echo "ok\n";
    } elseif ($command === 'won') { // Recevoir le résultat de victoire
        echo "ok\n";
        break;
    } else { // Sinon recevoir un message d'erreur avec explication
        die("error Can't understand '$command'\n");
    }
}