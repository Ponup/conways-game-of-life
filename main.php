<?php
dl('sdl.' . PHP_SHLIB_SUFFIX);

require 'Universe.php';
require 'UniverseFactory.php';
require 'Life.php';

const BaseTitle = 'Conway\'s game of life';
const CellSize = 10;

$universeFactory = new UniverseFactory;

switch ($argc) {
    case 1:
        $universe = $universeFactory->createFromDimensions(50, 100);
        break;
    case 2:
        $universe = $universeFactory->createFromFile($argv[1]);
        break;
    case 3:
        $universe = $universeFactory->createFromDimensions(intval($argv[1]), intval($argv[2]));
        break;
    default;
        fprintf(STDERR, "usage:\n\t%s <numrows> <numcols>\n\t%s <path>\n", $argv[0], $argv[0]);
        exit(1);
}

$numRows = $universe->getNumRows();
$numCols = $universe->getNumCols();

$life = new Life($universe);

// Create window
SDL_Init(SDL_INIT_VIDEO);
$window = SDL_CreateWindow(BaseTitle, SDL_WINDOWPOS_UNDEFINED, SDL_WINDOWPOS_UNDEFINED, $numCols * CellSize, $numRows * CellSize, 0);
$renderer = SDL_CreateRenderer($window, -1, SDL_RENDERER_ACCELERATED);

$run = false;

$lastX = $lastY = -1;
$rect = new SDL_Rect(0, 0, CellSize, CellSize);
$quit = false;
$event = new SDL_Event;

while (!$quit) {
    // Clear screen
    SDL_SetRenderDrawColor($renderer, 0, 0, 0, 255);
    SDL_RenderClear($renderer);

    // Render universe
    for ($r = 0; $r < $numRows; $r++) {
        for ($c = 0; $c < $numCols; $c++) {
            $rect->x = $c * CellSize;
            $rect->y = $r * CellSize;
            $cell = $universe->getCellAt($r, $c);
            if ($cell) {
                SDL_SetRenderDrawColor($renderer, 255, 255, 255, 255);
            } else {
                SDL_SetRenderDrawColor($renderer, 0, 0, 0, 255);
            }
            SDL_RenderFillRect($renderer, $rect);
        }
    }

    // Present renderer
    SDL_RenderPresent($renderer);

    if ($run) {
        SDL_SetWindowTitle($window, BaseTitle . ' - Gen#' . $life->getGeneration());
        $life->evolve();
    }

    while (SDL_PollEvent($event)) {
        switch ($event->type) {
            case SDL_QUIT:
                $quit = true;
                break;
            case SDL_KEYDOWN:
                $quit = $event->key->keysym->sym == SDLK_q;
                if ($event->key->keysym->sym === SDLK_SPACE) {
                    $run = !$run;
                }
                break;
            case SDL_MOUSEMOTION:
                $x = intval($event->motion->y / CellSize);
                $y = intval($event->motion->x / CellSize);
                if ($event->motion->state & SDL_BUTTON_LMASK) {
                    if ($lastX != $x || $lastY != $y) {
                        $universe->flipCellAt($x, $y);
                        $lastX = $x;
                        $lastY = $y;
                    }
                }
                break;
            case SDL_MOUSEBUTTONDOWN:
                $x = intval($event->button->y / CellSize);
                $y = intval($event->button->x / CellSize);
                $universe->flipCellAt($x, $y);
                break;
        }
    }

    SDL_Delay($run ? 400 : 40);
}

SDL_DestroyRenderer($renderer);
SDL_DestroyWindow($window);
SDL_Quit();
