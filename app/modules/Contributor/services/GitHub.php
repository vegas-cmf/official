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

namespace Contributor\Services;

use Contributor\Models\Contributor;
use Vegas\DI\Service\ComponentAbstract;

class GitHub extends ComponentAbstract
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
            'users' => Contributor::find(['sort' => ['contributions' => -1]])
        ];
    }
}
