<?php
use yii\helpers\Html;
use yii\widgets\ListView;
/* @var $this yii\web\View */
$this->title = 'Личный кабинет';
$request = Yii::$app->request;
?>
<div class="site-index">
    <h3>Личный кабинет</h3>
    <label>Реферальная ссылка</label>
    <div class="well"><?=$request->hostInfo.'/signup/?id='.$crypt?></div>
    <label>Код для вставки на сайт</label>
    <div class="well"><?=Html::encode('<a href="'.$request->hostInfo.'/signup/?id='.$crypt.'">Реферальная ссылка</a>')?></div>
    <?php
    if($parent){?>
        <label>Вы пришли от</label>
        <div class="well"><?=$parent['email']?></div>
    <?}?>
    <?php
    if($child){?>
        <label>От вас пришли</label>
        <div class="well">
            <?=ListView::widget([
                'dataProvider' => $child,
                'summary'=>'', 
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return $model->email;
                },
            ])?>
        </div>
    <?}?>
    <?php
        if($userList){
            echo'<label>Зарегестрированные пользователи</label><div class="well">';
            foreach ($userList as $user){
                $quote_head = '<blockquote>';
                $quote_foot = '</blockquote>';
                if(is_array($user)){
                    $level = $user['level']+1;
                    $user = $user['user'];
                    $quote_head = str_repeat('<blockquote>', $level);
                    $quote_foot = str_repeat('</blockquote>', $level);
                }
                echo $quote_head;
                echo $user->email;
                echo $quote_foot;
            };
            echo'</div>';
        }?>
</div>
