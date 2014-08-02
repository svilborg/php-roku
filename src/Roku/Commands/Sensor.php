<?php
namespace Roku\Commands;

/**
 * Sensor
 * There are four sensor values to report, accelerometer, orientation, gyroscope (rotation), and magnetometer (magnetic).
 */
class Sensor extends \Roku\Utils\AbstractEnum {

    const ACCELERATION = "acceleration";

    const MAGNETIC = "magnetic";

    const ORIENTATION = "orientation";

    const ROTATION = "rotation";
}