<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class AppleTest extends TestCase
{
    public function testUniqIdGenerated(): void
    {
        $treeApple = new \Model\Apple();
        $this->assertNotEmpty($treeApple->getId());
    }

    public function testRightTreeType(): void
    {
        $treeApple = new \Model\Apple();
        $this->assertEquals("apple", $treeApple->getType());
    }

    public function testInRange(): void
    {
        $treeApple = new \Model\Apple();
        $fruits=$treeApple->harvestTree();
        $this->assertLessThanOrEqual(50, $fruits["product"]);
        $this->assertGreaterThanOrEqual(40, $fruits["product"]);
    }
}