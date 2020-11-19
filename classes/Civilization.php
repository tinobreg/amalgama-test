<?php


namespace classes;

/**
 * Class Civilization
 * @package classes
 */
class Civilization
{
    public $id;
    public $name;
    private $regiments = [];

    /**
     * Civilization constructor.
     * @param $name
     * @param int $archers
     * @param int $knights
     * @param int $pikemen
     */
    public function __construct($id, $name, $archers = 0, $knights = 0, $pikemen = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createRegiment($archers, $knights, $pikemen);
    }

    /**
     * @param int $archers
     * @param int $knights
     * @param int $pikemen
     */
    public function createRegiment($archers = 0, $knights = 0, $pikemen = 0)
    {
        if(!empty($archers) || !empty($knights) || !empty($pikemen)) {
            $id = 'r_'.time();
            $this->regiments[$id] = new Regiment($id, $archers, $knights, $pikemen);
        }
    }

    /**
     * Returns the regiment for given id
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getRegiment($id)
    {
        if(!empty($this->regiments[$id])) {
            return $this->regiments[$id];
        }

        throw new \Exception('Regimiento invalido');
    }
}