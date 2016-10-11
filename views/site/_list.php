<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>
 
<article class="item" data-key="<?= $model->id; ?>">
    <h2 class="title">
    <?= Html::a(Html::encode($model->id), Url::toRoute(['post/show', 'id' => $model->id]), ['title' => $model->id]) ?>
    </h2>

    <div class="item-excerpt">
    <?= Html::encode($model->url); ?>
    </div>
</article>