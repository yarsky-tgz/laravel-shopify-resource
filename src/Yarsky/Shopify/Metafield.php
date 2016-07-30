<?php

namespace App\Shopify;

class Metafield extends Resource
{

    protected $_parent = null;

    const RESOURCE_NAME_MULT = 'metafields';
    const RESOURCE_NAME = 'metafield';

    public function setParent($parent)
    {
        $this->_parent = $parent;
    }

    protected function _getCreateUrl()
    {
        $class = get_class($this->_parent);
        return $class::RESOURCE_NAME_MULT . '/' . $this->_parent->id . '/metafields.json';
    }

}
