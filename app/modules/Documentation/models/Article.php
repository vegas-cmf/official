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

class Article extends CollectionAbstract
{
    public $title;
    public $version;
    public $category;
    public $content;
    public $contentRendered;
    
    public $slug;
    public $published = false;
    public $position;
    public $archival = false;
    public $parent = null;

    private $archiveFields = [
        'title',
        'version',
        'category',
        'content',
        'contentRendered',
        'slug',
        'published',
        'position'
    ];
    
    public function getSource()
    {
        return 'documentation_article';
    }
    
    public function beforeSave()
    {
        $this->removeNotSupportedVersions();
        $this->generateSlug($this->title);
    }
    
    public function beforeUpdate()
    {
        parent::beforeUpdate();
        if(!$this->archival) {
            $this->makeCopyToArchive();
        }
    }
    
    public function beforeDelete()
    {
        if(!$this->archival) {
            $this->makeCopyToArchive();
        }
    }
    
    public function makeCopyToArchive($previousState = 1)
    {
        if($previousState) {
            $source = Article::findById($this->_id);
        } else {
            $source = $this;
        }
        $articleCopy = new Article();
        
        foreach($this->archiveFields as $key){
            $articleCopy->{$key} = $source->{$key};
        }
        
        $articleCopy->updated_at = $source->updated_at;
        $articleCopy->archival = true;
        $articleCopy->parent = ''.$this->_id;
        
        return $articleCopy->save();
    }
    
    private function removeNotSupportedVersions() {
        $versionArr = [];
        foreach($this->version as $key => $value) {
            if($value == 1) $versionArr[$key] = $value;
        }
        $this->version = $versionArr;
    }
}
