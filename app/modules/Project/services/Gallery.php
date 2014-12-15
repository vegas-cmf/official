<?php
/**
 * This file is part of Vegas package
 *
 * @author Jaroslaw <Macko>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Project\Services;

use Project\Models\Project;
use Vegas\DI\Service\ComponentAbstract;

class Gallery extends ComponentAbstract
{
    /**
     * Setups component
     *
     * @param array $params
     * @return mixed
     */
    protected function setUp($params = [])
    {
        return [
            'projects' => Project::find(['sort' => ['contributions' => -1]])
        ];
    }
}
