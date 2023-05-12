<?php
namespace func\actions;

use func\Core;

class Index extends Core {

    public function __invoke()
    {
        if (!$this->isAuth())
            $this->redirect('login');

        $this->render('index');
    }
}