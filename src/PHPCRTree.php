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
    
    public function getChildrenJSON($path)
    {
        $root = $this->session->getNode($path);

        $children = array();

        foreach ($root->getNodes() as $name => $node) {
            $child = array(
                "text"  => $name,
                "id"    => $node->getPath(),
            );

            if ($node->getNodes('*')) {
                $child['hasChildren'] = true;
            }
            $children[] = $child;
        }
        
        return json_encode($children);
    }

    public function getPropertiesJSON($path)
    {
        $node = $this->session->getNode($path);
        $properties = array();
        
        foreach ($node->getPropertiesValues() as $name => $value) {
//            if ($value instanceof DateTime) {
//                $value = $value->format('d m Y hjjh');
//            }
            $property = array(
                "name" => $name,
                "value" => $value,
                
            );
            $properties[] = $property;
        }
        
        return json_encode($properties);
    }
}