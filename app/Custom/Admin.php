<?php


namespace App\Custom;


class Admin
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new  self();
        }

        return self::$instance;
    }

    private $admin;

    private function __construct()
    {
        $this->admin = auth()->userOrFail();
    }

    private function __clone()
    {
    }

    public function user()
    {
        return $this->admin;
    }
}
