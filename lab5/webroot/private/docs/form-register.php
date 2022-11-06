<div class="card-wrapper">
    <div class="card">
        <div class="card-header"><?= Locale::getValue('register.cardtitle') ?></div>
        <form method="POST" enctype="utf8">
            <table class="card-contents">
                <tr>
                    <td><?= Locale::getValue('auth.login') ?></td>
                    <td><input name="login" minlength="5" maxlength="64" value="<?= $_POST['login'] ?? '' ?>" /></td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('auth.password') ?></td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('auth.confirmpassword') ?></td>
                    <td><input type="password" name="passwordConfirm" /></td>
                </tr>
            </table>
            <div class="submit-wrapper">
                <button type="submit"><?= Locale::getValue('auth.register') ?></button>
            </div>
        </form>
    </div>
</div>