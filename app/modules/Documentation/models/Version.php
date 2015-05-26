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

class Version extends CollectionAbstract
{
    public $_id;
    public $version_id;
    public $slug;
    public $description;
    public $created_at;

    public function getSource() {
        return 'documentation_version';
    }
    
    public function beforeSave()
    {
        $this->slug = urlencode(trim($this->version_id));
    }
}