<?php
namespace RouterBenchmark;

use Athletic\AthleticEvent;
use Zend_Config;
use Zend_Controller_Request_Http;
use Zend_Controller_Router_Rewrite;

class Zf1Event extends AthleticEvent
{
    /**
     * @var Zend_Controller_Router_Rewrite
     */
    protected $router;

    public function classSetUp()
    {
        $config = new Zend_Config(array(
            'home' => array(
                'type'     => 'Zend_Controller_Router_Route_Static',
                'route'    => '/',
                'defaults' => array(
                    'controller' => 'bar',
                    'action'     => 'foo'
                ),
            ),
            'user' => array(
                'type'     => 'Zend_Controller_Router_Route_Static',
                'route'    => '/user',
                'defaults' => array(
                    'controller' => 'bar',
                    'action'     => 'foo'
                ),
                'chains' => array(
                    'create' => array(
                        'type'     => 'Zend_Controller_Router_Route_Static',
                        'route'    => '/create',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    ),
                    'edit' => array(
                        'type'     => 'Zend_Controller_Router_Route_Regex',
                        'route'    => '/edit/(\d+)',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    ),
                    'delete' => array(
                        'type'     => 'Zend_Controller_Router_Route_Regex',
                        'route'    => '/delete/(\d+)',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    )
                )
            ),
            'blog' => array(
                'type'     => 'Zend_Controller_Router_Route_Static',
                'route'    => '/blog',
                'defaults' => array(
                    'controller' => 'bar',
                    'action'     => 'foo'
                ),
                'chains' => array(
                    'article' => array(
                        'type'     => 'Zend_Controller_Router_Route_Regex',
                        'route'    => '/[A-z]+',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    ),
                    'create' => array(
                        'type'     => 'Zend_Controller_Router_Route_Static',
                        'route'    => '/create',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    ),
                    'edit' => array(
                        'type'     => 'Zend_Controller_Router_Route_Regex',
                        'route'    => '/edit/(\d+)',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    ),
                    'delete' => array(
                        'type'     => 'Zend_Controller_Router_Route_Regex',
                        'route'    => '/delete/(\d+)',
                        'defaults' => array(
                            'controller' => 'controller',
                            'action'     => 'action'
                        )
                    )
                )
            )
        ));

        $this->router = new Zend_Controller_Router_Rewrite();
        $this->router->addConfig($config);
        $this->router->setChainNameSeparator('/');
    }

    /**
     * @iterations 1000
     */
    public function firstMatch()
    {
        $request = new Zend_Controller_Request_Http('http://example.com/blog/delete/1');
        $this->router->route($request);
    }

    /**
     * @iterations 1000
     */
    public function lastMatch()
    {
        $request = new Zend_Controller_Request_Http('http://example.com/');
        $this->router->route($request);
    }
}
