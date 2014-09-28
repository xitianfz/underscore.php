<?php
function __($item)
{
    return __::chain($item);
}

class __
{
    public static $singleton = null;
    private $item;

    public static function init()
    {
        self::$singleton = new __base;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::$singleton, $method], $args);
    }

    public function __call($method, $args)
    {
        array_unshift($args, $this->item);
        if (method_exists(self::$singleton, $method)) {
            $this->item = call_user_func_array([self::$singleton, $method], $args);
        } else {
            $this->item = call_user_func_array($method, $args);
        }
        return $this;
    }

    public static function chain($item)
    {
        $__ = new self;
        $__->item = $item;
        return $__;
    }

    public function done()
    {
        return $this->item;
    }
}

class __base
{
    // dict
    public function pick($item, $keys)
    {
        if (!is_array($keys)) $keys = [$keys];

        $ret = [];
        $item = (array)$item;
        foreach ($keys as $k) {
            if (isset($item[$k])) {
                $ret[$k] = $item[$k];
            }
        }

        return $ret;
    }
    public function unpick($item, $keys)
    {
        if (!is_array($keys)) $keys = [$keys];

        $item = (array)$item;
        foreach ($keys as $k) {
            if (isset($item[$k])) {
                unset($item[$k]);
            }
        }

        return $item;
    }
    public function pluck($item, $key)
    {
        $ret = [];
        foreach ($item as $e) {
            $e = (array)$e;
            if (isset($e[$key])) {
                $ret[] = $e[$key];
            }
        }
        return $ret;
    }

    // collection
    public function map($item, $callable)
    {
        return array_map($callable, $item);
    }

    // array
    public function implode($item, $delimiter)
    {
        return implode($delimiter, $item);
    }
    public function explode($item, $delimiter)
    {
        return explode($delimiter, $item);
    }

    // string
}

if (__::$singleton === null) {
    __::init();
}
