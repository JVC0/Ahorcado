<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class WordProvider
{
    private array $palabras = [];
    public function __construct(
        private string $filePath,
    ) {}

    public function randomWord(): string
    {

        $this->palabras = explode(",", file_get_contents($this->filePath));
        $this->palabras = array_filter(array_map('trim', $this->palabras));
        return $this->palabras[array_rand($this->palabras)];
    }
}
