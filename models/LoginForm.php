<?php

namespace app\models;

use yii\base\Model;

class LoginForm extends Model
{
    public ?string $username = null;
    public ?string $password = null;

    private ?User $_user = null;

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Invalid username or password');
            return false;
        }

        return \Yii::$app->user->login($user);
    }

    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}