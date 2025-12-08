<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Съесть';
?>
<div class="site-login">
    <div class="mt-5 offset-lg-3 col-lg-6">
        <h2><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin(['id' => 'eat-form', 'enableAjaxValidation' => false]); ?>

            <?= $form->field($eatForm, 'size')->textInput(['type' => 'number', 'min' => '10', 'max' => '100', 'data-apple-size' => $eatForm->model->size, 'required' => true]) ?>

            <div class="form-group">
                <?= Html::button('Откусить', ['class' => 'btn btn-primary btn-block eat-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php 
$js = <<<JSCODE
    $('.eat-button').on('click', function(event) {
        event.preventDefault();
        let apple_size = $('#eatform-size').data('apple-size');
        let current_size = $('#eatform-size').val();
        let eat = true;
        
        if (parseInt(current_size) > parseInt(apple_size)) {
            eat = confirm('Вы хотите откусить больше, окусить');
        }
        if (eat) {
            $('#eat-form').submit();
        }
    }); 

JSCODE;

$this->registerJs($js, \yii\web\View::POS_END);
?>