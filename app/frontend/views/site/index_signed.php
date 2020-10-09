<?php

/* @var $this yii\web\View */
/* @var $prizesDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Signed user homepage';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Hello, <?=Yii::$app->user->identity->username?>!</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <?php
            echo Html::beginForm(['/prize/get-new-prize'], 'post')
                . Html::submitButton(
                    'Get new prize',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm();

            echo GridView::widget([
                'columns' => [
                    'prizeHelper.valueText:text:Prize',
                    'status.name:text:Status',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'prize',
                        'template' => '{delete}',
                        'visibleButtons' => [
                            'delete' => function (\common\models\Prize $model, $key, $index) {
                                return $model->prizeHelper->canDeletePrize();
                            },
                        ]
                    ],
                ],
                'dataProvider' => $prizesDataProvider,
            ]);
            ?>
        </div>

    </div>
</div>
