<?php
namespace User\Forms;

use Vegas\Forms\Element\Password;
use Vegas\Forms\Element\Text;
use Vegas\Forms\Element\Select;
use Vegas\Validation\Validator\Email;
use Vegas\Validation\Validator\PresenceOf;

class User extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $firstName = new Text('first_name');
        $firstName->setLabel('First name');
        $firstName->addValidator(new PresenceOf(array(
            'message' => 'First name is required'
        )));
        $this->add($firstName);

        $lastName = new Text('last_name');
        $lastName->setLabel('Last name');
        $lastName->addValidator(new PresenceOf(array(
            'message' => 'Last name is required'
        )));
        $this->add($lastName);

        $email = new Text('email');
        $email->setLabel('Email');
        $email->addValidator(new Email(array(
            'message' => 'The e-mail is not valid'
        )));
        $this->add($email);

        $password = new Password('raw_password');
        $password->setLabel('Password');
        $password->addValidator(new PresenceOf(array(
            'message' => 'Password is required'
        )));
        $this->add($password);
    }
}