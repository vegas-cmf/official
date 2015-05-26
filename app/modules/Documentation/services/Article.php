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

use Documentation\Models\Article as ArticleModel;
use Documentation\Models\Version as VersionModel;
use Documentation\Models\Category as CategoryModel;

class Article {    
    public function updateContent($id, $content, $contentRendered, $archival=false)
    {
        $article = $this->getArticle($id);
        if(!empty($article)) {
            $article->content = $content;
            $article->contentRendered = $contentRendered;
            if($archival) return $article->makeCopyToArchive(0);
            return $article->save();
        }    
        return false;
    }
    
    public function updatePosition($id, $position)
    {
        $article = $this->getArticle($id);
        if(!empty($article)) {
            $article->position = $position;
            return $article->save();
        }
        return false;
    }
    
    public function getArticle($id)
    {        
        $object = ArticleModel::findById($id);
        return $object;
    }
    
    public function getArticleBySlug($versionSlug,$categorySlug,$articleSlug,$onlyPublished=true)
    {
        $version = VersionModel::findFirst([['slug' => trim($versionSlug)]]);
        if(!$version) return null;
        
        $model = new ArticleModel();
        $filter = [];
        if($onlyPublished) $filter['published'] = ['$eq' => '1'];
        $filter['version.'.$version->_id] = ['$eq' => '1'];
        $filter['archival'] = ['$ne' => true];
        $filter['slug'] = $articleSlug;
        $articles = $model->find([
            $filter,
            'sort'=>['category'=> 1 ,'position' => 1]
        ]);
        
        if($articles) foreach($articles as $article) {
            $category = $this->getCategory($article->category);
            if($category->slug == $categorySlug) return $article;
        }
        
        return null;
    }
    
    public function getFirstArticle($versionSlug=null,$categorySlug=null) {
        $version = VersionModel::findFirst([['slug' => trim($versionSlug)]]);
        $category = CategoryModel::findFirst([['slug' => trim($categorySlug)]]);
        
        if($version) $articles = $this->getAllArticles(true, (string) $version->_id);
        else $articles = $this->getAllArticles(true,'all');
        
        if($articles) {
            foreach($articles as $categoryId => $articleGroup) {
                if(!$category || (string) $categoryId == (string) $category->_id) {
                    if(!empty($articleGroup)) foreach($articleGroup as $article) {
                        return $article;
                    }
                }
            }
        }
        
        return null;
    }   
    
    public function getAllVersions()
    {
        $versionsArray = [];
        $versions = VersionModel::find(['sort' => ['version_id' => 1]]);
        if(is_array($versions)) foreach($versions as $version) {
           $versionsArray[''.$version->_id] = $version->version_id;
        }
        return $versionsArray;
    }
    
