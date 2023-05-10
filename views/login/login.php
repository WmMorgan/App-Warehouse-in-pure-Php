<?php
$this->title = 'Войти';

?>
<div class="container">
    <div class="login-content">
        <div class="login-logo">
            <a href="/">
                <img class="align-content" src="/assets/images/logo.png" alt="">
            </a>
        </div>
        <?= $this->session()->getFlash() ?>
        <?= showErrorMessage($this->err) ?>
        <div class="login-form">
            <form action="" method="post">
                <div class="form-group">
                    <label>Email address</label>
                    <input name="email" type="email" class="form-control" placeholder="Email" value="<?= $this->old('email') ?>">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="pass" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember Me
                    </label>
                    <label class="pull-right">
                        <a href="#">Forgotten Password?</a>
                    </label>

                </div>
                <button name="submit" type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>

                <div class="register-link m-t-15 text-center">
                    <p>Don't have account ? <a href="#"> Sign Up Here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>