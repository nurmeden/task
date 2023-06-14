<?php
class MySingleton {
    private static $instance;

    private function __construct() {}

    protected function __clone() {}

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function hello() {
        echo "Hello\n";
    }
}

$singleton = MySingleton::getInstance();
$singleton->hello();

?>