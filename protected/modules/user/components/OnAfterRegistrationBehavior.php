<?php
class OnAfterRegistrationBehavior extends CActiveRecordBehavior
{

    function afterSave($event)
    {

        // получаем таблицу в БД
        $assignmentTable = Yii::app()->getAuthManager()->assignmentTable;

        // получаем параметры нового пользователя
        $attr = $event->sender->getAttributes();

        // вытаскиваем название роли по умолчанию из настроек модуля rights
        $defRole = Yii::app()->getModule('rights')->authenticatedName;

        // добавляем привязку
        Yii::app()->db->createCommand(
            "INSERT INTO {$assignmentTable}
                (`itemname`,`userid`,`bizrule`,`data`)
                VALUES
                ('{$defRole}','{$attr['id']}',NULL,'N;')")->execute();

    }

}