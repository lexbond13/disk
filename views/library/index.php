<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->controller->action->id;
?>
<div class="library-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo $action == "index" ? "<h1>".Html::a('Добавить диск', ['create'], ['class' => 'btn btn-success'])."</h1>" : ""; ?>
    </p>

<div class="row">
        <?php
            foreach($data as $item)
            {?>
            
              <div class="col-sm-5 col-md-3">
                <div class="thumbnail">
                  <img src="/web/images/<?=$item['img'];?>"  height="150"/>
                  <div class="caption">
                    <h4><?=$item['title'];?></h4>
                    <p style="height: 100px; overflow: hidden;"><?=$item['description'];?></p>
                    <p><span class="label label-primary"><?=$item['year'];?> г.</span></p>
                    <p><?php
                        if($action=='myself')
                        {
                            echo Html::a('Вернуть', ['library/back','id'=>$item['id']],['class'=>'btn btn-warning']);
                        }
                        if($action=='available')
                        {
                            echo Html::a('Взять', ['library/get','id'=>$item['id']],['class'=>'btn btn-success']);
                        }
                        if($action=='another')
                        {
                            echo "<div class='alert alert-warning'>Взял: ".$item->users['firstname']." ".$item->users['lastname']."</div>";
                        }
               
                        ?></p>
                  </div>
                </div>
              </div>
            <?php
            }
        ?>
        
</div>

</div>