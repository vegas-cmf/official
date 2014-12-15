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

namespace Home\Services;

use Phalcon\DI\InjectionAwareInterface;
use Vegas\DI\InjectionAwareTrait;
use Vegas\Forms\Exception;
use Home\Forms\Contact as ContactForm;
use Home\Models\Contact as ContactModel;

class Contact implements InjectionAwareInterface
{
    const FLOOD_TIME_LIMIT = 30;

    use InjectionAwareTrait;

    public function sendMessage($request)
    {
        $senderIp = $request->getClientAddress();

        $this->validateIp($senderIp);

        $object = new ContactModel();
        $object->sender_ip = $senderIp;

        $form = new ContactForm();
        $form->bind($request->getPost(), $object);

        if (!$form->isValid()) {
            throw new Exception($this->getDI()->get('i18n')->_('All fields must be filled and valid.'));
        }

        $object->save();
    }

    private function validateIp($senderIp)
    {
        $lastEmail = ContactModel::findFirst([
            [
                'sender_ip' => $senderIp
            ],
            'sort' => [
                'created_at' => -1
            ]
        ]);

        if (!$lastEmail) {
            return;
        }

        $intervalTime = time()-self::FLOOD_TIME_LIMIT;
        $floodLimitLeft = $lastEmail->created_at-$intervalTime;

        if ($floodLimitLeft > 0) {
            throw new Exception($this->getDI()->get('i18n')->_('You can send next message after').': '.$floodLimitLeft.'s.');
        }
    }
}
