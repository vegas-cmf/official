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
 
namespace Contributor\Controllers\Backend;

use Contributor\Models\Contributor;
use Vegas\Mvc\ControllerAbstract;

/**
 * Class ProjectController
 * @package Contributor\Controllers\Backend
 */
class GitHubController extends ControllerAbstract
{
    public function indexAction()
    {
        $this->view->contributors = Contributor::find();
    }

    public function refreshAction()
    {
        $this->serviceManager->get('contributor:contributor')->refreshAll();

        return $this->response->redirect([
            'for' => 'admin/contributor',
            'action' => 'index'
        ]);
    }
} 