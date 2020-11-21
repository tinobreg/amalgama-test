<?php

namespace classes;

use classes\interfaces\ITrainable;
use classes\interfaces\ITransformable;

/**
 * Class Regiment
 * @package classes
 */
class Regiment
{
    /**
     * Identification
     * @var string
     */
    private $id;

    /**
     * Civilization
     * @var string
     */
    private $civilizationName;

    /**
     * Regiment gold
     * @var int
     */
    private $gold = 1000;

    /**
     * Regiment unities
     * @var array
     */
    private $unities = [];

    /**
     * Stores the regiment battle history
     * @var array
     */
    private $battleHistory = [];


    /**
     * Regiment constructor.
     * @param $civilizationName
     * @param int $archers
     * @param int $knights
     * @param int $pikemen
     */
    public function __construct($civilizationName, $archers = 0, $knights = 0, $pikemen = 0)
    {
        $this->id = 'regiment_'.time();
        $this->civilizationName = $civilizationName;

        while ($archers > 0) {
            $this->unities[RegimentUnit::UNITY_ARCHER] = new Archer();
            $archers--;
        }

        while ($knights > 0) {
            $this->unities[RegimentUnit::UNITY_KNIGHT] = new Knight();
            $knights--;
        }

        while ($pikemen > 0) {
            $this->unities[RegimentUnit::UNITY_PIKEMAN] = new Pikeman();
            $pikemen--;
        }
    }

    /**
     * Returns the Regiment Civilization Name
     * @return string
     */
    public function getName()
    {
        return $this->civilizationName;
    }

    /**
     * Returns the Regiment ID
     * @return string
     */
    public function getId()
    {
       return $this->id;
    }

    /**
     * Tries to train given unity
     * @param string $unitType
     * @return string
     */
    public function trainRegimentUnit($unitType)
    {
        if (!empty($this->unities[$unitType])) {
            $regimentUnit = $this->unities[$unitType][rand(0, count($this->unities[$unitType]))];
            if ($regimentUnit instanceof ITrainable) {
                if ($regimentUnit->getTrainingCost() <= $this->gold) {
                    if ($regimentUnit->startTraining()) {
                        $this->gold = $this->gold - $regimentUnit->getTrainingCost();
                        return 'Entrenamiento finalizado';
                    }
                }
                return 'No tienes suficiente oro';
            }
            return 'No se pudo entrenar la unidad';
        }

        return 'No tienes unidades para entrenar';
    }

    /**
     * Tries to transform given unity
     * @param string $unitType
     * @return string
     */
    public function transformRegimentUnit($unitType)
    {
        if (!empty($this->unities[$unitType])) {
            $position = rand(0, count($this->unities[$unitType]));
            $currentRegimentUnit = $this->unities[$unitType][$position];

            if ($currentRegimentUnit instanceof ITransformable && $currentRegimentUnit->canMakeTransformation()) {
                if ($currentRegimentUnit->getTransformationCost() <= $this->gold) {
                    $this->gold = $this->gold - $currentRegimentUnit->getTransformationCost();
                    $newRegimentUnit = $currentRegimentUnit->getTransformationNewModel();

                    if ($newRegimentUnit instanceof RegimentUnit) {
                        unset($this->unities[$unitType][$position]);
                        $this->unities[$newRegimentUnit->getCurrentType()][] = $newRegimentUnit;
                        return 'Entrenamiento finalizado';
                    }
                } else {
                    return 'No tienes suficiente oro';
                }
            }
            return 'La unidad no se pudo transformar';
        }
        return 'No tienes unidades para entrenar';
    }

    /**
     * Save the battle and process the result
     * @param Regiment $regiment
     * @param $result
     */
    public function saveBattleDetails($regiment, $result)
    {
        /** @var Regiment $regiment */
        $this->battleHistory[] = [
            'civilization' => $regiment->getName(),
            'regiment' => $regiment->getId(),
            'score' => $this->getRegimentTotalPower().' - '.$regiment->getRegimentTotalPower() ,
            'result' => $result
        ];

        $this->processBattleResult($result);
    }

    /**
     * Process the given Battle result and applies the rewards or punishments
     * @param $result
     */
    private function processBattleResult($result)
    {
        if ($result == Battle::BATTLE_WIN) {
            $this->gold = $this->gold + Battle::WIN_PRICE;
        } else if ($result == Battle::BATTLE_LOSE) {
            for ($x = 0; $x < 2; $x++) {
                $pUnit = $this->getStrongestUnit();

                if (!empty($pUnit) && !empty($this->unities[$pUnit['type']][$pUnit['unit']])) {
                    unlink($this->unities[$pUnit['type']][$pUnit['unit']]);
                } else {
                    $x--;
                }
            }
        } else if ($result == Battle::BATTLE_TIE) {
            unlink($this->unities[RegimentUnit::UNITY_PIKEMAN][rand(0, count($this->unities[RegimentUnit::UNITY_PIKEMAN]))]);
        }
    }

    /**
     * Returns the position of the strongest Unity
     * @return array
     */
    private function getStrongestUnit()
    {
        $ret = [];
        $maxPower = 0;

        foreach ($this->unities as $type => $unities) {
            foreach ($unities as $pos => $unit) {
                /** @var RegimentUnit $unit */
                if ($unit->getTotalPower() > $maxPower) {
                    $maxPower = $unit->getTotalPower();
                    $ret = [
                        'type' => $type,
                        'unit' => $pos
                    ];
                }
            }
        }

        return $ret;
    }

    /**
     * Returns the total power amount of regiment unities
     * @return integer
     */
    public function getRegimentTotalPower()
    {
        $totalPower = 0;
        foreach ($this->unities as $type => $unities) {
            foreach ($unities as $pos => $unit) {
                /** @var RegimentUnit $unit */
                $totalPower += $unit->getTotalPower();
            }
        }

        return $totalPower;
    }
}