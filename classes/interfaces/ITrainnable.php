<?php

namespace classes\interfaces;

/**
 * Interface ITrainnable
 * @package classes\interfaces
 */
interface ITrainnable
{
    /**
     * @return boolean
     */
    public function startTraining();

    /**
     * @return integer
     */
    public function getTotalPower();

    /**
     * @return integer
     */
    public function getTrainingCost();
}