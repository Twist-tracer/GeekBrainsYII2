<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Календарь',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => array_merge(
            [
                ['label' => 'Главная', 'url' => ['/site/index']],
            ],
            Yii::$app->user->isGuest ?
                [
                    ['label' => 'О проекте', 'url' => ['/site/about']],
                    ['label' => 'Контакты', 'url' => ['/site/contact']],
                    ['label' => 'Войти', 'url' => ['/site/login']]
                ]
                    :
                [
                    [
                        'label' => 'События',
                        'items' => [
                            ['label' => 'Мои события', 'url' => ['/calendar/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Мои публичные даты', 'url' => ['/calendar/publicdates']],
                            '<li class="divider"></li>',
                            ['label' => 'События друзей', 'url' => ['/calendar/friendevents']],
                        ],
                    ],
                    ['label' => 'Поделиться', 'url' => ['/access/shareevent']],
                    [
                        'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]

            ),
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('yii', 'Главная'),
                'url' => Yii::$app->homeUrl,
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
