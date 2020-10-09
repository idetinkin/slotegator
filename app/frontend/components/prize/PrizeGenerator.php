<?php

namespace frontend\components\prize;

use common\models\Prize;
use common\models\User;
use frontend\components\prize\prizeHelpers\MoneyPrizeHelper;
use frontend\components\prize\prizeHelpers\PointsPrizeHelper;
use frontend\components\prize\prizeHelpers\ThingsPrizeHelper;
use frontend\exceptions\NoPrizesLeftException;

class PrizeGenerator
{
    /**
     * @return string[]
     */
    public function getAllPrizeHelperClasses()
    {
        return [
            MoneyPrizeHelper::class,
            PointsPrizeHelper::class,
            ThingsPrizeHelper::class,
        ];
    }

    /**
     * @param User $user
     * @return Prize
     * @throws NoPrizesLeftException
     */
    public function generatePrize(User $user)
    {
        $prizeHelperClass = static::getRandomPrizeHelperClass();

        /** @var Prize $prize */
        $prize = $prizeHelperClass::generatePrize();
        $prize->user_id = $user->id;

        return $prize;
    }

    /**
     * @return string
     * @throws NoPrizesLeftException
     */
    public function getRandomPrizeHelperClass()
    {
        $availablePrizeHelperClasses = static::getAvailablePrizeHelperClasses();

        if (empty($availablePrizeHelperClasses)) {
            throw new NoPrizesLeftException();
        }

        $classIndex = rand(0, count($availablePrizeHelperClasses) - 1);
        return $availablePrizeHelperClasses[$classIndex];
    }

    /**
     * @return string[]
     */
    public function getAvailablePrizeHelperClasses()
    {
        $prizeHelperClasses = static::getAllPrizeHelperClasses();
        $availablePrizeHelperClasses = [];

        foreach ($prizeHelperClasses as $prizeHelperClass) {
            if ($prizeHelperClass::isAvailable()) {
                $availablePrizeHelperClasses[] = $prizeHelperClass;
            }
        }

        return $availablePrizeHelperClasses;
    }
}