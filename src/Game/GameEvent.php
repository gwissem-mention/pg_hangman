<?php

namespace App\Game;

use App\Entity\Player;
use Symfony\Component\EventDispatcher\Event as BaseEvent;

class GameEvent extends BaseEvent
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var Game
     */
    private $game;

    /**
     * GameEvent constructor.
     * @param Player $player
     * @param Game $game
     */
    public function __construct(Player $player, Game $game)
    {
        $this->player = $player;
        $this->game = $game;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }
}
