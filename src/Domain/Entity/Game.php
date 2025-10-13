<?php

declare(strict_types=1);

namespace App\Domain\Entity;


class Game
{
    private string $word;
    private int $maxAttempts;
    private int $attemptsLeft;
    private array $usedLetters;

    public function __construct(string $word, int $maxAttempts = 6, ?array $state = null)
    {
        if ($state) {
            $this->word = $state['word'];
            $this->maxAttempts = $state['maxAttempts'];
            $this->attemptsLeft = $state['attemptsLeft'];
            $this->usedLetters = $state['usedLetters'];
        } else {
            $this->word = strtoupper($word);
            $this->maxAttempts = $maxAttempts;
            $this->attemptsLeft = $maxAttempts;
            $this->usedLetters = [];
        }
    }

    public function guessLetter(string $letter): void
    {
        $letter = strtoupper($letter);
        if (!in_array($letter, $this->usedLetters)) {
            $this->usedLetters[] = $letter;
        }
        if (strpos($this->word, $letter) === false) {
            $this->attemptsLeft--;
        }
    }
    public function getMaskedWord(): string
    {
        $maskedword = "";
        foreach (str_split($this->word) as $letter) {
            $maskedword .= in_array($letter, $this->usedLetters) ? $letter : "_";
        }
        return $maskedword;
    }
    public function getAttemptsLeft(): int
    {
        return $this->attemptsLeft;
    }
    public function getUsedLetters(): array
    {
        return $this->usedLetters;
    }
    public function isWon(): bool
    {
        return $this->getMaskedWord() === $this->word;
    }
    public function isLost(): bool
    {
        return $this->attemptsLeft <= 0;
    }
    public function getWord(): string
    {
        return $this->word;
    }
    public function toState(): array
    {
        return [
            'word' => $this->word,
            'maxAttempts' => $this->maxAttempts,
            'attemptsLeft' => $this->attemptsLeft,
            'usedLetters' => $this->usedLetters
        ];
    }
}
