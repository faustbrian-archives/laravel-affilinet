<?php

/*
 * This file is part of Laravel Affilinet.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Affilinet;

use BrianFaust\AffilinetSdk\Client;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class AffilinetManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \BrianFaust\Affilinet\AffilinetFactory
     */
    private $factory;

    /**
     * Create a new Affilinet manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \BrianFaust\Affilinet\AffilinetFactory  $factory
     */
    public function __construct(Repository $config, AffilinetFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Get the factory instance.
     *
     * @return \BrianFaust\Affilinet\AffilinetFactory
     */
    public function getFactory(): AffilinetFactory
    {
        return $this->factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function createConnection(array $config): Client
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'laravel-affilinet';
    }
}
