<?php

namespace hipanel\modules\finance\actions;

use hipanel\actions\Action;
use hipanel\actions\SmartUpdateAction;
use yii\helpers\ArrayHelper;

class PriceUpdateAction extends SmartUpdateAction
{
    /** {@inheritdoc} */
    protected function getDefaultRules()
    {
        $rules = parent::getDefaultRules();
        $rules['POST html']['success']['url'] = function (Action $action) {
            $models = $action->getCollection()->getModels();

            $plans = array_unique(ArrayHelper::getColumn($models, 'plan_id'));
            if (count($plans) === 1) {
                return ['@plan/view', 'id' => $plans[0]];
            }

            return $action->collection->count() > 1
                ? $action->controller->getSearchUrl()
                : $action->controller->getActionUrl('view', ['id' => $action->getCollection()->first->id]);
        };

        return $rules;
    }
}
