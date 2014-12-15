<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <dev@mateusz-aniolek.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace File\Models;

class File extends \Vegas\Db\Decorator\CollectionAbstract implements \Vegas\Media\Db\FileInterface
{
    public function getSource()
    {
        return 'vegas_files';
    }
}
