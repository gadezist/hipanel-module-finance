<?php

namespace hipanel\modules\finance\logic;

use hipanel\helpers\ArrayHelper;
use hipanel\modules\finance\models\Tariff;
use Yii;
use yii\web\NotFoundHttpException;

class TariffManagerFactory
{
    /**
     * @param integer $id Tariff ID
     * @param array $options that will be passed to the object as configuration
     * @return AbstractTariffManager|object
     * @throws NotFoundHttpException
     */
    public static function createById($id, $options = [])
    {
        $model = Tariff::find()->byId($id)->details()->one();

        if ($model === null) {
            throw new NotFoundHttpException('Tariff was not found');
        }

        $model->scenario = ArrayHelper::getValue($options, 'scenario', $model::SCENARIO_DEFAULT);

        return Yii::createObject(array_merge([
            'class' => static::buildClassName($model->type),
            'tariff' => $model
        ], $options));
    }

    /**
     * @param string $type Tariff type
     * @param array $options that will be passed to the object as configuration
     * @return AbstractTariffManager|object
     */
    public static function createByType($type, $options = [])
    {
        return Yii::createObject(array_merge(['class' => static::buildClassName($type)], $options));
    }

    /**
     * @param string $type Tariff type
     * @return string
     */
    protected static function buildClassName($type)
    {
        return 'hipanel\modules\finance\logic\\' . ucfirst($type) . 'TariffManager';
    }
}
