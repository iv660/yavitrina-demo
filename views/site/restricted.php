<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'Restricted page');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-restricted">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Это страница с органиченным доступом.</p>
</div>
