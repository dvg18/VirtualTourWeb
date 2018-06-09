<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 01.11.2017
 * Time: 1:59
 */

namespace App\Middleware;


class Middleware
{
    /**
     * @var
     */
    protected $container;

    /**
     * Middleware constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}