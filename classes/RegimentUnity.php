<?php


namespace classes;

use classes\interfaces\IEvolveable;
use classes\interfaces\ITrainnable;

/**
 * Class RegimentUnity
 * @package classes
 */
abstract class RegimentUnity implements ITrainnable, IEvolveable
{
    /**
     * Possibles Unities types
     */
    const UNITY_PIKEMAN = 'pikeman';
    const UNITY_ARCHER = 'archer';
    const UNITY_KNIGHT = 'knight';
    
    /**
     * @var integer
     */
    protected $startPower;

    /**
     * @var integer
     */
    protected $trainingExtraPower;

    /**
     * @var integer
     */
    protected $trainingCost;

    /**
     * @var integer
     */
    protected $trainingQuantity = 0;

    /**
     * @var integer
     */
    protected $transformationCost;

    /**
     * @inheritDoc
     */
    public function getTotalPower()
    {
        return $this->startPower + ( $this->trainingExtraPower * $this->trainingQuantity );
    }

    /**
     * @inheritDoc
     */
    public function getTransformationCost()
    {
        return $this->transformationCost;
    }

    /**
     * @inheritDoc
     */
    public function getTrainingCost()
    {
        return $this->trainingCost;
    }

    /**
     * @inheritDoc
     */
    public function startTraining()
    {
        $this->trainingQuantity = $this->trainingQuantity + 1;
    }
}