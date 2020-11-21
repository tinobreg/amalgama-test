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
     * Receives two regiments and process their power to define the battle winner
     * @param Regiment $firstRegiment
     * @param Regiment $secondRegiment
     */
    public static function newBattle(Regiment $firstRegiment, Regiment $secondRegiment)
    {
        $firstRegimentPower = $firstRegiment->getRegimentTotalPower();
        $secondRegimentPower = $secondRegiment->getRegimentTotalPower();

        $firstRegimentResult = War::BATTLE_LOSE;
        $secondRegimentResult = War::BATTLE_WIN;

        if ($firstRegimentPower == $secondRegimentPower) {
            $firstRegimentResult = $secondRegimentResult = War::BATTLE_TIE;
        } else if($firstRegimentPower > $secondRegimentPower) {
            $firstRegimentResult = War::BATTLE_WIN;
            $secondRegimentResult = War::BATTLE_LOSE;
        }

        $firstRegiment->saveBattleDetails($secondRegiment, $firstRegimentResult);
        $secondRegiment->saveBattleDetails($firstRegiment, $secondRegimentResult);
    }
}