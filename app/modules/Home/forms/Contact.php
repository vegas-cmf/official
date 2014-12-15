<?php
namespace Home\Forms;

use Vegas\Forms\Element\Text;
use Vegas\Forms\Element\TextArea;
use Vegas\Validation\Validator\Email;
use Vegas\Validation\Validator\PresenceOf;

class Contact extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $name = new Text('name');
        $name->setAttribute('placeholder', $this->i18n->_('Your name'));
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf());
        $this->add($name);

        $email = new Text('email');
        $email->setAttribute('placeholder', $this->i18n->_('Your email address'));
        $email->setAttribute('class', 'form-control');
        $email->addValidator(new Email());
        $email->addValidator(new PresenceOf());
        $this->add($email);

        $content = new TextArea('content');
        $content->setAttribute('placeholder', $this->i18n->_('Dear Vegas CMF team...'));
        $content->setAttribute('class', 'form-control');
        $content->setAttribute('rows', 8);
        $content->addValidator(new PresenceOf());
        $this->add($content);
    }
}