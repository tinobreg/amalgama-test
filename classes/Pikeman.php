<?php

namespace classes;

/**
 * Class Pikeman
 * @package classes
 */
class Pikeman extends RegimentUnity
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
    public function canMakeTransformation()
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
        return RegimentUnity::UNITY_PIKEMAN;
    }
}