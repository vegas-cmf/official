<?php
namespace Project\Forms;

use Vegas\Forms\Element\Browser;
use Vegas\Forms\Element\Text;
use Vegas\Forms\Element\Upload;
use Vegas\Validation\Validator\PresenceOf;
use Vegas\Validation\Validator\Url;

class Project extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidator(new PresenceOf());
        $this->add($name);

        $url = new Text('url');
        $url->setLabel('Project url');
        $url->addValidator(new Url());
        $this->add($url);

        $image = new Upload('image');
        $image->setModel(new \File\Models\File());
        $image->setPreviewSize(array('width' => 100, 'height' => 100));
        $image->getDecorator()->setTemplateName('jquery');
        $image->setUploadUrl($this->url->get([
            'for' => 'admin/project',
            'action' => 'upload'
        ]));
        $image->setMode(Upload::MODE_SINGLE);
        $image->setLabel('Image');
        $this->add($image);
    }
}