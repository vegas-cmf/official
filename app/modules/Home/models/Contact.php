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
 
namespace Home\Models;

use Vegas\Db\Decorator\CollectionAbstract;

class Contact extends CollectionAbstract
{
    public function save()
    {
        if (!parent::save()) {
            throw new \Vegas\Exception('Unexpected error when saving email.');
        }

        try {
            $mailer = $this->getDI()->get('mailer');

            $message = new \Swift_Message('Vegas CMF - contact form message');
            $message->setBody($this->content);
            $message->setFrom([
                $this->email => $this->name
            ]);
            $message->setTo([
                $this->getDI()->get('config')->mail->admin->email
            ]);

            $mailer->send($message);
        } catch (\Exception $ex) {
            throw new \Vegas\Exception('Unexpected error when sending email.');
        }

        return true;
    }
}
