<?php

namespace Model;

abstract class Tree
{
    protected string $id;
    protected string $type = 'tree';

    public function __construct()
    {
        $this->id = uniqid($this->type . "_");
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    abstract public function harvestTree();
}