<?php

namespace frontend\components\prize\prizeHelpers;

use common\models\PrizeStatus;
use common\models\PrizeType;
use Yii;

class PointsPrizeHelper extends AbstractPrizeHelper
{
    public static function isAvailable()
    {
        return true;
    }

    public static function generateValue()
    {
        $from = Yii::$app->params['prize']['points']['from'];
        $to = Yii::$app->params['prize']['points']['to'];
        return rand($from, $to);
    }

    public static function generatePrize()
    {
        $prize = parent::generatePrize();
        $prize->status_id = PrizeStatus::STATUS_DELIVERED;
        return $prize;
    }


    public static function getPrizeType()
    {
        return PrizeType::TYPE_POINTS;
    }

    public function getValueText()
    {
        return $this->getValue() . " points";
    }

    public function canDeletePrize()
    {
        return true;
    }


}