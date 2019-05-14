<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
    </div>

    <div class="body-content">
        <h2>Установка</h2>
        <ol>
            <li>Скачайте установочный пакет и загрузите его на сервер.</li>
            <li>Создайте копию файла <code>config/secure-default.ini</code> с именем <code>secure.ini</code> и задайте требуемые настройки.</li>
            <li>Выполните <code>yii migrate</code> для формирования схемы данных.</li>
            <li>Выполните <code>composer.phar update</code> для установки зависимостей.</li>
        </ol>
        
        <h2>Использованные возможности Yii</h2>
        <p>При создании данного сайта использованы следующие возможности фреймворка Yii и другие приемы:</p>
        <ul>
            <li>MVC;</li>
            <li>custom behaviors;</li>
            <li>custom validators;</li>
            <li>custom components;</li>
            <li>migrations для создания схемы данных;</li>
            <li>загружаемые модули;</li>
            <li>composer для установки и обновления зависимостей;</li>
            <li>ActiveRecord;</li>
            <li>средства автоматического формирования отдельных компонентов (Gii, migrate/create);</li>
            <li>автоматическая подстановка префиксов для таблиц БД ({{%table_name}});</li>
            <li>автоматическое формирование URL (URL helper);</li>
            <li>предотвращение утечки секретной информации за счет вынесения ее в отдельный ini-файл;</li>
            <li>flash-сообщения;</li>
            <li>локализация (перевод на русский язык) выводимого текста (для динамических страниц).</li>
        </ul>
        
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

                <p>Для доступа к этому разделу необходимы права не ниже администратора. Для входа используйте учётную запись admin@example.com/admin.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['admin-page']) ?>">Для администратора</a></p>
                </div>
            </div>

    </div>
</div>
