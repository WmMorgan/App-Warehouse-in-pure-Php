<?php
namespace func;

trait Component
{
    public function isAuth():bool
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : false;
    }

    public function session() {

        return new Session();
    }
}