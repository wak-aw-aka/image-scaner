<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Image Scaner V 0.1';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Поиск изображений</h2>

                <p>Пожалуйста, введите URL для поиска изображений (<strong style ="color: blue;">Например: https://yandex.ru)</strong></p>

                <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($urlImg, 'url')->textInput(array('placeholder' => 'Url')); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end() ?>

            </div>

        </div>

    </div>
</div>
