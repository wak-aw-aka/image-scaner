<?php

$this->title = 'Список запрошеных урлов';


echo yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            'url',
            [
            	'header' => 'Кол-во найденых изображений',
	            'attribute' => 'url',
	            'format' => 'html',
	            'value' => function($model) {
		            return count(json_decode($model->data, true));
	            }
	        ],
            [
            	'header' => 'Действие',
	            'attribute' => 'url',
	            'format' => 'html',
	            'value' => function($model) {
		            return '<a href = "' . \yii\helpers\Url::toRoute(['showurl', 'id' => $model->id]) . '">Просмотр</a>';
	            }
	        ],
        ],
    ]);
?>