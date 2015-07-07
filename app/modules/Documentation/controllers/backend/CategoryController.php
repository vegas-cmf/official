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
use Documentation\Models\Category as CategoryModel;

/**
 * Class Documentation\Controller
 * @package Documentation\Controllers\Backend
 */
class CategoryController extends CrudAbstract
{
    protected $formName = 'Documentation\Forms\Category';
    protected $modelName = 'Documentation\Models\Category';
    
    protected $showFields = [
        'name' => 'Name',
        'slug' => 'Slug'
    ];
    
    public function indexAction()
    {
        $model = new CategoryModel();
        $categories = $model->find(['sort'=>['position' => 1]]);

        $this->view->categories = $categories;
    }

    public function treeUpdateAction()
    {
        if (!$this->request->isAjax()) {
            $this->throw404($this->_('Page not found.'));
        }
        
        $updated = 0;
        $failed = 0;
        $position = 0;
        $category = $this->request->getPost('category');
        if(is_array($category)) {
            foreach($category as $key => $parent) {
                $position++;
                $updateStatus = $this->serviceManager->getService('documentation:category')->updatePosition($key, $position, $parent);
                if($updateStatus!=false) {
                    $updated++;
                } else {
                    $failed++;
                }
            }
        }
        $message = $updated.' '.$this->i18n->_('categories updated').' '.$failed.' '.$this->i18n->_('failed');
        
        if($failed!=0) {
            $this->response->setStatusCode(500, $message);
            return $this->jsonResponse();
        }
        return $this->jsonResponse(['message' => $message]);
    }
}