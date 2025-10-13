<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Entity\Game;
use App\Domain\Repository\GameRepositoryInterface;
use App\Domain\Repository\WordRepositoryInterface;


final class GameService
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private WordRepositoryInterface $wordRepository,
        private int $maxAttempts
    ) {

    }

    public function startNewGame( string $sessionId): Game
    {

        $word = $this->wordRepository->randomWord();
        $game = new Game($word, $this->maxAttempts);
        $this->gameRepository->save($game,$sessionId);
        return $game;
    }


    public function getCurrentGame(string $sessionId): ?Game
    {
        return $this->gameRepository->find($sessionId);
    }

    
    public function resetGame(string $sessionId): void
    {
        $this->gameRepository->delete($sessionId);
    }
}