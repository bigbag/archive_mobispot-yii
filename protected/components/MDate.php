<?php
class MDate
{

    public function month()
    {
        return array(
            '01' => Yii::t('app', 'Январь'),
            '02' => Yii::t('app', 'Февраль'),
            '03' => Yii::t('app', 'Март'),
            '04' => Yii::t('app', 'Апрель'),
            '05' => Yii::t('app', 'Май'),
            '06' => Yii::t('app', 'Июнь'),
            '07' => Yii::t('app', 'Июль'),
            '08' => Yii::t('app', 'Август'),
            '09' => Yii::t('app', 'Сентябрь'),
            '10' => Yii::t('app', 'Октябрь'),
            '11' => Yii::t('app', 'Ноябрь'),
            '12' => Yii::t('app', 'Декабрь')
        );
    }
}
?>