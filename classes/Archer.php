<?php

namespace royalWars;

use royalWars\interfaces\ITransformable;

/**
 * Class Archer
 * @package royalWars
 */
class Archer extends RegimentUnit implements ITransformable
{

    /**
     * @var integer
     */
    protected $transformationCost;

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
    public function canBeTransformed()
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
        return RegimentUnit::UNITY_ARCHER;
    }

    /**
     * @inheritDoc
     */
    public function getTransformationCost()
    {
        return $this->transformationCost;
    }
}