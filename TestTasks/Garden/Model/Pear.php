<?php

namespace Model;

class Pear extends Tree
{
    protected string $type = 'pear';

    public function harvestTree(): array
    {
        return ['type' => $this->getType(), 'product' => rand(0, 20)];
    }
}