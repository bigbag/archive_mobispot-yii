<?php

class ErrorForm extends CFormModel
{

    public $verifyCode;

    public function rules()
    {
        return array(
            array('verifyCode', 'captcha'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        
    }

}
