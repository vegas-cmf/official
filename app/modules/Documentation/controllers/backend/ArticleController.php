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
use Vegas\Paginator\Adapter\Mongo;

/**
 * Class MenuController
 * @package Documentation\Controllers\Backend
 */
class ArticleController extends CrudAbstract
{
    protected $formName = 'Documentation\Forms\Article';
    protected $modelName = 'Documentation\Models\Article';
    
    public function indexAction() {
        $this->view->articleService = $this->serviceManager->getService('documentation:article');
    }
    
    public function archivedAction($id) {
        $article = \Documentation\Models\Article::findById($id);
        $this->view->article = $article;

        $this->initializeScaffolding();

        $paginator = (new Mongo([
            'db' => $this->mongo,
            'modelName' => 'Documentation\Models\Article',
            'limit' => 20,
            'page' => $this->request->get('page', 'int', 1),
            'query' => ['parent' => $id],
            'sort' => [
                'name' => 1
            ]
        ]));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function showArchivedAction($id) {
        parent::showAction($id);
    }
    
    public function editContentAction($id) {
        $this->view->setLayout('editor');
        if(!empty($id)) {
            $article = $this->serviceManager->getService('documentation:article')->getArticle($id);
            if($article) {
                $this->view->article = $article;
            }
        }
        
        if (!$article) {
            $this->throw404($this->_('Page not found.'));
        }
    }
    
    public function updateContentAction()
    {
        if (!$this->request->isAjax()) {
            $this->throw404($this->_('Page not found.'));
        }
        
        $postData = $this->request->getPost();
        
        $message = 'Failed';
        $updated = false;
        
        if(isset($postData['article'],$postData['content'])) {
            if(!isset($postData['archival'])) $postData['archival'] = 0;
            $updateStatus = $this->serviceManager->getService('documentation:article')->updateContent($postData['article'],$postData['content'],$postData['contentRendered'],$postData['archival']);
            if($updateStatus!=false) {
                if($postData['archival']) $message = 'Archival copy made';
                else $message = 'Updated';
                $updated = true;
            }
        }      
        
        if(!$updated) $this->response->setStatusCode(500, $message);
        return $this->jsonResponse(['message' => $message, 'status' => $updated]);
    }
    
    public function updatePositionsAction()
    {
        if (!$this->request->isAjax()) {
            $this->throw404($this->_('Page not found.'));
        }
        
        $postData = $this->request->getPost();
        
        $updated = 0;
        $failed = 0;
        $position = 0;
        if(!empty($postData)) foreach($postData as $category => $articles) {
            foreach($articles as $article) {
                $position++;
                $updateStatus = $this->serviceManager->getService('documentation:article')->updatePosition($article, $position);
                if($updateStatus!=false) $updated++;
                else $failed++;
            }
        }
        
        $message = $updated.' '.$this->i18n->_('articles updated').' '.$failed.' '.$this->i18n->_('failed');
        
        $status = ($failed==0);
        if(!$status) $this->response->setStatusCode(500, $message);
        
        return $this->jsonResponse(['message' => $message, 'status' => $status]);
    }
}