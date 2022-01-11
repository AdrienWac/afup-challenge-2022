<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;

class Ship {
    
    public string $name;
    public int $size;
    public int $identifiant;
    public string $state; 
    public array $coordinates = [];

    function __construct(string $name, int $size, int $identifiant) {
        $this->name = $name;
        $this->size = $size;
        $this->identifiant = $identifiant;
        $this->state = Constants::getStateAliveShip();
    }

    public function setCoordinates(array $coordinates) {
        $this->coordinates = $coordinates;
    }

    public function getState() {
        return $this->state;
    }

    /**
     * Bateau touché. 
     * - Retire la coordonnée visée du tableau des coordonnées du bateau.
     * - Mise à jour de l'état du bateau si coulé
     *
     * @param array $targetedCoordinates Cordonnées visées
     * @return void
     */
    public function beShot(array $targetedCoordinates): void
    {
        // Cherche la clé de la coordonnée visée dans $this->setCoordinates
        $keyTargetedCoordinates = array_search($targetedCoordinates, $this->coordinates);

        if ($keyTargetedCoordinates === false) {
            $stringTargetedCoordinates = implode(',', $targetedCoordinates);
            throw new \Exception(`Les coordonnées {$stringTargetedCoordinates} ne font pas partie de la position du bateau`);
        }
 
        // Puis on unset
        unset($this->coordinates[$keyTargetedCoordinates]);

        // Si empyt $this->coordinates
        if (empty($this->coordinates)) {
            $this->state = Constants::getStateSunkShip();
        }

    }

}