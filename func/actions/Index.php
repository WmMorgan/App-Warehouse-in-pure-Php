<?php
namespace func\actions;

use func\Core;

class Index extends Core {

    public function __invoke()
    {
        $this->render('index');
    }
}