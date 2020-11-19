<?php

namespace classes;

/**
 * Class Archer
 * @package classes
 */
class Archer extends RegimentUnity
{

    /**
     * Archer constructor.
     */
    public function __construct()
    {
        $this->startPower = 10;
        $this->trainingExtraPower = 7;
        $this->trainingCost = 20;
        $this->transformationCost = 40;
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
        return new Knight();
    }

    /**
     * @inheritDoc
     */
    public function getCurrentType()
    {
        return RegimentUnity::UNITY_ARCHER;
    }
}