<?php

class RegisterForm
{

    const DEFAULT_TOPIC = 'Заявка на регистрацию';

    public function getDefaultEmail()
    {
        return array(
            'ilya.radaev@gmail.com',
            'nanovolgin@gmail.com',
            'bilbo.kem@gmail.com',
        );
    }

}
