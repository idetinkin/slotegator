<?php

namespace frontend\components\prize\prizeHelpers;

use common\models\KeyValueStorage;
use common\models\PrizeStatus;
use common\models\PrizeType;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception as DbException;

class MoneyPrizeHelper extends AbstractPrizeHelper implements InterfaceConvertToPoints
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

    public function canConvertToPoints()
    {
        return $this->prize->status_id != PrizeStatus::STATUS_DELIVERED
            && $this->getValue() >= $this->getConvertToPointsCoefficient();
    }

    public function convertToPoints()
    {
        if (!$this->canConvertToPoints()) {
            throw new InvalidArgumentException('Cannot convert the prize to points');
        }

        $tran = Yii::$app->db->beginTransaction();

        try {
            $this->freePrize();

            $this->prize->attributes = [
                'type_id' => PrizeType::TYPE_POINTS,
                'value' => $this->calcPointsFromMoney(),
            ];
            if (!$this->prize->save()) {
                throw new DbException('Cannot convert the prize to points', $this->prize->errors);
            }
        } catch (\Exception $e) {
            $tran->rollBack();
            throw $e;
        }

        $tran->commit();
    }

    public function calcPointsFromMoney()
    {
        return floor($this->getValue() / $this->getConvertToPointsCoefficient());
    }

    public function getConvertToPointsCoefficient()
    {
        return Yii::$app->params['prize']['money']['convertToPointsCoefficient'];
    }

    public function deliver()
    {
        //TODO HTTP request to the bank API
        sleep(1);
        parent::deliver();
    }


}