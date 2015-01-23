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
 
namespace Project\Controllers\Backend;

use Vegas\Media\Helper As MediaHelper;
use Vegas\Mvc\Controller\CrudUploadAbstract;

/**
 * Class ProjectController
 * @package Project\Controllers\Backend
 */
class ProjectController extends CrudUploadAbstract
{
    protected $formName = '\Project\Forms\Project';
    protected $modelName = '\Project\Models\Project';

    protected $indexFields = [
        'name' => 'Name',
        'url' => 'Url',
        'created_at' => 'Created at'
    ];

    protected $showFields = [
        'name' => 'Project name',
        'url' => 'Project url'
    ];

    protected function afterSave()
    {
        $this->processImages();
        parent::afterSave();
    }

    private function processImages()
    {
        try {
            $record =  $this->scaffolding->getRecord();
            $mapped = $record->readMapped('image');

            MediaHelper::moveFilesFrom($mapped);
            MediaHelper::generateThumbnailsFrom($mapped, ['width' => 600, 'height' => 300]);
        } catch(\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }
} 