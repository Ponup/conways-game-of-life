<?php

class UniverseFactory {

    public function createFromDimensions(int $numRows, int $numCols): Universe
    {
        return new Universe(array_fill(0, $numRows, array_fill(0, $numCols, 0)));
    }

    public function createFromFile(string $filePath): Universe
    {
        return new Universe(json_decode(file_get_contents($filePath), false));
    }
}
