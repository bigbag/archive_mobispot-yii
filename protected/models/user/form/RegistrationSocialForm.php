<?php

class RegistrationSocialForm extends User
{

    public $verifyEmail;
    public $terms;
    public $activ_code;

    public function rules()
    {
        $rules = array(
            array('email, activ_code, terms', 'required'),
            array('email', 'email'),
            array('email', 'unique'),
            array('activ_code', 'checkexists'),,
        );
        return $rules;
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $spot = Spot::model()->findByAttributes(array('code' => $this->activ_code, 'status' => Spot::STATUS_ACTIVATED));

            if ($spot = null)
                $this->addError("activ_code", Yii::t('user', "The activation code is wrong spot"));
        }
    }

}
