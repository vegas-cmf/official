<?php
namespace User\Forms;

use Vegas\Forms\Element\Password;
use Vegas\Forms\Element\Text;
use Vegas\Validation\Validator\Email;
use Vegas\Validation\Validator\PresenceOf;
use Vegas\Validation\Validator\Unique;

class User extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidator(new PresenceOf([
            'message' => 'Name is required'
        ]));
        $this->add($name);

        $email = new Text('email');
        $email->setLabel('Email');
        $email->addValidator(new Email([
            'message' => 'The e-mail is not valid'
        ]));
        $this->add($email);

        $password = new Password('raw_password');
        $password->setLabel('Password');
        $password->addValidator(new PresenceOf([
            'message' => 'Password is required'
        ]));
        $this->add($password);
    }
}