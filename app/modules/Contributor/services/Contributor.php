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

use Contributor\Models\Contributor As ContributorModel;
use Phalcon\DI\InjectionAwareInterface;
use Vegas\DI\InjectionAwareTrait;
use Github\Client;
use Github\HttpClient\CachedHttpClient;

class Contributor implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function refreshAll()
    {
        foreach ($this->retrieveFromGitHub() As $contributor) {
            $contributorModel = ContributorModel::findFirst([[
                'login' => $contributor['login']
            ]]);

            if (!$contributorModel) {
                $contributorModel = new ContributorModel();
            }

            $contributorModel->writeAttributes($contributor);
            $contributorModel->save();
        }
    }

    private function retrieveFromGitHub()
    {
        $client = new Client(
            new CachedHttpClient([
                'cache_dir' => $this->getDI()->get('config')->application->view->cacheDir.'github-api-cache'
            ])
        );

        $allContributors = [];
        $externalBasedRepo = ['fpdf', 'pretty-exceptions'];

        foreach ($client->api('organization')->repositories('vegas-cmf') As $repo) {
            if (in_array($repo['name'], $externalBasedRepo)) {
                continue;
            }

            foreach ($client->api('repository')->contributors('vegas-cmf', $repo['name']) As $contributor) {
                if ($contributor['type'] !== 'User') {
                    continue;
                }

                if (isset($allContributors[$contributor['login']])) {
                    $allContributors[$contributor['login']]['contributions'] += $contributor['contributions'];
                } else {
                    $allContributors[$contributor['login']] = $contributor;
                }
            }
        }

        return $allContributors;
    }
}
