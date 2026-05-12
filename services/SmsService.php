<?php

namespace app\services;

use Yii;
use yii\httpclient\Client;

class SmsService
{
    private const API_URL = 'https://smspilot.ru/api2.php';
    private const API_KEY = 'эмулятор';

    public function send(string $phone, string $message): bool
    {
        $client = new Client();

        $response = $client->get(self::API_URL, [
            'send' => $message,
            'to' => $phone,
            'apikey' => self::API_KEY,
            'format' => 'json',
        ])->send();

        file_put_contents(
            Yii::getAlias('@runtime/logs/sms.log'),
            sprintf(
                "[%s] phone=%s message=%s response=%s\n",
                date('Y-m-d H:i:s'),
                $phone,
                $message,
                $response->content
            ),
            FILE_APPEND
        );

        return $response->isOk;
    }
}