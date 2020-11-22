<?php


namespace royalWars;

/**
 * Class BattleHistory
 * @package royalWars
 */
class BattleHistory
{
    /**
     * @var string $civilization
     */
    private $civilization;

    /**
     * @var string $regimentID
     */
    private $regimentID;

    /**
     * @var string $score
     */
    private $score;

    /**
     * @var string $result
     */
    private $result;

    /**
     * BattleHistory constructor.
     * @param $civilization
     * @param $regiment
     * @param $score
     * @param $result
     */
    public function __construct($civilization, $regiment, $score, $result)
    {
        $this->civilization = $civilization;
        $this->regimentID = $regiment;
        $this->score = $score;
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getCivilization()
    {
        return $this->civilization;
    }

    /**
     * @return string
     */
    public function getRegiment()
    {
        return $this->regimentID;
    }

    /**
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }
}