<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 27.10.2017
 * Time: 19:12
 */

namespace App\Controllers;

use Psr\Log\LoggerInterface;

class Controller
{
    /**
     * @var
     */
    protected $container;
    //private $view;
    //private $logger;

    /**
     * Controller constructor.
     * @param $container
     */
    public function __construct($container)//, Twig $view, LoggerInterface $logger)
    {
        //$this->view = $view;
        //$this->logger = $logger;
        $this->container = $container;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
        //var_dump($property);
    }
}