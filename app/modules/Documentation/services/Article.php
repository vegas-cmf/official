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
use Phalcon\DI\InjectionAwareInterface;
use Vegas\DI\InjectionAwareTrait;

class Article implements InjectionAwareInterface
{
    use InjectionAwareTrait;
    
    private $serviceVersion = null;
    private $serviceCategory = null;

    private function getServiceVersion()
    {
        if($this->serviceVersion === null) {
            $this->serviceVersion = $this->di->get('serviceManager')->get('documentation:version');
        }
        return $this->serviceVersion;
    }
    
    private function getServiceCategory()
    {
        if($this->serviceCategory === null) {
            $this->serviceCategory = $this->di->get('serviceManager')->get('documentation:category');
        }
        return $this->serviceCategory;
    }
    
    public function updateContent($id, $content, $contentRendered, $archival=false)
    {
        $article = $this->getArticle($id);
        if(!empty($article)) {
            $article->content = $content;
            $article->contentRendered = $contentRendered;
            if($archival) {
                return $article->makeCopyToArchive(0);
            }
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
        $version = $this->getServiceVersion()->getObjectBySlug($versionSlug);
        if(!$version) {
            return null;
        }
        $model = new ArticleModel();
        $conditions = [];
        if($onlyPublished) {
            $conditions['published'] = ['$eq' => '1'];
        }
        $conditions['version.'.$version->_id] = ['$eq' => '1'];
        $conditions['archival'] = ['$ne' => true];
        $conditions['slug'] = $articleSlug;
        $articles = $model->find([
            $conditions,
            'sort'=>['category'=> 1 ,'position' => 1]
        ]);
        
        if($articles) {
            foreach($articles as $article) {
                $category = $this->getServiceCategory()->getObject($article->category);
                if($category->slug == $categorySlug) {
                    return $article;
                }
            }
        }
        return null;
    }
    
    public function getFirstArticle($versionSlug=null,$categorySlug=null)
    {
        $version = $this->getServiceVersion()->getObjectBySlug($versionSlug);
        $category = $this->getServiceCategory()->getObjectBySlug($categorySlug);
                
        if($version) {
            $articles = $this->getAllArticles(true, (string) $version->_id);
        } else {
            $articles = $this->getAllArticles(true,'all');
        }
        
        if(!$category) {
            $categories = $this->getServiceCategory()->getAll();
            foreach(array_keys($categories) as $categoryId) {
                if(isset($articles[(string)$categoryId][0])) {
                    return $articles[(string)$categoryId][0];
                }
            }
        } 
        
        if(isset($articles[(string)$category->_id][0])) {
            return $articles[(string)$category->_id][0];
        }
        
        return null;
    }
    
    public function getAllArticles($onlyPublished = true, $version='all')
    {
        $conditions = [];
        $articlesArray = [];
        
        if($onlyPublished) {
            $conditions['published'] = ['$eq' => '1'];
        }
        if($version != 'all') {
            $conditions['version.'.$version] = ['$eq' => '1'];
        }
        $conditions['archival'] = ['$ne' => true];
        $articles = ArticleModel::find([
            $conditions,
            'sort'=>['category'=> 1 ,'position' => 1]
        ]);
        
        if($articles) {
            foreach($articles as $article) {
                $articlesArray[$article->category][] = $article;
            }
        }
        
        return $articlesArray;
    }
    
    public function countArticles($categoryId, $articles)
    {
        $numberOfArticles = 0;
        $categoryChildrenIds = $this->getServiceCategory()->getChildren($categoryId);
        
        foreach($articles as $groupId => $articleGroup) {
            
            if($groupId == $categoryId || in_array($groupId,$categoryChildrenIds)) {
                $numberOfArticles += count($articleGroup);
            }
        }
        
        return $numberOfArticles;
    } 
    
    public function search($query, $versionSlug='')
    {       
        $query = htmlentities($query);
        $version = null;
        if($versionSlug!='') {
            $version = $this->getServiceVersion()->getObjectBySlug($versionSlug);
        }
        //find categories
        $categories = $this->getServiceCategory()->search($query);
        $categoriesIdsArray = [];
        if($categories) {
            foreach($categories as $category) {
                $categoriesIdsArray[] = (string) $category->_id;
            }        
        }
        
        //find articles
        $params = ['$or' => [
            ['title' => [ '$regex' => $query, '$options'=>'i' ]],
            ['content' => [ '$regex' => $query, '$options'=>'i' ]],
            ['category' => [ '$in' => $categoriesIdsArray ]]
        ]];
        $params['published'] = ['$eq' => '1'];
        $params['archival'] = ['$ne' => true];
        if($version) {
            $params['version.'.$version->_id] = ['$eq' => '1'];
        }
        $results = ArticleModel::find([$params]);

        return $results;
    }
    
    
    public function getConnectedVersions($articleVersion)
    {
        $versions = [];
        if(!is_array($articleVersion)) {
            return $versions;
        }
        
        foreach(array_keys($articleVersion) as $key) {
            $version = $this->getServiceVersion()->getObject($key);
            if($version) {
                $versions[] = $version;
            }
        }
        
        return $versions;
    }
    
    public function getLastConnectedVersionSlug($articleVersionArray)
    {
        if(is_array($articleVersionArray) && count($articleVersionArray)>0) {
            $connectedVersions = array_keys($articleVersionArray);
            $versionId = $connectedVersions[count($connectedVersions)-1];
            
            if(isset($versionId)) {
                $version = $this->getServiceVersion()->getObject($versionId);
            }
            if($version) {
                return $version->slug;
            }
        }
        return null;
    }
}