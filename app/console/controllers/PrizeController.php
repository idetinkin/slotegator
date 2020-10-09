<?php

namespace console\controllers;

use common\models\Prize;
use common\models\PrizeStatus;
use common\models\PrizeType;
use Yii;
use yii\base\InvalidArgumentException;
use yii\console\Controller;

class PrizeController extends Controller
{
    public function actionDeliverMoneyBatch($batchSize)
    {
        /** @var Prize[] $prizes */
        $prizes = Prize::find()
            ->where([
                'type_id' => PrizeType::TYPE_MONEY,
                'status_id' => PrizeStatus::STATUS_NEW,
            ])
            ->orderBy('created_at')
            ->limit($batchSize)
            ->all();

        foreach ($prizes as $prize) {
            try {
                $prize->prizeHelper->deliver();
            } catch (\Exception $e) {
                echo (string) $e; //TODO save the exception to the logs for future process
            }
        }
    }

    public function actionDeliverThing($prizeId)
    {
        $prize = Prize::findOne($prizeId);
        if ($prize->type_id != PrizeType::TYPE_THINGS) {
            throw new InvalidArgumentException('The prize is not a thing');
        }

        $prize->prizeHelper->deliver();
    }
}