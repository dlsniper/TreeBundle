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

echo $tree->getJSON($path);

//echo "<hr/>";
//
//$content = $session->getNode('/com/anonimarmonisti/www/uploads/assets/anonima-armonisti-scheda-tecnica.pdf');
//
//foreach ($content->getPropertiesValues() as $name => $value) {
//    
//    if ($value instanceof DateTime) {
//        $value = $value->format('d m Y');
//    }
//
//    echo "$name: $value<br/>";
//}
//
//// read a binary property. TODO: have binary data in demo content
//$property = $content->getProperty('jcr:data');

//$data = $property->getString(); // read binary into string
//echo "Text (size ".$property->getLength()."):\n";
//echo $data;
//
//$stream = $property->getBinary(); // get binary stream
//fpassthru($stream);
//fclose($stream);
//
//fpassthru($node->getPropertyValue('jcr:data')); // the above in short if you just want to dump the file


?>