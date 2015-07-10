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
 
namespace Documentation\Controllers;
use Vegas\Mvc\ControllerAbstract;

/**
 * Class DocumentationController
 * @package Documentation\Controllers
 */
class DocumentationController extends ControllerAbstract
{
    public function viewerAction($version=null, $category=null, $article=null)
    {
        $this->view->versionSlug = '';
        $this->view->categorySlug = '';
        $this->view->articleSlug = '';
        $this->view->activeArticle = '';
        
        $articleService = $this->serviceManager->getService('documentation:article');
        $categoryService = $this->serviceManager->getService('documentation:category');
        
        $versions = $this->serviceManager->getService('documentation:version')->getAll();
        $this->view->versions = $versions;
        if(in_array($version, $versions)) {
            $this->view->versionSlug = $version;
        }
        
        $categories = $categoryService->getAll('array');
        $this->view->categories = $categories;
        foreach($categories as $c) {
            if($c['slug'] == $category) {
                $this->view->categorySlug = $category;
                if($article) {
                    $activeArticle = $articleService->retrieveBySlug($version, $category, $article);
                }
            }
        }

        if(!isset($activeArticle)) {
            $activeArticle = $articleService->retrieveFirst($version, $category);
        }
        
        $this->view->activeArticle = $activeArticle;
        $this->view->articleSlug = $article;
        $this->view->articleService = $articleService;
        $this->view->categoryService = $categoryService;
        $this->view->searchQuery = $this->request->get('search');
    }
    
    public function pdfAction($versionSlug) {
        $version = $this->serviceManager->getService('documentation:version')->retrieveBySlug($versionSlug);

        if (!$version) {
            $this->throw404($this->_('Page not found.'));
        }

        $this->view->disable();
        $this->response->setHeader('Content-Type', 'application/pdf');

        $renderParams = [
            'version' => $version,
            'templateName' => 'versionAsPdf',
            'serviceManager' => $this->serviceManager
        ];

        $filename = 'vegas_' . $versionSlug . '_documentation.pdf';
        $this->serviceManager->getService('documentation:pdf')->renderPdf($filename, $renderParams);
    }
}