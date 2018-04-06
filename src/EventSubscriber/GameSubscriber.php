<?php

namespace App\EventSubscriber;

use App\Game\GameEvent;
use App\Game\Events;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GameSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GameSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param GameEvent $event
     */
    public function logGameStart(GameEvent $event): void
    {
        $player = $event->getPlayer();
        throw new \Exception("dfsdf");
        $this->logger->info(sprintf('Game started by player "%s"', $player->getUsername()));
    }

    /**
     * @param GameEvent $event
     */
    public function logGameResult(GameEvent $event): void
    {
        $player = $event->getPlayer();
        $game = $event->getGame();
        $this->logger->info(sprintf(
            'Game result: "%s", Word to guess: "%s", Player "%s"',
            $game->isWon() ? 'WON' : 'FAILED',
            $game->getWord(),
            $player->getUsername()
        ));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::GAME_START => 'logGameStart',
            Events::GAME_OVER => 'logGameResult',
        ];
    }
}