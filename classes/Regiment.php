<?php

namespace classes;

/**
 * Class Regiment
 * @package classes
 */
class Regiment
{
    /**
     * Regiment ID
     * @var string
     */
    public $id;

    /**
     * Regiment gold
     * @var int
     */
    public $gold = 1000;

    /**
     * Regiment unities
     * @var array
     */
    public $unities = [];

    /**
     * @var array
     */
    public $battleHistory = [];


    /**
     * Regiment constructor.
     * @param int $archers
     * @param int $knights
     * @param int $pikemen
     */
    public function __construct($id, $archers = 0, $knights = 0, $pikemen = 0)
    {
        $this->id = $id;

        while ($archers > 0) {
            $this->unities[RegimentUnity::UNITY_ARCHER] = new Archer();
            $archers--;
        }

        while ($knights > 0) {
            $this->unities[RegimentUnity::UNITY_KNIGHT] = new Knight();
            $knights--;
        }

        while ($pikemen > 0) {
            $this->unities[RegimentUnity::UNITY_PIKEMAN] = new Pikeman();
            $pikemen--;
        }
    }

    /**
     * @param $unity
     * @return string
     */
    public function trainRegimentUnity($unity)
    {
        if (!empty($this->unities[$unity])) {
            $unityModel = $this->unities[$unity][rand(0, count($this->unities[$unity]))];
            if ($unityModel instanceof RegimentUnity) {
                if ($unityModel->getTrainingCost() <= $this->gold) {
                    if ($unityModel->startTraining()) {
                        $this->gold = $this->gold - $unityModel->getTrainingCost();
                        return 'Entrenamiento finalizado';
                    }

                    return 'No se pudo completar el entrenamiento';
                }
                return 'No tienes suficiente oro';
            }
            return 'La unidad no es una unidad valida';
        }

        return 'No tienes unidades para entrenar';
    }

    /**
     * @param $unity
     * @return string
     */
    public function transformRegimentUnity($unity)
    {
        if (!empty($this->unities[$unity])) {
            $position = rand(0, count($this->unities[$unity]));
            $unityModel = $this->unities[$unity][$position];
            if ($unityModel instanceof RegimentUnity) {
                if ($unityModel->canMakeTransformation()) {
                    if ($unityModel->getTransformationCost() <= $this->gold) {
                        $this->gold = $this->gold - $unityModel->getTransformationCost();
                        $newModel = $unityModel->getTransformationNewModel();

                        if ($newModel instanceof RegimentUnity) {
                            unset($this->unities[$unity][$position]);
                            $this->unities[$newModel->getCurrentType()][] = $newModel;
                            return 'Entrenamiento finalizado';
                        }
                        return 'La unidad no se pudo transformar la unidad';
                    }
                    return 'No tienes suficiente oro';
                }
                return 'La unidad no se puede transformar';
            }
            return 'La unidad no es una unidad valida';
        }
        return 'No tienes unidades para entrenar';
    }

    /**
     * Save the battle and process the result
     * @param $civilization
     * @param $regiment
     * @param $score
     * @param $result
     */
    public function loadBattle($civilization, $regiment, $score, $result)
    {
        $this->battleHistory[] = ['civilization' => $civilization, 'regiment' => $regiment, 'score' => $score, 'result' => $result];

        if ($result == War::BATTLE_WIN) {
            $this->gold = $this->gold + War::WIN_PRICE;
        } else if ($result == War::BATTLE_LOSE) {
            for ($x = 0; $x < 2; $x++) {
                $pUnity = $this->getStrongestUnity();

                if (!empty($pUnity) && !empty($this->unities[$pUnity['type']][$pUnity['unity']])) {
                    unlink($this->unities[$pUnity['type']][$pUnity['unity']]);
                } else {
                    $x--;
                }
            }
        } else if ($result == War::BATTLE_TIE) {
            unlink($this->unities[RegimentUnity::UNITY_PIKEMAN][rand(0, count($this->unities[RegimentUnity::UNITY_PIKEMAN]))]);
        }
    }

    /**
     * Returns the position of the powerest Unity
     * @return array
     */
    private function getStrongestUnity()
    {
        $ret = [];
        $maxPower = 0;

        foreach ($this->unities as $type => $unities) {
            foreach ($unities as $pos => $unity) {
                /** @var RegimentUnity $unity */
                if ($unity->getTotalPower() > $maxPower) {
                    $maxPower = $unity->getTotalPower();
                    $ret = [
                        'type' => $type,
                        'unity' => $pos
                    ];
                }
            }
        }

        return $ret;
    }

    /**
     * Return all unities power
     * @return integer
     */
    public function getRegimentTotalPower()
    {
        $totalPower = 0;
        foreach ($this->unities as $type => $unities) {
            foreach ($unities as $pos => $unity) {
                /** @var RegimentUnity $unity */
                $totalPower += $unity->getTotalPower();
            }
        }

        return $totalPower;
    }
}