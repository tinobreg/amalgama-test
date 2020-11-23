<?php

namespace royalWars;

use royalWars\interfaces\ITrainable;
use royalWars\interfaces\ITransformable;

/**
 * Class Regiment
 * @package royalWars
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
     * @throws \Exception
     */
    public function trainRegimentUnit($unitType)
    {
        if (empty($this->unities[$unitType])) {
            return 'No tienes unidades para entrenar';
        }

        $regimentUnit = $this->unities[$unitType][$this->getRandomUnitPosition($unitType)];
        if ($regimentUnit instanceof ITrainable) {
            if ($regimentUnit->getTrainingCost() > $this->gold) {
                return 'No tienes suficiente oro';
            }

            if ($regimentUnit->startTraining()) {
                $this->gold = $this->gold - $regimentUnit->getTrainingCost();
                return 'Entrenamiento finalizado';
            }
        }

        return 'No se pudo entrenar la unidad';
    }

    /**
     * Tries to transform given unity
     * @param string $unitType
     * @return string
     * @throws \Exception
     */
    public function transformRegimentUnit($unitType)
    {
        if (!empty($this->unities[$unitType])) {
            return 'No tienes unidades para entrenar';
        }

        $position = $this->getRandomUnitPosition($unitType);
        $currentRegimentUnit = $this->unities[$unitType][$position];

        if ($currentRegimentUnit instanceof ITransformable && $currentRegimentUnit->canMakeTransformation()) {
            if ($currentRegimentUnit->getTransformationCost() > $this->gold) {
                return 'No tienes suficiente oro';
            }

            $this->gold = $this->gold - $currentRegimentUnit->getTransformationCost();
            $newRegimentUnit = $currentRegimentUnit->getTransformationNewModel();

            if ($newRegimentUnit instanceof RegimentUnit) {
                unset($this->unities[$unitType][$position]);
                $this->unities[$newRegimentUnit->getCurrentType()][] = $newRegimentUnit;
                return 'Entrenamiento finalizado';
            }
        }

        return 'La unidad no se pudo transformar';
    }

    /**
     * Returns random unit for given unitType
     * @param string $unitType
     * @return int
     * @throws \Exception
     */
    private function getRandomUnitPosition($unitType = RegimentUnit::UNITY_PIKEMAN)
    {
        if(!empty($this->unities[$unitType])) {
            return rand(0, count($this->unities[$unitType]));
        }

        throw new \Exception('No hay unidades del tipo solicitado.');
    }

    /**
     * Save the battle and process the result
     * @param Regiment $regiment
     * @param $result
     * @throws \Exception
     */
    public function saveBattleDetails($regiment, $result)
    {
        /** @var Regiment $regiment */
        $score = $this->getRegimentTotalPower().' - '.$regiment->getRegimentTotalPower();
        $this->battleHistory[] = new BattleHistory($regiment->getName(), $regiment->getId(), $score, $result);

        $this->processBattleResult($result);
    }

    /**
     * Process the given Battle result and applies the rewards or punishments
     * @param string $result
     * @throws \Exception
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
            if(!empty($this->unities[RegimentUnit::UNITY_PIKEMAN])) {
                unlink($this->unities[RegimentUnit::UNITY_PIKEMAN][$this->getRandomUnitPosition()]);
            } else {
                unlink($this->unities[RegimentUnit::UNITY_ARCHER][$this->getRandomUnitPosition()]);
            }
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