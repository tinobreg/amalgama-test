<?php

namespace classes\interfaces;

/**
 * Interface ITrainable
 * @package classes\interfaces
 */
interface ITrainable
{
    /**
     * Add a workout to the count
     * @return boolean
     */
    public function startTraining();

    /**
     * Returns the total power
     * @return integer
     */
    public function getTotalPower();

    /**
     * Returns the training cost
     * @return integer
     */
    public function getTrainingCost();
}