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
 
namespace Home\Controllers;

use Home\Forms\Contact;
use Vegas\Forms\Element\Hidden;
use Vegas\Forms\Exception;
use Vegas\Mvc\ControllerAbstract;

/**
 * Class HomeController
 * @package Home\Controllers
 */
class HomeController extends ControllerAbstract
{
    public function indexAction()
    {
        $this->view->contactForm = new Contact();

        $token = new Hidden($this->security->getTokenKey());
        $token->setDefault($this->security->getToken());

        $this->view->contactToken = $token;
    }

    public function contactAction()
    {
        if (!$this->request->isAjax()) {
            $this->throw404($this->_('Page not found.'));
        }

        try {
            if (!$this->security->checkToken()) {
                throw new Exception($this->_('Invalid token.'));
            }

            $this->serviceManager->get('home:contact')->sendMessage($this->request);
        } catch (\Exception $ex) {
            $this->response->setStatusCode(500, $ex->getMessage());
            return $this->jsonResponse();
        }

        return $this->jsonResponse(['message' => $this->_('Email has been sent.')]);
    }
} 