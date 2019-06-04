<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Affilinet.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Affilinet;

use Artisanry\Affilinet\Client;
use InvalidArgumentException;

class AffilinetFactory
{
    /**
     * Make a new Affilinet client.
     *
     * @param array $config
     *
     * @return \Artisanry\Affilinet\Client
     */
    public function make(array $config): Client
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig(array $config): array
    {
        $keys = ['username', 'password'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new InvalidArgumentException("Missing configuration key [$key].");
            }
        }

        return array_only($config, ['username', 'password']);
    }

    /**
     * Get the Affilinet client.
     *
     * @param array $auth
     *
     * @return \Artisanry\Affilinet\Client
     */
    protected function getClient(array $auth): Client
    {
        return new Client($auth['username'], $auth['password']);
    }
}
