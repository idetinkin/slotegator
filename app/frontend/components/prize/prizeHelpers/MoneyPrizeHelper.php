<?php

namespace frontend\components\prize\prizeHelpers;

use common\models\KeyValueStorage;
use common\models\PrizeType;
use Yii;
use yii\base\InvalidArgumentException;

class MoneyPrizeHelper extends AbstractPrizeHelper
{
    public static function isAvailable()
    {
        $moneyLeft = KeyValueStorage::getValue('money_left');
        return $moneyLeft > 0;
    }

    public static function generateValue()
    {
        $from = Yii::$app->params['prize']['money']['from'];
        $to = Yii::$app->params['prize']['money']['to'];

        $randomValue = rand($from, $to);
        $moneyLeft = KeyValueStorage::getValue('money_left');

        return (min($randomValue, $moneyLeft));
    }

    public static function getPrizeType()
    {
        return PrizeType::TYPE_MONEY;
    }

    public function getValueText()
    {
        return $this->prize->value . " EUR";
    }

    public function reservePrize()
    {
        $moneyLeft = KeyValueStorage::getValue('money_left');
        if ($moneyLeft < $this->getValue()) {
            throw new InvalidArgumentException('Cannot reserve money, because there are not enough money left');
        }

        KeyValueStorage::setValue('money_left', (string) ($moneyLeft - $this->getValue())); //TODO possible race condition
    }

    public function freePrize()
    {
        $moneyLeft = KeyValueStorage::getValue('money_left');

        KeyValueStorage::setValue('money_left', (string) ($moneyLeft + $this->getValue())); //TODO possible race condition
    }


}