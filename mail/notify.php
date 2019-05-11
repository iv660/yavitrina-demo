<?php
use yii\helpers\Url;
?>
<div> <p>Please use this link to set your password: <?= Url::to(["/site/reset", 'token' => $model->verification_token], TRUE); ?></p>