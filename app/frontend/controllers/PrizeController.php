<?php

namespace frontend\controllers;

use common\models\Prize;
use http\Exception\InvalidArgumentException;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class PrizeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'getNewPrize',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'getNewPrize',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'getNewPrize' => ['post'],
                ],
            ],
        ];
    }

    public function actionGetNewPrize()
    {
        Prize::createNewPrize();
        return $this->goBack();
    }

    public function actionDelete($id)
    {
        /** @var Prize $prize */
        $prize = Yii::$app->user->identity->getPrizes()
            ->andWhere([
                'id' => $id
            ])
            ->one();

        if (empty($prize)) {
            throw new NotFoundHttpException("Prize with ID = $id was not found");
        }

        if (!$prize->delete()) {
            throw new ServerErrorHttpException('Cannot delete the prize');
        }

        Yii::$app->session->setFlash('success', 'The prize was deleted');
        return $this->goBack();
    }
}