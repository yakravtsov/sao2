<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <script type="application/javascript" src="/js/angular/vendor/angular.min.js"></script>
    <script type="application/javascript" src="/js/angular/modules/sao-module.js"></script>
    <script type="application/javascript" src="/js/angular/controllers/tests-controller.js"></script>
    <script type="application/javascript" src="/js/angular/services/decorate.js"></script>
    <script type="application/javascript" src="/js/angular/services/modal.js"></script>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

<!--    <link href="/js/select2/css/select2.min.css" />-->
<!--    <script src="/js/select2/js/select2.min.js"></script>-->
</head>
<body>
<script>
	angular.module('sao').constant('csrf', {<?=Yii::$app->request->csrfParam?>: '<?=Yii::$app->request->getCsrfToken()?>'});
</script>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'S&A Online',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    //['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-home']) . ' Главная', 'url' => ['/site/index']],
                    ['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-list-alt']) . ' Компании', 'url' => ['/companies']],
                    ['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-user']) . ' Пользователи', 'url' => ['/users']],
                    ['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-list-alt']) . ' Проекты', 'url' => ['/projects']],
                    ['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-list']) . ' Тесты', 'url' => ['/test']],
                    ['label' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-question-sign']) . ' Техподдержка', 'url' => ['/feedback/add']],
                    //['label' => 'О проекте', 'url' => ['/site/about']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Войти', 'url' => ['/site/login']] :
                        ['label' => 'Выйти (' . Yii::$app->user->identity->phio . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; BITOBE, <?= date('Y') ?>.</p>
<!--            <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
<!--            <p class="pull-right"><small><strong>Система тестирования разработана в компании «<a href="//onlineconsulting.pro" target="_blank" title="Перейти на сайт компании">Онлайн Консалтинг</a>».</strong></small></p>-->
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
