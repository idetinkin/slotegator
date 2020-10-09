<?php

namespace frontend\components\prize\prizeHelpers;

use common\models\PrizeThing;
use common\models\PrizeType;
use yii\base\InvalidArgumentException;
use yii\db\Exception as DbException;

class ThingsPrizeHelper extends AbstractPrizeHelper
{
    public static function isAvailable()
    {
        return static::getAvailableThingsQuery()->exists();
    }

    public static function generateValue()
    {
        $thingIds = static::getAvailableThingsQuery()->select('id')->column();
        if (empty($thingIds)) {
            throw new InvalidArgumentException('No things for prizes left');
        }

        $thingIndex = rand(0, count($thingIds)-1);
        $randomThingId = $thingIds[$thingIndex];

        return $randomThingId;
    }

    protected static function getAvailableThingsQuery()
    {
        return PrizeThing::find()->where(['>', 'qty', 0]);
    }

    public static function getPrizeType()
    {
        return PrizeType::TYPE_THINGS;
    }

    public function getValueText()
    {
        return $this->getPrizeThing()->name;
    }

    public function reservePrize()
    {
        $thing = $this->getPrizeThing();
        if ($thing->qty <= 0) {
            throw new InvalidArgumentException('Cannot reserve thing, because nothing left');
        }

        $thing->qty = $thing->qty - 1;
        //TODO possible race condition
        if (!$thing->save()) {
            throw new DbException('Cannot reserve thing', $thing->errors);
        }
    }

    public function freePrize()
    {
        $thing = $this->getPrizeThing();

        $thing->qty = $thing->qty + 1;
        //TODO possible race condition
        if (!$thing->save()) {
            throw new DbException('Cannot reserve thing', $thing->errors);
        }
    }


    public function getPrizeThing()
    {
        $value = $this->getValue();
        return PrizeThing::findOne($value);
    }


}