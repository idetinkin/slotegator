<?php

namespace frontend\components\prize\prizeHelpers;

use common\models\Prize;
use common\models\PrizeStatus;
use yii\base\BaseObject;
use yii\db\Exception as DbException;

abstract class AbstractPrizeHelper extends BaseObject
{
    /** @var Prize */
    public $prize;

    /**
     * @return boolean
     */
    abstract public static function isAvailable();

    /**
     * @return int
     */
    abstract public static function getPrizeType();

    /**
     * @return integer
     */
    abstract public static function generateValue();

    /**
     * @return Prize
     */
    public static function generatePrize()
    {
        $prize = new Prize();
        $prize->type_id = static::getPrizeType();
        $prize->status_id = PrizeStatus::STATUS_NEW;
        $prize->value = static::generateValue();

        return $prize;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->prize->value;
    }

    /**
     * @return string
     */
    public function getValueText()
    {
        return (string) $this->getValue();
    }

    public function canDeletePrize()
    {
        return $this->prize->status_id != PrizeStatus::STATUS_DELIVERED;
    }

    public function reservePrize()
    {
    }

    public function freePrize()
    {
    }

    public function deliver()
    {
        $this->prize->status_id = PrizeStatus::STATUS_DELIVERED;
        if (!$this->prize->save()) {
            throw new DbException('Cannot deliver the prize', $this->prize->errors);
        }
    }
}