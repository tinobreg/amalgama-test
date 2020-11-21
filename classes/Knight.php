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
    public function canBeTransformed()
    {
        return false;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getTransformationNewModel()
    {
        throw new \Exception('Esta unidad no puede ser transformada');
    }

    /**
     * @inheritDoc
     */
    public function getCurrentType()
    {
        return RegimentUnity::UNITY_KNIGHT;
    }
}