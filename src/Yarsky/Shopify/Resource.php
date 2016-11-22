<?php

namespace Yarsky\Shopify;

use Sh;
use Debugbar;
use Redis;

class Resource
{

    protected $_attributes;
    protected $_id = null;

    public function __construct($attributes = array())
    {
        $this->init($attributes);
    }

    public function __set($name, $value)
    {
        if ($name == 'id') {
            $this->_id = $value;
        }

        $this->_attributes->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->_attributes->{$name};
    }

    public function init($attributes)
    {
        if (!$attributes) {
            $attributes = new \stdClass();
        }

        $this->_attributes = $attributes;
        $this->_id = isset($attributes->id) ? $attributes->id : null;
    }

    public static function find($options = array())
    {
        $results =  self::call([
            'METHOD' => 'GET',
            'URL' =>  static::RESOURCE_NAME_MULT . '.json',
            'DATA' => $options
        ]);

        $data = $results->{static::RESOURCE_NAME_MULT};

        return static::collect($data);
    }

    public static function one($id, $options = array())
    {
        $results =  self::call([
            'METHOD' => 'GET',
            'URL' =>  static::RESOURCE_NAME_MULT . '/' . $id . '.json',
            'DATA' => $options
        ]);

        $data = $results->{static::RESOURCE_NAME};
        return new static($data);
    }

    public static function collect($items)
    {
        $resources = [];

        foreach ($items as $resource) {
            $instance = new static($resource);
            $resources[] = $instance;
        }

        return collect($resources);
    }

    public function save()
    {
        $options = [
            'DATA' => [static::RESOURCE_NAME => (array) $this->_attributes]
        ];

        if ($this->_id) {
            $options['METHOD'] = 'PUT';
            $options['URL'] = $this->_getItemUrl();
        } else {
            $options['METHOD'] = 'POST';
            $options['URL'] = $this->_getCreateUrl();
        }

        $result = self::call($options);
        $this->init($result->{static::RESOURCE_NAME});
        return $this;
    }

    public function delete()
    {
        return self::call([
          'METHOD' => 'DELETE',
          'URL' => $this->_getItemUrl();
        ]);
    }

    public function toArray()
    {
        return (array) $this->_attributes;
    }

    protected function _getCreateUrl()
    {
        return static::RESOURCE_NAME_MULT . '.json';
    }

    protected function _getItemUrl()
    {
        return static::RESOURCE_NAME_MULT . '/' . $this->_id . '.json';
    }

    public static function call($options)
    {
        $options['ALLDATA'] = true;
        $requestsCount = Redis::get('shopify:req:count');
        if ($requestsCount >= 39) {
            sleep(2);
        }
        $result = Sh::call($options);
        $tmpSplit = explode('/', $result->_INFO['HTTP_X_SHOPIFY_SHOP_API_CALL_LIMIT']);
        $counter = $tmpSplit[0];
        Redis::set('shopify:req:count', $counter);
        return $result;
    }

}
