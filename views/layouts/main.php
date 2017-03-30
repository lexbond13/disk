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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#/">Коллекция DVD дисков</a>
            </div>      
            <ul class="nav navbar-nav navbar-right">
            <?php
                if(Yii::$app->user->isGuest == false)
                    {
            ?>
                    <li><?=Html::a('Мои диски',['library/index']);?></li>
                    <li><?=Html::a('Свободные диски',['library/available']);?></li>
                    <li><?=Html::a('Взятые мной',['library/myself']);?></li>
                    <li><?=Html::a('Взятые у меня',['library/another']);?></li>
                    <li><?=Html::a('Выход',['library/logout']);?></li>
                    <?php
                    }
                    ?>
                    
            </ul>
        </div>
    </nav>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">Система обмена дисками</p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
