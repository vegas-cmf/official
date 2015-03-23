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
 
namespace Error\Controllers;

use Home\Forms\Contact;
use Vegas\Forms\Element\Hidden;
use Vegas\Forms\Exception;
use Vegas\Mvc\ControllerAbstract;

/**
 * Class DefaultController
 * @package Error\Controllers
 */
class DefaultController extends ControllerAbstract
{
    public function error404Action()
    {
        $this->view->setLayout('error');
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);

        $this->view->error = new \Vegas\Exception($this->i18n->_('Page not found'), 404);
    }
} 