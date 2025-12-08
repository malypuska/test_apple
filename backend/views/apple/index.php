<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Apples;

$this->title = 'Сад';
?>
<p>
    <?= Html::a('Полить дерево', ['/apple/create'], ['class' => 'btn btn-success']) ?>
</p>

<?php if (Yii::$app->session->hasFlash('success')): ?>
<?php 
$js = <<<JSCODE
    $('.alert-success').show(1000, function() {
        setTimeout(function() {
            $('.alert-success').hide(500);
        }, 3000);
    }); 
    
JSCODE;

$this->registerJs($js, \yii\web\View::POS_END);
?>

<?php endif; ?>


<div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Apples::getStatusById($model->status);
                },
            ],
            [
                'attribute' => 'color',
                'value' => function ($model) {
                    return '<div style="color: ' . $model->color . '">яблоко</div>';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'size',
                'value' => function ($model) {
                    return $model->size / 100;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{fall-to-ground} {eat}',
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [
                    'fall-to-ground' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"/></svg>', $url, ['title' => 'Упасть на землю']);
                    },
                    'eat' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fork-knife" viewBox="0 0 16 16"><path d="M13 .5c0-.276-.226-.506-.498-.465-1.703.257-2.94 2.012-3 8.462a.5.5 0 0 0 .498.5c.56.01 1 .13 1 1.003v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5zM4.25 0a.25.25 0 0 1 .25.25v5.122a.128.128 0 0 0 .256.006l.233-5.14A.25.25 0 0 1 5.24 0h.522a.25.25 0 0 1 .25.238l.233 5.14a.128.128 0 0 0 .256-.006V.25A.25.25 0 0 1 6.75 0h.29a.5.5 0 0 1 .498.458l.423 5.07a1.69 1.69 0 0 1-1.059 1.711l-.053.022a.92.92 0 0 0-.58.884L6.47 15a.971.971 0 1 1-1.942 0l.202-6.855a.92.92 0 0 0-.58-.884l-.053-.022a1.69 1.69 0 0 1-1.059-1.712L3.462.458A.5.5 0 0 1 3.96 0z"/></svg>', $url, ['title' => 'Съесть']);
                    }
                ],
                'visibleButtons' =>[
                    'fall-to-ground' => function ($model) { return $model->status == Apples::STATUS_HANGING;},
                    'eat' => function ($model) { return $model->status == Apples::STATUS_LIES;}
                ]   
            ],
        ],
    ]);
    ?>    
</div>