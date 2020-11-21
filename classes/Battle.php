<?php


namespace royalWars;

/**
 * Class Battle
 * @package royalWars
 */
class Battle
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

        $firstRegimentResult = static::BATTLE_LOSE;
        $secondRegimentResult = static::BATTLE_WIN;

        if ($firstRegimentPower == $secondRegimentPower) {
            $firstRegimentResult = $secondRegimentResult = static::BATTLE_TIE;
        } else if($firstRegimentPower > $secondRegimentPower) {
            $firstRegimentResult = static::BATTLE_WIN;
            $secondRegimentResult = static::BATTLE_LOSE;
        }

        $firstRegiment->saveBattleDetails($secondRegiment, $firstRegimentResult);
        $secondRegiment->saveBattleDetails($firstRegiment, $secondRegimentResult);
    }
}