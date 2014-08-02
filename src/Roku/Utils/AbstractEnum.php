<?php
namespace Roku\Utils;

/**
 * Abstract Enum Class
 *
 */
abstract class AbstractEnum {

    /**
     * Constants cache
     * @var array
     */
    private static $constCache = null;

    /**
     * Get All constants
     *
     * @return array
     */
    private static function getConstants() {

        $class = get_called_class();

        if (!isset(self::$constCache[$class])) {
            $reflect = new \ReflectionClass(get_called_class());
            self::$constCache[$class] = $reflect->getConstants();
        }

        return self::$constCache[$class];
    }

    /**
     * Check if constant name exists
     *
     * @param string $name
     * @param string $strict
     * @return boolean
     */
    public static function hasName($name, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Check if constant value exists
     *
     * @param string $name
     * @param string $strict
     * @return boolean
     */
    public static function hasValue($value) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict = true);
    }
}