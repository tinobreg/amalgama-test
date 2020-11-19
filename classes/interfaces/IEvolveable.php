<?php


namespace classes\interfaces;

/**
 * Interface IEvolveable
 * @package classes\interfaces
 */
interface IEvolveable
{
    /**
     * @return boolean
     */
    public function canMakeTransformation();

    /**
     * @return integer
     */
    public function getTransformationCost();

    /**
     * @return integer
     */
    public function getTransformationNewModel();

    /**
     * @return integer
     */
    public function getCurrentType();
}