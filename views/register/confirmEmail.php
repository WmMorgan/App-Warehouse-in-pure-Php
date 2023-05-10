<?php

if (empty($_GET['key'])):

?>
<div class="container">
    <div class="login-content mt-5">
        <div class="alert alert-success" role="alert">
            Вы успешно зарегистрировались!
            <br>
            Ссылка для подтверждения отправлена на вашу электронную почту
            <br>
            <hr>
            Пожалуйста активируйте свой аккаунт!
        </div>
    </div>
</div>

<?php else: ?>

<div class="container">
    <div class="login-content mt-5">
        <div class="alert alert-danger" role="alert">
            <?= implode('\n', $this->err) ?>
        </div>
    </div>
</div>

<?php
    endif;