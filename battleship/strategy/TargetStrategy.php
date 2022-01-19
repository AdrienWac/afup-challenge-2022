<?php

namespace Battleship\Strategy;

require "vendor/autoload.php";

use Battleship\Main;
use Battleship\ProbabilityBoard;
use Battleship\Ship;
use Battleship\Strategy\IStrategy;
use SplDoublyLinkedList;

/**
 * Stratégie de cible après un tir réussi
 */
class TargetStrategy implements IStrategy
{

    public ProbabilityBoard $probabilityBoard;

    private string $currentOrientation;
    private string $currentDirection;

    public function __construct(public array $size = [10, 10], public array &$ships = [], public array &$arrayCellsVisited = [], public SplDoublyLinkedList &$shootHistoric)
    {
        $this->size = $size;
        $this->ships = $ships;
        $this->arrayCellsVisited = $arrayCellsVisited;
        $this->shootHistoric = $shootHistoric;

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

    public function setTargetCellCoordinates(): void
    {
        // Si dernier shoot est un hit en mode chasse dans l'historique
        //     // La case cible est celle de ce tir
        // FIN 

        // Si dernier shoot est un hit en mode cible dans l'historique
        //     // La case cible est celle de ce tir
        // FIN

        // Si dernier shoot est un miss en mode cible dans l'historique
        //     Si la stack à shoot est vide ==> Je retourne null (on devra repasser en mode chasse dans ce cas)
        //     Sinon Je prend la première dans la stack à shoot
        // FIN

        // Si dernier shoot est un skunk  (Ce n'est pas possible normalement)
        //     Je retourne null (on devra repasser en mode chasse dans ce cas)
        // FIN

        $this->coordinatesTargetCell = [0,0];
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
