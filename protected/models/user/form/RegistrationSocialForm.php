<?php

class RegistrationSocialForm extends User
{

    public $verifyEmail;
    public $terms;
    public $activ_code;

    public function rules()
    {
        $rules = array(
            array('email', 'required'),
            array('activ_code', 'required', 'message' => Yii::t('user', "Необходимо указать код активации спота")),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('user', "На сайте уже зарегистрирован пользователь с таким Email")),
            array('activ_code', 'checkexists'),
            array('terms', 'required', 'message' => Yii::t('user', "Вы должны согласиться с условиями предоставления сервиса")),
        );
        return $rules;
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $spot = Spot::model()->findByAttributes(array('code' => $this->activ_code, 'status' => Spot::STATUS_ACTIVATED));

            if ($spot = null)
                $this->addError("activ_code", Yii::t('user', "Код активации спота неверен"));
        }
    }

}