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
            array('email, password, terms', 'required'),
            array('email, password, activ_code', 'filter', 'filter' => 'trim'),
            array('password', 'length', 'min' => 5),
            //array('activ_code', 'length', 'is' => 10),
            array('email', 'email'),
            array('email', 'unique'),
            array('activ_code', 'checkexists'),
        );
        return $rules;
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors() and !empty($this->activ_code)) {
            $spot = Spot::getActivatedSpot($this->activ_code);

            if ($spot == null)
                $this->addError("activ_code", Yii::t('user', "The activation code is wrong spot"));
        }
    }

}
