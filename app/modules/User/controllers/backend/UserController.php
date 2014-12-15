<?php
/**
 * This file is part of Vegas package
 *
 * @author Adrian Malik <adrian.malik.89@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace User\Controllers\Backend;

use User\Models\User as UserModel;
use Vegas\Mvc\Controller\CrudAbstract;

/**
 * Class MenuController
 * @package User\Controllers\Backend
 */
class UserController extends CrudAbstract
{
    protected $formName = 'User\Forms\User';
    protected $modelName = 'User\Models\User';
}