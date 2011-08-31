<?php

require(__DIR__.'/../lib/vendor/jackalope/src/Jackalope/autoloader.php');

$repository = Jackalope\RepositoryFactoryJackrabbit::getRepository(array(
    'jackalope.jackrabbit_uri' => 'http://localhost:8080/server'
));
$credentials = new PHPCR\SimpleCredentials('jakuza', 'jakuza');
$session = $repository->login($credentials, 'default');

$root = isset($_REQUEST['root']) && $_REQUEST['root'] !== 'source' ? $_REQUEST['root'] : '/';
$root = $session->getNode($root);

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

echo json_encode($tree);

?>