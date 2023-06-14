<?php
class MySingleton {
    private static $instance;

    private function __construct() {}

    protected function __clone() { }

}
?>