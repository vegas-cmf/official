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

class Version extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $version = new Text('version_id');
        $version->setLabel('Version ID');
        $version->addValidator(new PresenceOf());
        $this->add($version);

        $description = new Text('description');
        $description->setLabel('Description');
        $this->add($description);
    }
}