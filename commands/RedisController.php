<?php

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller,
    yii\console\ExitCode;
use yii\redis\Connection;

/**
 * Class RedisController
 * @package app\commands
 */
class RedisController extends Controller
{
    public function actionTransferToMysql()
    {
        echo "transfer start \n";

        /** @var Connection $redis */
        $redis = Yii::$app->redis;

        $count_of_users = $redis->hlen(\Yii::$app->params['redis_user_collection']);

        if ($count_of_users > 0) {
            for ($i = 1; $i <= (int)$count_of_users; $i++) {
                $item = $redis->hget(\Yii::$app->params['redis_user_collection'], $i);
                $this->saveUserToDb(json_decode($item, true));
                $redis->hdel(\Yii::$app->params['redis_user_collection'], $i);
            }
        }

        echo "transfer done \n";
    }

    private function saveUserToDb(Array $user)
    {
        if (count($user) === 3 && array_key_exists('firstName', $user) && array_key_exists('lastName', $user) && array_key_exists('phoneNumbers', $user)) {
            if (!empty($user['firstName']) && !empty($user['lastName'])) {
                $user_model = new User();
                $user_model->firstName = $user['firstName'];
                $user_model->lastName = $user['lastName'];
                $user_model->phoneNumbers = implode(', ', $user['phoneNumbers']);
                $user_model->save(false);
            }
        }
    }
}
