<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreateAdmin(): void
    {
        if (User::findByUsername('admin')) {
            $this->stdout("Admin user already exists\n");
            return;
        }

        $now = time();

        $user = new User();
        $user->username = 'admin';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin123');
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->created_at = $now;
        $user->updated_at = $now;

        if (!$user->save()) {
            print_r($user->getErrors());
            return;
        }

        $this->stdout("Admin user created\n");
    }
}