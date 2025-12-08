<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;

use app\models\Apples;
use app\models\search\ApplesSearch;
use app\models\form\EatForm;
/**
 * Site controller
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ApplesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCreate()
    {
        (new Apples())->genApple();
        
        return $this->redirect(['/apple/index']);
    }
    
    public function actionFallToGround($id)
    {
        $apple = $this->findModel($id);
        $apple->fallToGround();
        Yii::$app->getSession()->setFlash('success', 'Яблоко упало на землю');        
        return $this->redirect(['/apple/index']);
    }
    
    public function actionEat($id)
    {
        $apple = $this->findModel($id);
        $eatForm= new EatForm(['model' => $apple]);
        
        if ($eatForm->load(Yii::$app->request->post()) && $eatForm->validate() && $eatForm->eat()) {
            Yii::$app->getSession()->setFlash('success', 'Вы откусили, ' . $eatForm->size); 
            return $this->redirect(['/apple/index']);
        }        
        
        return $this->render('eat', ['eatForm' => $eatForm]);
    }
    
    protected function findModel($id)
    {
        if (($model = Apples::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Яблоко не найдено!');
    }    
}
