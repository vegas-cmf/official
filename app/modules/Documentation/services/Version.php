<?php

/**
 * This file is part of Vegas package
 *
 * @author Tomasz Borodziuk <tomasz.borodziuk@amsterdam-standard.nl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homenavigation https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Documentation\Services;

use Documentation\Models\Version as VersionModel;

class Version
{    
    public function getObject($id)
    {        
        $version = VersionModel::findById($id);
        return $version;
    }
    
    public function getObjectBySlug($slug)
    {
        $version = VersionModel::findFirst([['slug' => trim($slug)]]);
        return $version;
    }
    
    public function getAll()
    {
        $versionsArray = [];
        $versions = VersionModel::find(['sort' => ['version_id' => 1]]);
        if(is_array($versions)) {
            foreach($versions as $version) {
                $versionsArray[''.$version->_id] = $version->version_id;
            }
        }
        return $versionsArray;
    }
}