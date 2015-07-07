<?php
/**
 * This file is part of Vegas package
 *
 * @author Tomasz Borodziuk <tomasz.borodziuk@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Documentation\Forms;

use Vegas\Forms\Element\Text;
use Vegas\Forms\Element\Select;
use Vegas\Forms\Element\TextArea;
use Vegas\Validation\Validator\PresenceOf;

class Article extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $field = new Text('title');
        $field->setLabel($this->i18n->_('Title'));
        $field->setAttribute('class', 'form-control');
        $field->addValidator(new PresenceOf());
        $this->add($field);
        
        $versions = $this->serviceManager->get('documentation:version')->getAll();
        foreach($versions as $id => $versionId) {
            $field = new Select('version['.$id.']');
            $field->setLabel($this->i18n->_('Concerns ver. ').$versionId);
            $field->setOptions(['0' => $this->i18n->_('No'),'1' => $this->i18n->_('Yes')]);
            $field->setAttribute('name', 'version['.$id.']');
            $this->add($field);
        }
        
        $categories = $this->serviceManager->get('documentation:category')->getAll('&nbsp;&nbsp;');
        $field = new Select('category', $categories, ['useEmpty' => true]);
        $field->setLabel($this->i18n->_('Category'));
        $field->addValidator(new PresenceOf());
        $this->add($field);
        
        
        $field = new Select('published');
        $field->setLabel($this->i18n->_('Published'));
        $field->setOptions(['0' => $this->i18n->_('No'),'1' => $this->i18n->_('Yes')]);
        $this->add($field);
        
        $field = new TextArea('content');
        $field->setLabel($this->i18n->_('Content'));
        $field->setAttribute('class', 'form-control');
        $field->setAttribute('readonly', 'true');
        $this->add($field);
        
        $field = new TextArea('content_rendered');
        $field->setAttribute('class', 'form-control');
        $field->setAttribute('readonly', 'true');
        $field->setAttribute('style', 'display:none;');
        $this->add($field);
    }
}