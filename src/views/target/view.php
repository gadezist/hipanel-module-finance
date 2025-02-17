<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\client\models\Client;
use hipanel\modules\finance\grid\PlanGridView;
use hipanel\modules\finance\helpers\ConsumptionConfigurator;
use hipanel\modules\finance\menus\TargetDetailMenu;
use hipanel\modules\finance\models\Consumption;
use hipanel\modules\finance\models\Plan;
use hipanel\modules\finance\models\Target;
use hipanel\modules\finance\widgets\ConsumptionViewer;
use hipanel\widgets\MainDetails;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

/** @var Target $model */
/** @var Target $originalModel */
/** @var Plan $tariff */
/** @var Client $client */
/** @var DataProviderInterface $dataProvider */
/** @var IndexPageUiOptions $uiModel */
/** @var ConsumptionConfigurator $configurator */
/** @var Consumption $consumption */

$this->title = Html::encode($originalModel->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:finance', 'Targets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <?php if ($model->isDeleted()) : ?>
            <?= Html::tag('div', Yii::t('hipanel:finance:tariff', 'This target is deleted'), ['class' => 'alert alert-danger text-center']) ?>
        <?php endif ?>
        <?= MainDetails::widget([
            'title' => $this->title,
            'icon' => 'fa-bullseye',
            'menu' => TargetDetailMenu::widget(['model' => $model], ['linkTemplate' => '<a href="{url}" {linkOptions}><span class="pull-right">{icon}</span>&nbsp;{label}</a>']),
        ]) ?>

        <?php if (Yii::$app->user->can('client.read') && Yii::$app->user->can('access-subclients')) : ?>
            <div class="row">
                <?= $this->render('@vendor/hiqdev/hipanel-module-ticket/src/views/ticket/_clientInfo', compact('client')) ?>
            </div>
        <?php endif ?>

        <?php if ($tariff !== null && !$model->isDeleted()) : ?>
            <div class="box box-widget">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel:finance:sale', 'Tariff information') ?></h3>
                </div>
                <div class="box-body no-padding">
                    <?= PlanGridView::detailView([
                        'model' => $tariff,
                        'boxed' => false,
                        'columns' => [
                            'simple_name',
                            'client',
                            'type',
                            'state',
                            'note',
                        ],
                    ]) ?>
                </div>
            </div>
        <?php endif ?>

    </div>
    <div class="col-md-9">
        <?= $this->render('_sales', ['target' => $originalModel]) ?>
        <?= ConsumptionViewer::widget([
            'configurator' => $configurator,
            'consumption' => $consumption,
            'mainObject' => $originalModel,
        ]) ?>
    </div>
</div>
