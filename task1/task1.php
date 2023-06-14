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

function clientCode()
{
    $s1 = MySingleton::getInstance();
    $s2 = MySingleton::getInstance();
    if ($s1 === $s2) {
        echo "Singleton works, both variables contain the same instance.";
    } else {
        echo "Singleton failed, variables contain different instances.";
    }
}
 echo clientCode()
?>