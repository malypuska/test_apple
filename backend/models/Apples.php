<?php

namespace app\models;

use Yii;

class Apples extends \common\models\Apples {

    const STATUS_HANGING = 0;
    const STATUS_LIES = 1;
    const STATUS_ROTTEN = 2;

    static public $statusList = [
        self::STATUS_HANGING => 'Висит на дереве',
        self::STATUS_LIES => 'Упало/лежит на земле',
        self::STATUS_ROTTEN => 'Гнилое яблоко',
    ];
    static public $colorList = ['red', 'green', 'yellow'];

    static public function getStatusList() {
        return self::$statusList;
    }

    static public function getStatusById($id) {
        return self::$statusList[$id] ?? null;
    }

    public function genApple() {
        $countApple = mt_rand(1, 5);
        for ($i = 1; $i <= $countApple; $i++) {
            $apple = new Apples();
            $apple->color = self::$colorList[mt_rand(0, (count(self::$colorList) - 1))];
            $apple->created_at = time();
            $apple->save();
        }
    }

    public function checkStatus() {
        if ($this->status == self::STATUS_LIES) {
            if (($this->down_at + (3600 * 5)) <= time()) {
                $this->status = self::STATUS_ROTTEN;
                $this->save(false, ['status']);
            }
        }
        
        return $this;
    }

    public function fallToGround() {
        $this->status = self::STATUS_LIES;
        $this->down_at = time();
        $this->save(false, ['status', 'down_at']);
    }

    public function eat($value) {
       $this->size -= $value;
        if ($this->size <= 0) {
            return $this->delete();
        } else {
            return $this->save(false, ['size']);
        }
    }
}
