<?php

class Universe
{

    /**
     * @var array
     */
    private $cells;

    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    public function getNumRows(): int
    {
        return count($this->cells);
    }

    public function getNumCols(): int
    {
        return count($this->cells[0]);
    }

    public function getCells(): array
    {
        return $this->cells;
    }

    public function setCells(array $cells)
    {
        $this->cells = $cells;
    }

    public function flipCellAt(int $row, int $col)
    {
        $this->cells[$row][$col] = !$this->cells[$row][$col];
    }

    public function countNeighbours(int $row, int $col): int
    {
        $count = 0;
        // Previous row
        $count += isset($this->cells[$row - 1][$col - 1]) ? $this->cells[$row - 1][$col - 1] : 0;
        $count += isset($this->cells[$row - 1][$col]) ? $this->cells[$row - 1][$col] : 0;
        $count += isset($this->cells[$row - 1][$col + 1]) ? $this->cells[$row - 1][$col + 1] : 0;
        // Same row
        $count += isset($this->cells[$row][$col - 1]) ? $this->cells[$row][$col - 1] : 0;
        $count += isset($this->cells[$row][$col + 1]) ? $this->cells[$row][$col + 1] : 0;
        // Next row
        $count += isset($this->cells[$row + 1][$col - 1]) ? $this->cells[$row + 1][$col - 1] : 0;
        $count += isset($this->cells[$row + 1][$col]) ? $this->cells[$row + 1][$col] : 0;
        $count += isset($this->cells[$row + 1][$col + 1]) ? $this->cells[$row + 1][$col + 1] : 0;
        return $count;
    }

    public function getCellAt(int $row, int $col): int
    {
        return $this->cells[$row][$col];
    }
}
