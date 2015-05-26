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

use Documentation\Models\Category as CategoryModel;

class Category {    
    public function updatePosition($id, $position, $parent)
    {
        $category = $this->getObject($id);
        if(!empty($category)) {
            $category->position = $position;
            $category->parent = $parent;
            return $category->save();
        }    
        return false;
    }
    
    public function getObject($id)
    {        
        $category = CategoryModel::findById($id);
        return $category;
    }
}