<?php


namespace classes\interfaces;

/**
 * Interface ITransformable
 * @package classes\interfaces
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