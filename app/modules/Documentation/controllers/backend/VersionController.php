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
 
namespace Documentation\Controllers\Backend;
use Vegas\Mvc\Controller\CrudAbstract;

/**
 * Class MenuController
 * @package Documentation\Controllers\Backend
 */
class VersionController extends CrudAbstract
{
    protected $formName = 'Documentation\Forms\Version';
    protected $modelName = 'Documentation\Models\Version';
    
    protected $indexFields = [
        'version_id' => 'Version ID',
        'description' => 'Description',
        'created_at' => 'Created at'
    ];

    protected $showFields = [
        'version_id' => 'Version ID',
        'description' => 'Description',
        'created_at' => 'Created at'
    ];
}