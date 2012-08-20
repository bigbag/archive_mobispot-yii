<?php
Class RMail
{
    public function registration($email)
    {
        $subject = 'Регистрация на сайте' . Yii::app()->par->load('siteTitle');
        $message = 'Вы зарегистрировались на сайте' . Yii::app()->par->load('siteTitle');

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $this->renderPartial('email_template', array('message' => $message), true);

        if ($stack->save()) return true;
        else return false;
    }

    public function activation($email, $activkey)
    {
        $activation_url = Yii::app()->request->hostInfo . '/service/activation/activkey/' . $activkey . '/email/' . $email;
        $subject = 'Вы зарегистрировались на сайте ' . Yii::app()->par->load('siteTitle');
        $message = 'Для активации вашей учётной записи вам необходимо перейти по ссылке ' . $activation_url;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;
    }

    public function recovery($email, $activkey)
    {
        $activation_url = Yii::app()->request->hostInfo . '/service/activation/activkey/' . $activkey . '/email/' . $email;
        $subject = 'Востановлен пароля на сайте ' . Yii::app()->par->load('siteTitle');
        $message = 'Для востановления пароля вам необходимо перейти по ссылке ' . $activation_url;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;
    }

    public function setTasksRunbee($email, $tasks_id)
    {
        $subject = 'Вы исполнитель!';
        $message = 'Вас выбрали исполнителем задачи  ' . Yii::app()->request->hostInfo . '/tasks/view/' . $tasks_id;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;
    }

    public function tasksComment($email, $tasks_id)
    {
        $subject = 'Комментарий к задаче ID ' . $tasks_id;
        $message = 'К вашей задаче ID ' . Yii::app()->request->hostInfo.'/tasks/view/'.$tasks_id . ' оставлен новый комментарий';

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;
    }

    public function tasksCompleted($email, $tasks_id)
    {

        $subject = 'Задача ID ' . $tasks_id . ' выполнена.';
        $message = 'Ваша задача ID ' . $tasks_id . ' выполнена исполнителем. ';
        $message .= 'Вам необходимо подтвердить выполнение задачи. ';
        $message .= 'Для этого пройдите по ссылке ' . Yii::app()->request->hostInfo . '/customer/tasks';

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;

    }

    public function tasksClosed($email, $tasks_id)
    {
        $subject = 'Задача ID ' . $tasks_id . ' полностью завершена.';
        $message = 'Задача ID ' . $tasks_id . ' полностью завершена. ';
        $message .= 'Оплата по данной задаче поступила на ваш счёт.';

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;

    }

    public function setCostTasks($email, $tasks_id, $runbee_id, $price)
    {

        $user = User::model()->notsafe()->findbyPk($runbee_id);

        if (!empty($user->profile->firstName)) {
            $name = $user->profile->firstName . ' ' . $user->profile->lastName;
        } else {
            $name = 'RunBee №' . $user->id;
        }

        $subject = 'Новый RunBee для задачи ' . $tasks_id . '';
        $message = 'RunBee ' . $name . ' хочет выполнить установленную вами задачу, ';
        $message .= 'он просит за это ' . $price . 'руб. ';
        $message .= 'Подробную информацию об этом RunBee вы можете получить, пройдя по ссылке ';
        $message .= Yii::app()->request->hostInfo . '/runbee/public/id/' . $runbee_id;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;
    }
    public function tasksFailure($email, $tasks_id, $comment){

        $subject = 'Задача ' . $tasks_id . ' не выполнена!';
        $message = 'По задаче ' . $tasks_id . ' необходимо вмешательство администрации. ';
        $message .= 'Комментарий заказчика:';
        $message .= $comment;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => 'Администратор'));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $message;

        if ($stack->save()) return true;
        else return false;
    }

}