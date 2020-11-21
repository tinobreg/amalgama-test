<?php


namespace royalWars\interfaces;

/**
 * Interface ITransformable
 * @package royalWars\interfaces
 */
interface ITransformable
{
    /**
     * Returns if can be transformed
     * @return boolean
     */
    public function canBeTransformed();

    /**
     * Returns the transformation cost
     * @return integer
     */
    public function getTransformationCost();

    /**
     * Returns the transformation new model
     * @return integer
     */
    public function getTransformationNewModel();
}