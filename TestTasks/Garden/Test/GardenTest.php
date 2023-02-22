<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GardenTest extends TestCase
{
    public function testAdditionToGarden(): void
    {
        $treeApple = new \Model\Apple();
        $garden = new \Model\Garden();
        $garden->addNewTree($treeApple);
        $this->assertEquals(1,count($garden->getGarden()["apple"]));

    }

    public function testAdditionToBarn(): void
    {
        $treeApple = new \Model\Apple();
        $garden = new \Model\Garden();
        $garden->addNewTree($treeApple);
        $garden->harvest();
        $this->assertNotEmpty($garden->getBarn()["apple"]);

    }
}