<?php

namespace royalWars;

/**
 * Class Pikeman
 * @package royalWars
 */
class Pikeman extends RegimentUnit
{
    /**
     * Pikeman constructor.
     */
    public function __construct()
    {
        $this->startPower = 5;
        $this->trainingExtraPower = 3;
        $this->trainingCost = 10;
        $this->transformationCost = 30;
    }

    /**
     * @inheritDoc
     */
    public function canBeTransformed()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getTransformationNewModel()
    {
        return new Archer();
    }

    /**
     * @inheritDoc
     */
    public function getCurrentType()
    {
        return RegimentUnit::UNITY_PIKEMAN;
    }
}