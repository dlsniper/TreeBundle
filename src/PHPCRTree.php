<?php

namespace Ideato\TreeBundle;

/**
 * A simple class to get PHPCR trees in JSON format
 *
 * @author Jacopo 'Jakuza' Romei <jromei@gmail.com>
 */
class PHPCRTree
{
    private $session;
    
    public function __construct($session)
    {
        $this->session = $session;
    }
    
    public function getJSON($path)
    {
        $root = $this->session->getNode($path);

        $tree = array();
//var_dump($root->getNodes('*'));die('ukuyuyiu');

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
        
        return json_encode($tree);
    }
}