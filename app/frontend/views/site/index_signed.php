<?php

/* @var $this yii\web\View */

$this->title = 'Signed user homepage';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Hello, <?=Yii::$app->user->identity->username?>!</h1>
    </div>

    <div class="body-content">

        <div class="row">
        </div>

    </div>
</div>
