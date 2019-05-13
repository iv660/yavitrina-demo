<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Для пользователя</h2>

                <p>Для доступа к этому разделу требуется регистрация на сайте. Войдите в систему или зарегистрируйтесь. Для входа используйте пароль user.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['user-page']) ?>">Для пользователя</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Для менеджера</h2>

                <p>Для доступа к этому разделу необходимы права не ниже менеджера. Для входа используйте учётную запись demo@example.com/demo.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['manager-page']) ?>">Для менеджера</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Для администратора</h2>

                <p>Для доступа к этому разделу необходимы права не ниже менеджера. Для входа используйте учётную запись admin@example.com/admin.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['admin-page']) ?>">Для администратора</a></p>
                </div>
            </div>

    </div>
</div>
