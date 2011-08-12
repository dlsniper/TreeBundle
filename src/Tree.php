<?php

namespace Ideato\TreeBundle;

require_once __DIR__.'/TreeInterface.php';

/**
 * @author cirpo <alessandro.cinelli@gmail.com>
 * @author jacopo romei <jromei@gmail.com>
 */
class Tree implements TreeInterface, \RecursiveIterator
{
    public $text,
           $children = array();

    public function getChildren()
    {
        return $this->children;
    }

    public function current()
    {}

    public function next()
    {}

    public function prev()
    {}

    public function key()
    {}

    public function valid()
    {}

    public function rewind()
    {}

    public function hasChildren()
    {
        return (bool)sizeof($this->children);
    }

    public function setLabel($label)
    {
        $this->text = $label;
    }

    public function add($child)
    {
        $this->children[] = $child;
    }

    public function __toString()
    {
        return '['.json_encode($this).']';
        return sprintf('[{ "text": "%s"}]', $this->label);
    }

    public function getNode(array $path)
    {
        if (count($path) == 1)
        {
            return $this->children[$path[0]];
        }
        else
        {
            $i = array_shift($path);
            return $this->children[$i]->getNode($path);
        }


    }

    public function toJson($depth = 1)
    {

    }

    public function prune($depth)
    {

        $clone = $this;

        if ($depth == 0)
        {
            $clone->resetChildren();
        }
        else
        {
            foreach ($this->children as $child)
            {
                $clone->add($child->prune($depth - 1));
            }
        }

        return $clone;

    }

    public function __clone()
    {
       if (!$this->hasChildren())
       {
           return $this;
       }
       else
       {
           return $clone = clone $this;
       }

    }



    public function resetChildren()
    {
        $this->children = array();
    }

}