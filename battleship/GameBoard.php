<?php

namespace Battleship;

require "vendor/autoload.php";

class GameBoard {

    private array $size;
    private array $board;
    private array $ships;

    function __construct(array $size, mixed $value)
    {
        $this->size = $size;
        [$numberMaxRow, $numberMaxCol] = $size;
        $this->board = array_fill(0, $numberMaxRow, array_fill(0, $numberMaxCol, $value));
    }

    /**
     * Get the current game board
     *
     * @return array
     */
    public function getBoard(): array {
        return $this->board;
    }

    /**
     * Set cell value of game board
     *
     * @param array $coordinates Table coordinates of cell
     * @param string $value New value for cell
     * @return void
     */
    public function setBoard(array $coordinates, string $value) {
        [$rowNumber, $colNumber] = $coordinates;
        $this->board[$rowNumber][$colNumber] = $value;
    }

    /**
     * Helper method to visualize game board
     *
     * @return void
     */
    public function draw()
    {

        $result = [];

        array_map(function ($array) use (&$result) {
            $result[] = implode('', $array);
        }, $this->board);

        print_r($result);

    }
    
    /**
     * Place randomly ships on board
     *
     * @param array $ships Array of ships to place
     * @return void
     */
    public function placeShipsOnBoard(array $ships) {

        // On récupère le tableau des cellules déjà occupés
        
        // Pour chaque bateau
            
            // J''initialise un tableau vide des points visités
            
            // Tant que tout les points libres ne sont pas visités ou que je n'ai pas trouvé tout les points du bateau (compare attribut size et taille attribut position du bateau courant)

                // Je cherche un point au hasard
                    // Je cherche un point compris entre 0 taille du board - 1 
                    // et qui n'est pas la tableau des cellules déjà occupées 
                    // et qui n'est pas dans les points déjà visités
                    // J'ajoute ce point au tableau des points visités
                    // Je retourne le point

                // Calculer les points pour chaque orientation et direction à partir du point de départ trouvé au hasard
                    // Pour chaque orientation
                        // Pour chaque direction
                            // J'initialise un tableau de point vide
                            // Pour chaque case de la taille du bateau
                                // Je calcul le point
                                // J'ajoute ce point au tableau des points visités (à passer en référence)
                                // Si le point n'est pas dans le board
                                    // Je passe à la direction suivante
                                // Fin si
                                // Si le point n'est pas libre
                                    // Je passe à la direction suivante
                                // Fin si
                                // Je stocke le point
                            // Fin pour
                            // Je retourne tout mes points stockés ça sera la position de mon tableau
                        // Fin pour
                    // Fin pour 
                    // Je retourne un tableau vide
                // Fin fonction

                // Si point calculer vide 
                    // Continue la boucle while, je repars au début chercher un point au hasard
                // Fin si
                
                // Pour chaque point 
                    // Je dépose le bateau sur le board
                        // Je met à jour le board avec l'id du bateau dans la case
                    // Fin
                    // J'ajoute le point au tableau des cellules déjà occupés
                // Fin pour

                // Je mets à jour l'attribut position du bateau avec le tableau des points
                
            // Fin while
            
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function getOccupiedCells(): array {
        return [];
    }

    /**
     * Test if cell is available for place a ship.
     *
     * @param array $coordinates Coordinates table
     * @return boolean Is available or not
     */
    public function isAvailableCell(array $coordinates) {

        [$rowNumber, $colNumber] = $coordinates;

        return !in_array($this->board[$rowNumber][$colNumber], array_keys($this->ships));

    }

    /**
     * Test if coordinates is in the board
     *
     * @param array $coordinates
     * @return boolean
     */
    private function isInTheBoard(array $coordinates) {
        return true;
    }

}