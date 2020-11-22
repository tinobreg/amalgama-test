<?php

namespace royalWars;

/**
 * Class Knight
 * @package royalWars
 */
class Knight extends RegimentUnit
{
    /**
     * Knight constructor.
     */
    public function __construct()
    {
        $this->startPower = 20;
        $this->trainingExtraPower = 10;
        $this->trainingCost = 30;
    }

    /**
     * @inheritDoc
     */
    public function getCurrentType()
    {
        return RegimentUnit::UNITY_KNIGHT;
    }
}