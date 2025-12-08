<?php

namespace app\models\form;

use Yii;
use yii\base\Model;

use app\models\Apples;


/**
 * EatForm form
 */
class EatForm extends Model
{
    public $size;
    public $model;

    public function __construct($config = []) {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model'], 'required'],
            [['size'], 'integer'],
            [['size'], 'validateSize'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'size' => 'Сколько откусить',
        ];
    }    
    public function validateSize($attribute, $params)
    {
        $this->model->checkStatus();
        
        if ($this->model->status == Apples::STATUS_HANGING) {
            $this->addError($attribute, 'Съесть нельзя, яблоко на дереве.');
        } else if ($this->model->status == Apples::STATUS_ROTTEN) {
            $this->addError($attribute, 'Съесть нельзя, яблоко испортилось.');
        }
    }
    
    public function eat() {
        return $this->model->eat($this->size);
    }
}
