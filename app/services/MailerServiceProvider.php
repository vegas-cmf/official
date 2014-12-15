<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <aostrycharz@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Phalcon\DiInterface;
use Vegas\DI\ServiceProviderInterface;

/**
 * Class MailerServiceProvider
 */
class MailerServiceProvider implements ServiceProviderInterface
{
    const SERVICE_NAME = 'mailer';

    /**
     * {@inheritdoc}
     */
    public function register(DiInterface $di)
    {
        $di->set(self::SERVICE_NAME, function() use ($di) {
            $mailSettings = $di->get('config')->mail;
            $mailer = new \Swift_Mailer(
                (new \Swift_SmtpTransport(
                    $mailSettings->smtp->host,
                    $mailSettings->smtp->port
                ))
                    ->setUsername($mailSettings->smtp->username)
                    ->setPassword($mailSettings->smtp->password)
            );

            return $mailer;
        }, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return array();
    }
} 