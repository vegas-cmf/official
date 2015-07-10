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

class Category
{
    private $categoriesArray;
    
    public function updatePosition($id, $position, $parent)
    {
        $category = $this->retrieveById($id);
        if(!empty($category)) {
            $category->position = $position;
            $category->parent = $parent;
            return $category->save();
        }    
        return false;
    }
    
    public function retrieveById($id)
    {        
        $category = CategoryModel::findById($id);
        return $category;
    }
    
    public function retrieveBySlug($slug)
    {
        $category = CategoryModel::findFirst([['slug' => trim($slug)]]);
        return $category;
    }
    
    public function search($query) {
        $paramsForCategories = ['name' => [ '$regex' => $query, '$options'=>'i' ]];
        $categories = CategoryModel::find([$paramsForCategories]);
        return $categories;
    }
    
    public function getParents($id, $parents=[]) {
        if(!$id || $id == 'null') {
            return $parents;
        }
        $category = $this->retrieveById((string) $id);
        $parents[] = $category->parent;
        if($category->parent && $category->parent != 'null') {
            $parents = $this->getParents($category->parent, $parents);
        }
        return $parents;
    }
    
    public function getParentsNames($id, $reversed=true)
    {
        $parentsIds = $this->getParents($id);
        $parentsNames = [];
        foreach($parentsIds as $parentId) {
            if($parentId != 'null') {
                $category = $this->retrieveById($parentId);
                if($category) {
                    $parentsNames[] = $category->name;
                }
            }
        }
        
        if($reversed) {
            return array_reverse($parentsNames);
        } else {
            return $parentsNames;
        }
    }
    
    public function getPath($id, $separator = ' > ')
    {
        if(!$id || $id == 'null') {
            return '';
        }
        $category = $this->retrieveById($id);
        if(!$category) {
            return '';
        }
        $parents = $this->getParents($id);
        $parentsPath = $category->name;
        foreach($parents as $key => $parent) {
            if($parent && $parent!='null') {
                $parent = $this->retrieveById($parent);
                if($parent) {
                    $parentsPath = $parent->name.$separator.$parentsPath;
                }
            }
        }
        return $parentsPath;
    }
    
    public function getAll($depthMarker = '')
    {
        $categoriesArray = [];
        $categories = CategoryModel::find(['sort' => ['position' => 1]]);
        if (is_array($categories)) {
            foreach ($categories as $category) {
                $depthPrefix = '';
                if ($depthMarker != '') {
                    $parents = $this->getParents($category->_id);
                    $i = 1;
                    while($i < count($parents)) {
                        $depthPrefix = $depthPrefix.$depthMarker;
                        $i++;
                    }
                }
                
                if($depthMarker == 'array') {
                    $categoriesArray[(string) $category->_id] = [
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'parents' => $parents
                    ];
                } else {
                    $categoriesArray[(string) $category->_id] = $depthPrefix . $category->name;
                }
            }
        }
        return $categoriesArray;
    }
    
        
    public function getChildren($id)
    {
        if($this->categoriesArray == null) {
            $this->categoriesArray = $this->getAll('array');
        }
        
        $children = [];
        foreach($this->categoriesArray as $categoryId => $category) {
            if($id=='null' || in_array($id, $category['parents'])) {
                $children[] = $categoryId;
            }
        }
        
        return $children;
    }
}