    public function getAllCategories($depthMarker = '') {
        $categoriesArray = [];
        $model = new CategoryModel();
        $categories = $model->find(['sort' => ['position' => 1]]);
        if (is_array($categories))
            foreach ($categories as $category) {
                $depthPrefix = '';
                if ($depthMarker != '') {
                    $parents = $this->getCategoryParents($category->_id);
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
        return $categoriesArray;
    }
    
    public function getAllArticles($onlyPublished = true, $version='all') {
        $model = new ArticleModel();
        
        $filter = [];
        
        if($onlyPublished) $filter['published'] = ['$eq' => '1'];
        if($version != 'all') $filter['version.'.$version] = ['$eq' => '1'];
        $filter['archival'] = ['$ne' => true];
        $articles = $model->find([
            $filter,
            'sort'=>['category'=> 1 ,'position' => 1]
        ]);
        
        $articlesArray = $this->getAllCategories();
        foreach($articlesArray as $categoryKey => $category) $articlesArray[$categoryKey] = [];
        
        if($articles) foreach($articles as $article) {
            $articlesArray[$article->category][] = $article;
        }
        
        $articlesArray = $this->removeEmptyCategories($articlesArray);
        
        return $articlesArray;
    }
    
    private function removeEmptyCategories($articles) {
        $categories = $this->getAllCategories('array');
        
        $depthLevels = 1; 
        foreach($categories as $category) {
            $numberOfParents = count($category['parents']);
            if($numberOfParents>$depthLevels) $depthLevels = $numberOfParents;
        }
        
        for($i=0; $i<$depthLevels; $i++) {
            foreach($articles as $categoryId => $articleGroup) {
                if(!isset($categories[$categoryId]) || !empty($articleGroup)) continue;
                
                $hasChildren = 0;
                foreach($categories as $category) {
                    if(in_array($categoryId,$category['parents'])) $hasChildren++;
                }
                
                if(!$hasChildren) unset($categories[$categoryId]);
            }
        }
        
        $notEmptyCategories = array_keys($categories);
        
        $newArticles = [];
        foreach($articles as $categoryId => $articleGroup) {
            if(in_array($categoryId,$notEmptyCategories)) $newArticles[$categoryId] = $articleGroup;
        }
        
        return $newArticles;
    }
    
    /*public function getPublished($versionRecordId = false) {
        $model = new ArticleModel();
        $filter = [];
        
        if($versionRecordId) $filter['version.'.$versionRecordId] = ['$eq' => '1'];
        $filter['published'] = ['$eq' => '1'];
        $filter['archival'] = ['$ne' => true];
        $articles = $model->find([
            $filter,
            'sort'=>['position' => 1]
        ]);
        
        return $articles;
    }
    
    public function getPublishedTree($versionRecordId = false) {
        $model = new ArticleModel();
        $filter = [];
        
        if($versionRecordId) $filter['version.'.$versionRecordId] = ['$eq' => '1'];
        $filter['published'] = ['$eq' => '1'];
        $filter['archival'] = ['$ne' => true];
        $articles = $model->find([
            $filter,
            'sort'=>['position' => 1]
        ]);
        
        $articlesTree = [];
        if($articles) foreach($articles as $article) {
            $parents = $this->getCategoryParents ($article->category);        
            $pathString = '';
            foreach($parents as $parent) {
                if($parent != 'null') $pathString = '["'.$parent.'"]'.$pathString;
            }
            $evalString = '$articlesTree';
            $evalString = $evalString.$pathString.'["'.$article->category.'"]["articles"] = $article->title;';
            eval($evalString);
        }
        return $articlesTree;
    }*/

    public function getCategoryParents($id, $parents=[]) {
        if(!$id || $id == 'null') return $parents;
        $category = $this->getCategory(''.$id);
        $parents[] = $category->parent;
        if($category->parent && $category->parent != 'null') {
            $parents = $this->getCategoryParents($category->parent,$parents);
        }
        return $parents;
    }
    
    public function getCategory($id)
    {        
        $object = CategoryModel::findById($id);
        return $object;
    }
    
    public function getCategoryParentsNames($id, $reversed=true) {
        $parentsIds = $this->getCategoryParents($id);
        $parentsNames = [];
        foreach($parentsIds as $parentId) {
            if($parentId != 'null') {
                $category = $this->getCategory($parentId);
                if($category) $parentsNames[] = $category->name;
            }
        }
        
        if($reversed) return array_reverse($parentsNames);
        else return $parentsNames;
    }
    
    public function getCategoryPath($id, $separator = ' > ')
    {
        if(!$id || $id == 'null') return '';
        
        $category = $this->getCategory($id);
        if(!$category) return '';
        
        $parents = $this->getCategoryParents($id);
        $parentsPath = $category->name;
        foreach($parents as $key => $parent) {
            if($parent && $parent!='null') {
                $parent = $this->getCategory($parent);
                if($parent) $parentsPath = $parent->name.$separator.$parentsPath;
            }
        }
        return $parentsPath;
    }
    
    public function getSupportedVersions($articleVersion) {
        $versions = [];
        if(!is_array($articleVersion)) return $versions;
                
        foreach($articleVersion as $key => $supported) {
            if($supported) {
                $version = $this->getVersion($key);
                if($version) $versions[] = $version;
            }
        }
        
        return $versions;
    }


    public function getVersion($id)
    {        
        $object = VersionModel::findById($id);
        return $object;
    }
    
    public function getVersionBySlug($slug)
    {        
        $object = VersionModel::findFirst([['slug'=>$slug]]);
        return $object;
    }
    
    public function search($query, $versionSlug='') {       
        $query = htmlentities($query);
        $version = null;
        if($versionSlug!='') $version = VersionModel::findFirst([['slug' => trim($versionSlug)]]);
        
        //find categories
        $paramsForCategories = ['name' => [ '$regex' => $query, '$options'=>'i' ]];
        $categories = CategoryModel::find([$paramsForCategories]);
        $categoriesIdsArray = [];
        if($categories) foreach($categories as $category) {
            $categoriesIdsArray[] = (string) $category->_id;
        }        

        //find articles
        $params = ['$or' => [
            ['title' => [ '$regex' => $query, '$options'=>'i' ]],
            ['content' => [ '$regex' => $query, '$options'=>'i' ]],
            ['category' => [ '$in' => $categoriesIdsArray ]]
        ]];
        $params['published'] = ['$eq' => '1'];
        $params['archival'] = ['$ne' => true];
        if($version) $params['version.'.$version->_id] = ['$eq' => '1'];
        $results = ArticleModel::find([$params]);

        return $results;
    }
    
    public function getLastVersionSlug($articleVersionArray) {
        if(is_array($articleVersionArray)) {
            foreach($articleVersionArray as $vId => $supported) {
                if($vId && $supported == 1) $versionId = $vId;
            }
            if(isset($versionId)) $version = $this->getVersion($versionId);
            if($version) return $version->slug;
        }
        return null;
    }
    
    public function adjustContent($content) {
        return $content;
    }
}