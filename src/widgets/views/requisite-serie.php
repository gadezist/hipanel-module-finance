<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var array|string $actionUrl url to send the form
 */
?>

<?php $form = ActiveForm::begin([
    'id' => 'nss-form-pjax',
    'action' => $actionUrl,
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'validationUrl' => Url::toRoute(['@requisite/validate-form', 'scenario' => 'set-serie']),
    'options' => [
        'data-pjax' => true,
        'data-pjaxPush' => false,
    ],
]) ?>
    <?php if (!is_array($model)) : ?>
        <?= Html::activeHiddenInput($model, 'id') ?>
    <?php else : ?>
        <?php foreach ($model as $item) : ?>
            <?= Html::activeHiddenInput($item, "[$item->id]id") ?>
        <?php endforeach ?>
    <?php endif ?>

    <div class="row" style="margin-top: 15pt;">
        <div class="col-md-10 inline-form-selector">
            <?php $model = is_array($model) ? reset($model) : $model ?>
                <div class="col-md-6">
                    <?= $form->field($model, "serie") ?>
                </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15pt;">
        <div class="col-md-2 text-right">
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), [
                'class' => 'btn btn-success',
                'id' => 'nss-save-button',
                'data-loading-text' => '<i class="fa fa-circle-o-notch fa-spin"></i> ' . Yii::t('hipanel', 'saving'),
                'disabled' => false,
            ]) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
