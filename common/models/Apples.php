<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $color
 * @property string $size
 * @property int $status
 * @property int $created_at
 * @property int $down_at
 */
class Apples extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 0],
            [['color', 'created_at'], 'required'],
            [['status', 'size', 'created_at', 'down_at'], 'integer'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'size' => 'Размер',
            'status' => 'Статус',
            'created_at' => 'Дата появления',
            'down_at' => 'Дата падения',
        ];
    }

}
