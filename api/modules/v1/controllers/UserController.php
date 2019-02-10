<?php

namespace app\api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\redis\Connection;
use yii\rest\Controller;

/**
 * Class UserController
 * @package app\api\modules\v1\controllers
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add'  => ['POST'],
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['add'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /**
     * Post JSON data about user
     */
    public function actionAdd(): array
    {
        $data = \Yii::$app->request->post('data');

        $json_request = (json_decode($data) != NULL) ? true : false;

        if ($json_request) {
            /** @var Connection $redis */
            $redis = Yii::$app->redis;

            $increment = $redis->hlen(\Yii::$app->params['redis_user_collection']);

            $redis->hmset(\Yii::$app->params['redis_user_collection'], $increment + 1, $data);

            return ['status' => true, 'data'=> 'Saved'];
        } else {
            return ['status' => false, 'data'=> 'Error'];
        }
    }
}