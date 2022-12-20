<div class="menu-wrapper">
    <div class="menu">
        <a href="./" class="<?= str_ends_with($_SERVER['REQUEST_URI'], 'index.php') ? "selected" : "" ?>"><?= Locale::getValue('menu.main') ?></a>
        <a href="./profile.php" class="<?= str_ends_with($_SERVER['REQUEST_URI'], 'profile.php') ? "selected" : "" ?>"><?= Locale::getValue('menu.profile') ?></a>
        <a href="./files.php" class="<?= str_ends_with($_SERVER['REQUEST_URI'], 'files.php') ? "selected" : "" ?>"><?= Locale::getValue('menu.files') ?></a>
        <?php
        if ($user->getID() == 1) {
            print('<a href="./gd.php" class="' . (str_ends_with($_SERVER['REQUEST_URI'], 'gd.php') ? "selected" : "") . '">' . Locale::getValue('menu.gd') . '</a>');
            print('<a href="./admin.php" class="' . (str_ends_with($_SERVER['REQUEST_URI'], 'admin.php') ? "selected" : "") . '">' . Locale::getValue('menu.admin') . '</a>');
        }
        ?>
    </div>
</div>