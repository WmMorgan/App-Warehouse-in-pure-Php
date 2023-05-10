<?php
$this->title = "Регистрации"
?>

<div class="container">
    <div class="login-content">
        <div class="login-logo">
            <a href="index.html">
                <img class="align-content" src="/assets/images/logo.png" alt="">
            </a>
        </div>
        <div class="login-form">
            <form action="" method="post">
                <?= showErrorMessage($this->err) ?>
                <div class="form-group">
                    <label>Адрес электронной почты</label>
                    <input name="email" type="email" class="form-control" placeholder="Email" value="<?= $this->old('email') ?>">
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input name="pass" type="password" class="form-control" placeholder="Password" value="<?= $this->old('pass') ?>">
                </div>
                <div class="form-group">
                    <label>Подтвердите пароль</label>
                    <input name="pass2" type="password" class="form-control" placeholder="Password" value="<?= $this->old('pass2') ?>">
                </div>

                <button name="submit" type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Регистрации</button>

                <div class="register-link m-t-15 text-center">
                    <p>Уже есть аккаунт? <a href="/login"> Войти</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

