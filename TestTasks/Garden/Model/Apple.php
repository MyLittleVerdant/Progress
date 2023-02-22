<?php

namespace Model;

class Apple extends Tree
{
    protected string $type = 'apple';

    public function harvestTree(): array
    {
        return ['type' => $this->getType(), 'product' => rand(40, 50)];
    }

}