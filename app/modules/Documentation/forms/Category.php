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
use Vegas\Validation\Validator\PresenceOf;

class Category extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $name = new Text('name');
        $name->setLabel($this->i18n->_('Name'));
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf());
        $this->add($name);
    }
}