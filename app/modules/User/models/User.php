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
 
namespace User\Models;

use Auth\Models\BaseUser;

class User extends BaseUser
{
    public function validation()
    {
        $object = $this->findFirst([
            [
                'email' => $this->email
            ]
        ]);

        if ($object && (string)$object->_id !== (string)$this->_id) {
            throw new \Vegas\Exception('There is already an user with the same e-mail address.');
        }

        return true;
    }
} 