<?php

namespace Model;

class Garden
{
    private array $barn;
    private array $garden;

    public function addNewTree($tree)
    {
        if (!empty($tree)) {
            $this->garden[$tree->getType()][] = $tree;
        }
    }

    public function getBarn(): array
    {
        return $this->barn;
    }

    public function getGarden(): array
    {
        return $this->garden;
    }

    public function harvest()
    {
        foreach ($this->garden as $trees) {
            foreach ($trees as $tree) {
                $fruits = $tree->harvestTree();
                if (empty($this->barn[$fruits['type']])) {
                    $this->barn[$fruits['type']] = $fruits['product'];
                } else {
                    $this->barn[$fruits['type']] += $fruits['product'];
                }
            }
        }
    }

    public function countFruits()
    {
        foreach ($this->barn as $type => $fruit) {
            echo "Фруктов типа '$type' собрано: $fruit\n";
            echo "<br>";
        }
    }

    public function countTree()
    {
        foreach ($this->garden as $type => $trees) {
            echo "Деревьев типа '$type': " . count($trees) . "\n";
            echo "<br>";
        }
    }
}