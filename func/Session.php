<?php
namespace func;

class Session
{
    const SUCCESS = 1;
    const ERROR = 2;

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        if (isset($_SESSION[$name]))
        return $_SESSION[$name];

        return null;
    }

    public function unset($name)
    {
        unset($_SESSION[$name]);
    }

    public function clear()
    {
        session_destroy();
    }

    /**
     * @param $typeFlash | const SUCCESS, ERROR
     * @param $value
     */
    public function setFlash($typeFlash, $value)
    {
        $_value = [$typeFlash => $value];
        $this->set('flash', $_value);
    }

    /**
     * @return false|string
     */
    public function getFlash()
    {
        $flash = $this->get('flash');
        $this->unset('flash');
        ob_start();
        if (isset($flash[self::SUCCESS])): ?>
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Успешно</span>
                <?= $flash[self::SUCCESS] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php elseif (isset($flash[self::ERROR])): ?>
            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Ошибка</span>
                <?= $flash[self::ERROR] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <?php endif;

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}