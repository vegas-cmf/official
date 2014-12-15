<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Project\Models;

use Vegas\Db\Decorator\CollectionAbstract;

class Project extends CollectionAbstract
{
    protected $mappings = [
        'image' => 'file'
    ];

    public function getThumbnail()
    {
        if (!empty($this->image)) {
            $files = $this->readMapped('image');
            $filePath = $files[0]->getThumbnailPath(600, 300);
            if (file_exists($filePath)) {
                $fileUrl = $files[0]->getThumbnailUrl(600, 300);
            } else {
                $fileUrl = $files[0]->getUrl();
            }
            return $fileUrl;
        }

        return false;
    }
} 