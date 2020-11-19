<?php


namespace classes;

/**
 * Class War
 * @package classes
 */
class War
{
    /**
     * List of possibles results
     */
    const BATTLE_WIN = 'win';
    const BATTLE_LOSE = 'lose';
    const BATTLE_TIE = 'tie';

    /**
     * Win price
     */
    const WIN_PRICE = 100;

    /**
     * Stores the civilizations
     * @var array
     */
    private $civilizations = [];

    public function addCivilization($name, $archers = 0, $knights = 0, $pikemen = 0)
    {
        $id = 'c_'.time();
        $this->civilizations[$id] = new Civilization($id, $name, $archers, $knights, $pikemen);
    }


    /**
     * @param $firstCivilization
     * @param $firstRegiment
     * @param $secondCivilization
     * @param $secondRegiment
     * @throws \Exception
     */
    public function newBattle($firstCivilization, $firstRegiment, $secondCivilization, $secondRegiment)
    {
        /** @var Regiment $firstRegimentModel */
        $firstRegimentModel = $this->loadRegimentFromCivilization($firstCivilization, $firstRegiment);
        /** @var Regiment $secondRegimentModel */
        $secondRegimentModel =  $this->loadRegimentFromCivilization($secondCivilization, $secondRegiment);

        $firstRegimentPower = $firstRegimentModel->getRegimentTotalPower();
        $secondRegimentPower = $secondRegimentModel->getRegimentTotalPower();

        if ($firstRegimentPower == $secondRegimentPower) {
            $firstRegimentModel->loadBattle($secondCivilization, $secondRegimentModel, $firstRegimentPower.' - '.$secondRegimentPower, War::BATTLE_TIE);
            $secondRegimentModel->loadBattle($firstCivilization, $firstRegiment, $secondRegimentPower.' - '.$firstRegimentPower, War::BATTLE_TIE);
        } else if($firstRegimentPower > $secondRegimentPower) {
            $firstRegimentModel->loadBattle($secondCivilization, $secondRegimentModel, $firstRegimentPower.' - '.$secondRegimentPower, War::BATTLE_WIN);
            $secondRegimentModel->loadBattle($firstCivilization, $firstRegiment, $secondRegimentPower.' - '.$firstRegimentPower, War::BATTLE_LOSE);
        } else {
            $firstRegimentModel->loadBattle($secondCivilization, $secondRegimentModel, $firstRegimentPower.' - '.$secondRegimentPower, War::BATTLE_LOSE);
            $secondRegimentModel->loadBattle($firstCivilization, $firstRegiment, $secondRegimentPower.' - '.$firstRegimentPower, War::BATTLE_WIN);
        }
    }

    /**
     * @param $civilizationId
     * @param $regimentId
     * @return mixed
     * @throws \Exception
     */
    private function loadRegimentFromCivilization($civilizationId, $regimentId)
    {
        if(!empty($this->civilizations[$civilizationId])) {
            $civilization = $this->civilizations[$civilizationId];
            if($civilization instanceof Civilization) {
                $regiment = $civilization->getRegiment($regimentId);
                if($regiment instanceof Regiment) {
                    return $regiment;
                }
            }
        }

        throw new \Exception('Civilizacion o Regimiento invalido');
    }
}