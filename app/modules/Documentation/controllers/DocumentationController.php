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
    public function viewerAction($version=null,$category=null,$article=null)
    {
        $this->view->versionSlug = '';
        $this->view->categorySlug = '';
        $this->view->articleSlug = '';
        $this->view->activeArticle = '';
        
        $articleService = $this->serviceManager->getService('documentation:article');
        
        $versions = $articleService->getAllVersions();
        $this->view->versions = $versions;
        if(in_array($version,$versions)) $this->view->versionSlug = $version;
        
        $categories = $articleService->getAllCategories('array');
        $this->view->categories = $categories;
        foreach($categories as $c) {
            if($c['slug'] == $category) {
                $this->view->categorySlug = $category;
                if($article) $activeArticle = $articleService->getArticleBySlug($version,$category,$article);
            }
        }

        if(!isset($activeArticle)) {
            $activeArticle = $articleService->getFirstArticle($version,$category);
        }
        
        $this->view->activeArticle = $activeArticle;
        $this->view->articleSlug = $article;
        $this->view->articleService = $articleService;
        $this->view->searchQuery = $this->request->get('search');
    }
    
    public function pdfAction($versionSlug)
    {
        $articleService = $this->serviceManager->getService('documentation:article');
        $version = $articleService->getVersionBySlug($versionSlug);
        if($version) {
            $this->view->disable();
            $this->response->setHeader('Content-Type', 'application/pdf');
            
            $renderParams = [
                'version' => $version,
                'templateName'=>'versionAsPdf',
                'articleService' => $articleService
            ];

            $filename = 'vegas_'.$versionSlug.'_documentation.pdf';
            $this->serviceManager->getService('documentation:pdf')->renderPdf($filename,$renderParams);
        }
    }
}