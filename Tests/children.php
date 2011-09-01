<?php

require(__DIR__.'/../lib/vendor/jackalope/src/Jackalope/autoloader.php');

require_once __DIR__.'/../src/PHPCRTree.php';

$repository = Jackalope\RepositoryFactoryJackrabbit::getRepository(array(
    'jackalope.jackrabbit_uri' => 'http://localhost:8080/server'
));
$credentials = new PHPCR\SimpleCredentials('jakuza', 'jakuza');
$session = $repository->login($credentials, 'default');

$tree = new Ideato\TreeBundle\PHPCRTree($session);

$path = isset($_REQUEST['root']) && $_REQUEST['root'] !== 'source' ? $_REQUEST['root'] : '/';

echo $tree->getJSONChildren($path);