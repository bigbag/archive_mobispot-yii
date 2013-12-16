<?php

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User
{

    public $terms;
    public $activ_code;

    public function rules()
    {
        $rules = array(
            array('email, password', 'required'),
            array('email, password, activ_code', 'filter', 'filter' => 'trim'),
            array('activ_code', 'required', 'message' => Yii::t('user', "Необходимо указать код активации спота")),
            array('terms', 'required', 'message' => Yii::t('user', "Вы должны согласиться с условиями предоставления сервиса")),
            array('password', 'length', 'min' => 5, 'message' => Yii::t('user', "Минимальная длина пароля 5 символов")),
            array('activ_code', 'length', 'is' => 10, 'message' => Yii::t('user', "Код активации должен иметь длину 10 символов")),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('user', "На сайте уже зарегистрирован пользователь с таким Email")),
            array('activ_code', 'checkexists'),
        );
        return $rules;
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $spot = Spot::model()->findByAttributes(array('code' => $this->activ_code, 'status' => Spot::STATUS_ACTIVATED));

            if ($spot == null)
                $this->addError("activ_code", Yii::t('user', "Код активации спота неверен"));
        }
    }

}