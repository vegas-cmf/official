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

namespace Documentation\Services;

/**
 * Class Document
 * @package Documentation\Services
 */
class Pdf extends \Vegas\DI\Service\ComponentAbstract
{
    public $params = [
        'fontSize'           => 10,
        'format'             => 'A4',
        'title' => 'Vegas CMF Documentation',
        'author' => 'Vegas CMF Team',
        'outputDestination'  => 'I'
    ];
    
    protected function setUp($params = array())
    {
        return $params;
    }
    
    public function renderPdf($filename, $params = [], $filePath = '')
    {
        $params = array_merge($this->params, $params);

        if(isset($params['templateName'])) {
            $this->getRenderer()->setTemplateName($params['templateName']);
        }
        $content = $this->render($params);
        
        define('_MPDF_TTFONTDATAPATH', APP_ROOT . '/public/mpdf/ttfontdata/');
        define('_MPDF_TEMP_PATH', APP_ROOT . '/public/mpdf/tmp/');
        
        set_error_handler('\\Documentation\\Services\\Exception\\mPDFErrorHandler::error');
        $mpdf = new \mPDF('utf-8', $params['format'], $params['fontSize']);
        $mpdf->SetTitle($params['title']);
        $mpdf->SetAuthor($params['author']);
        $mpdf->SetAutoPageBreak(true, 35);
        $mpdf->defaultheaderfontsize = 24;

        if(is_array($content)) {
            $contentPartsLength = count($content) - 1;
            foreach($content as $index => $contentPart) {
                $mpdf->WriteHTML($contentPart);

                if($index < $contentPartsLength) {
                    $mpdf->addPage();
                }
            }
        } else {
            $mpdf->WriteHTML($content);
        }

        $mpdf->SetDisplayMode('fullpage');
        return $mpdf->Output($filePath . $filename, $params['outputDestination']);
    }
}