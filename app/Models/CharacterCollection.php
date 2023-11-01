<?php


namespace App\Models;

class CharacterCollection
{

    private array $characters;

    public function __construct(array $characters = [])
    {
        $this->characters = [];
        foreach ($characters as $character) {
            if (!$character instanceof Character)
                continue;
            $this->add($character);
        }
    }

    public function add(Character $character): void
    {
        $this->characters[] = $character;
    }


    public function getCharacters(): array
    {
        return $this->characters;
    }


}