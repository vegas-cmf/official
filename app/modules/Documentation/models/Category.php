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

namespace Documentation\Models;

use Vegas\Db\Decorator\CollectionAbstract;

class Category extends CollectionAbstract
{
    public $name;
    public $slug;
    public $parent;
    public $position;

    public function getSource()
    {
        return 'documentation_category';
    }
    
    public function beforeSave()
    {
        $this->generateSlug($this->name);
    }
}
