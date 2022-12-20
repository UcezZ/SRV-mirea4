<div class="header">
    <?php
    if (isset($user)) {
        require __DIR__ . '/header-burger.htm';
    }
    ?>
    <div class="logo-caption centerer-wrapper">
        <span>
            <a href="./">PDF</a>
        </span>
    </div>
    <?php
    if (isset($user)) {
        require __DIR__ . '/header-menu-wrapper.php';
    }
    ?>
    <div class="auth-block">
        <?php
        if (isset($user)) {
            require __DIR__ . '/header-user-icon.php';
        }
        ?>
        <div class="auth-buttons">
            <?php
            if (isset($user)) {
                $url = './logout.php';
                $caption = Locale::getValue('header.logout');
                require __DIR__ . '/header-auth-button.php';
            } else {
                if (!str_ends_with($_SERVER['REQUEST_URI'], 'login.php')) {
                    $url = './login.php';
                    $caption = Locale::getValue('header.login');
                    require __DIR__ . '/header-auth-button.php';
                }
                if (!str_ends_with($_SERVER['REQUEST_URI'], 'register.php')) {
                    $url = './register.php';
                    $caption = Locale::getValue('header.register');
                    require __DIR__ . '/header-auth-button.php';
                }
            }
            ?>
        </div>
    </div>
</div>