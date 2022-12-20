<div class="card">
    <div class="card-header"><?= Locale::getValue('profile.cardtitle') ?></div>
    <?php
    require __DIR__ . '/form-editor-user.php';
    ?>
    <table class="card-contents">
        <tr>
            <td><?= Locale::getValue('common.id') ?></td>
            <td><?= $userprofile->getId() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('auth.login') ?></td>
            <td><?= $userprofile->getLogin() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('user.locale') ?></td>
            <td><?= Locale::getSupportedLocales()[Locale::gatherLocale($userprofile->getLocale())] ?? $userprofile->getLocale() ?></td>
        </tr>
        <tr>
            <td><?= Locale::getValue('user.theme') ?></td>
            <td><?= Theme::getSupportedThemes()[Theme::gatherTheme($userprofile->getTheme())] ?></td>
        </tr>
        <tr>
            <td>
                <a href="./files.php"><?= Locale::getValue('profile.myfiles') ?></a>
            </td>
            <td><?= PDF::count($userprofile) ?></td>
        </tr>
    </table>
    <?php
    if ($userprofile->getId() == $user->getId()) {
        print('
    <div class="card-footer">
        <a href="./password.php">' . Locale::getValue('profile.changepassword') . '</a>
    </div>');
    }
    ?>
</div>