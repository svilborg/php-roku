<?php
namespace Roku\Utils;

abstract class AbstractEnum {

    private static $constCache = null;

    private static function getConstants() {
        if (self::$constCache === null) {
            $reflect = new \ReflectionClass(get_called_class());
            self::$constCache = $reflect->getConstants();
        }

        return self::$constCache;
    }

    public static function hasName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function hasValue($value) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict = true);
    }
}