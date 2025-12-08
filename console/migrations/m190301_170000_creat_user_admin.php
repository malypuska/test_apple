<?php

use yii\db\Migration;

class m190301_170000_creat_user_admin extends Migration
{
    public function safeUp()
    {
        $user = new common\models\User();        
        $user->username = 'admin';
        $user->setPassword('admin');
        $user->email = 'admin@apple.ru';
        $user->status = common\models\User::STATUS_ACTIVE;
        $user->generateAuthKey();
        
        $user->save(false);
    }

    public function safeDown()
    {
        echo "m190301_170000_creat_user_admin cannot be reverted.\n";

        return false;
    }
}
