<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'Set Your Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-activate">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= \Yii::t('app', 'In the form below, set the password for your new user account:') ?></p>

    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label(\Yii::t('app', 'Password')) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton(\Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
