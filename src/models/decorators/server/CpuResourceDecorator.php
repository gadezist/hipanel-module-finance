<?php

namespace hipanel\modules\finance\models\decorators\server;

use Yii;

class CpuResourceDecorator extends AbstractServerResourceDecorator
{
    const UNIT_CORE = 0;
    const UNIT_MHZ = 1;

    public function displayTitle()
    {
        return Yii::t('hipanel:server:order', 'CPU');
    }

    public function displayPrepaidAmount()
    {
        if ($this->getCpuUnit() === self::UNIT_CORE) {
            return Yii::t('hipanel:server:order', '{0, plural, one{# core} other{# cores}}',
                $this->getPrepaidQuantity());
        }

        return Yii::t('hipanel:server:order', '{0} MHz', Yii::$app->formatter->asInteger($this->getPrepaidQuantity()));
    }

    public function getPrepaidQuantity()
    {
        if ($this->getCpuUnit() === self::UNIT_CORE) {
            preg_match('/((\d+) cores?)$/i', $this->resource->part->partno, $matches);
        } else {
            preg_match('/((\d+) MHz)$/i', $this->resource->part->partno, $matches);

        }

        return $matches[2] === null ? 0 : $matches[2];
    }

    private function getCpuUnit()
    {
        if (strpos($this->resource->part->partno, 'core') !== false) {
            return self::UNIT_CORE;
        }

        return self::UNIT_MHZ;
    }
}
