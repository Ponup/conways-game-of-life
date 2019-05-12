<?php

class Life
{
    /**
     * @var Universe
     */
    private $universe;

    private $generation;

    public function __construct(Universe $universe)
    {
        $this->universe = $universe;
        $this->generation = 0;
    }

    public function evolve()
    {
        $newuniverse = $this->universe->getCells();
        for ($r = 0; $r < $this->universe->getNumRows(); $r++) {
            for ($c = 0; $c < $this->universe->getNumCols(); $c++) {
                $newuniverse[$r][$c] = $this->tick($r, $c);
            }
        }
        $this->universe->setCells($newuniverse);
        $this->generation++;
    }

    public function getGeneration(): int
    {
        return $this->generation;
    }

    private function tick(int $row, int $col): int
    {
        $new = null;
        $current = $this->universe->getCellAt($row, $col);
        $numAliveNeighbours = $this->universe->countNeighbours($row, $col);
        if (1 === $current) {
            if (in_array($numAliveNeighbours, [0, 1])) { // Die lonely
                $new = 0;
            } elseif (in_array($numAliveNeighbours, [4, 5, 6, 7, 8])) { // Die overcrowded
                $new = 0;
            } elseif (in_array($numAliveNeighbours, [2, 3])) {
                $new = 1;
            }
        } else {
            if ($numAliveNeighbours === 3) { // Birth
                $new = 1;
            } else { // Barren
                $new = 0;
            }
        }
        return $new;
    }
}
