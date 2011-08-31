<?php

require(__DIR__.'/../lib/vendor/jackalope/src/Jackalope/autoloader.php');

require_once __DIR__.'/../src/TreeInterface.php';
require_once __DIR__.'/../src/Tree.php';

class TreeTest extends \PHPUnit_Framework_TestCase
{

    public function testPHPCRRootToJSONRoot()
    {

        $repository = Jackalope\RepositoryFactoryJackrabbit::getRepository(array(
            'jackalope.jackrabbit_uri' => 'http://localhost:8080/server'
        ));
        $credentials = new PHPCR\SimpleCredentials('jakuza', 'jakuza');
        $session = $repository->login($credentials, 'default');

        $root = $session->getNode('/');

        $tree = array();

        foreach ($root->getNodes('*') as $name => $node) {
            $child = array(
                "text"  => $name,
                "id"    => $node->getPath(),
            );
            if ($node->getNodes('*')) {
                $child['hasChildren'] = true;
            }
            $tree[] = $child;
        }

    }

}

