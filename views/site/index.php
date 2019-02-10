<?php

/* @var $this yii\web\View */
use yii\grid\GridView;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'firstName',
            'lastName',
            'phoneNumbers',
        ],
    ]); ?>
</div>
