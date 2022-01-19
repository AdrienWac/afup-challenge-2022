<?php

namespace Battleship\Strategy;

require "vendor/autoload.php";

use Battleship\Constants;
use Battleship\Main;
use Battleship\ProbabilityBoard;
use Battleship\Ship;
use Battleship\ShootHistoric;
use Battleship\Strategy\IStrategy;

/**
 * Stratégie de cible après un tir réussi
 */
class TargetStrategy implements IStrategy
{

    public ProbabilityBoard $probabilityBoard;

    private string $currentOrientation;
    private string $currentDirection;

    public function __construct(public array $size = [10, 10], public array &$ships = [], public array &$arrayCellsVisited = [], public ShootHistoric &$shootHistoric)
    {
        $this->size = $size;
        $this->ships = $ships;
        $this->arrayCellsVisited = $arrayCellsVisited;
        $this->shootHistoric = $shootHistoric;
        $this->stackShoot = [];

    }

    public function shoot(): array
    {   

        // Si dernier shoot est un hit en mode cible dans l'historique
        //     // Je calcul les coordonnées de la nouvelle case à partir des coordonnées et la direction du shoot
        //     // Si ces coordonnées sont dans le board et pas visitées
        //         // Je retourne ces coordonnées
        //     // FinSi
        // Fin Si

        // Je récupère la case environnante (la case cible) avec la meilleure proba (je stocke la direction, et l'orientation de cette case en fonction de la case cible)
        // & je stocke toutes les autres dans la stack à shoot par ordre de proba
        // (Si toutes les cases avec même proba => choix random) 

        // Je retourne les coordonnées de cette case avec la meilleure proba

        return [0, 0];
    }

    public function generateBoard(): ProbabilityBoard
    {
        $this->setTargetCellCoordinates();

        $this->probabilityBoard = new ProbabilityBoard($this->size, $this->ships, $this->arrayCellsVisited);
        // On calcul la probabilité des cases autour de la case cible

        $arrayDirectionsByOrientation = Main::getDirectionsByOrientation();

        foreach ($this->ships as $ship) {
            
            foreach ($arrayDirectionsByOrientation as $orientation => $arrayDirections) {
                
                foreach ($arrayDirections as $direction) {

                    // TODO On initialise la valeur de proba à 1 si le dernier tir touché est dans cette direction
                    // $probabilityValue = Si la direction du dernier tir touché === $direction ? 1 : 0
                    $probabilityValue = 0;
                    $probabilityValue += $this->probabilityBoard->calculProbabilitiesValueByDirection($ship, $this->coordinatesTargetCell, $direction);

                    if ($probabilityValue > 0) {
                        $newCoordinates = $this->probabilityBoard->calculCoordinatesByDirection($this->coordinatesTargetCell, $direction, 1);
                        $this->probabilityBoard->board[$newCoordinates[0]][$newCoordinates[1]] += $probabilityValue;
                    }

                }

            }

        }

        return $this->probabilityBoard;

    }

    /**
     * Mise à jour des coordonnées de la case cible en fonction de l'historique de tir
     *
     * @return void
     */
    public function setTargetCellCoordinates(): void
    {

        $lastShootInformation = $this->shootHistoric->getLastShootInformation();

        if ($lastShootInformation['result'] === 'hit' && in_array($lastShootInformation['mode'], [Constants::getHuntMode(), Constants::getTargetMode()])) {
            $this->coordinatesTargetCell = $lastShootInformation['arrayCoordinates'];
            return;
        }

        // Si dernier shoot est un miss en mode cible dans l'historique
        if ($lastShootInformation['result'] === 'hit' && $lastShootInformation['mode'] == Constants::getTargetMode()) {

            if (empty($this->stackShoot)) {
                throw new \Exception('Pas de coordonnées de tir en réserve. Passer en mode chasse.');
            }

            $this->coordinatesTargetCell = array_shift($this->stackShoot);

        }

        if ($lastShootInformation['result'] === 'skunk') {
            throw new \Exception('Le dernier tir à couler un bateau. Passer en mode chasse.');
        }

    }

    public function getCurrentOrientation(): ?string
    {
        return $this->currentOrientation;
    }

    public function getCurrentDirection(): ?string
    {
        return $this->currentDirection;
    }



}
