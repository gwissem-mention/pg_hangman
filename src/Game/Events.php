<?php

namespace App\Game;

class Events
{
    /**
     * When the game starts
     */
    public const GAME_START = 'game.start';

    /**
     * When the game ends
     */
    public const GAME_OVER = 'game.over';

    /**
     * When the game is won
     */
    public const GAME_WON = 'game.won';

    /**
     * When the game is lost
     */
    public const GAME_FAILED = 'game.failed';
}
