<?php

class shortcodesUI {

    protected static $_instance;

    private function __clone(){
    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function add($key, $array) {
        $this->compile[$key] = $array;
    }

    public function getCompile() {
        return $this->compile;
    }

}

?>