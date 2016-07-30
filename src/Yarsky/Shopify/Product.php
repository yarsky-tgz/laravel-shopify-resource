<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 27.07.2016
 * Time: 16:57
 */

namespace Yarsky\Shopify;

use Sh;

class Product extends Resource
{

    protected $_metafields = null;

    const RESOURCE_NAME_MULT = 'products';
    const RESOURCE_NAME = 'product';

    public function metafields($options = array())
    {
        if ($this->_metafields !== null) {
            return $this->_metafields;
        }

        $results =  Sh::call([
            'METHOD' => 'GET',
            'URL' =>  static::RESOURCE_NAME_MULT . '/' . $this->_id . '/metafields.json',
            'DATA' => $options
        ]);

        $data = $results->metafields;

        if (empty($data)) {
            $this->_metafields = [];
        } else {
            $this->_metafields = Metafield::collect($data);

            foreach ($this->_metafields as $metafield) {
                $metafield->setParent($this);
            }
        }

        return $this->_metafields;
    }

}
