<div class="form-editor-wrapper">
    <form class="editor" method="POST" action="./user-edit.php">
        <input type="hidden" name="u" value="<?= $userprofile->getId() ?>" />

        <table class="editor">
            <tr>
                <td colspan="2"><?= Locale::getValue('user.edit') ?></td>
            </tr>
            <tr>
                <td><?= Locale::getValue('user.locale') ?></td>
                <td>
                    <select name="locale">
                        <?php
                        foreach (Locale::getSupportedLocales() as $localeKey => $localeName) {
                            print '<option value="' . $localeKey . '"' . ($userprofile->getLocale() == $localeKey ? ' selected' : '') . '>' . $localeName . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?= Locale::getValue('user.theme') ?></td>
                <td>
                    <select name="theme">
                        <?php
                        foreach (Theme::getSupportedThemes() as $themeKey => $themeName) {
                            print '<option value="' . $themeKey . '"' . ($userprofile->getTheme() == $themeKey ? ' selected' : '') . '>' . $themeName . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">
            <img src="./media/icons/edit.svg">
        </button>
    </form>
</div>