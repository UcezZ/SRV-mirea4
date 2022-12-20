<div class="form-editor-wrapper">
    <form class="editor" method="POST" action="./pdf-edit.php">
        <input type="hidden" name="f" value="<?= $pdf->getAlias() ?>" />

        <table class="editor">
            <tr>
                <td colspan="2"><?= Locale::getValue('file.edit') ?></td>
            </tr>
            <tr>
                <td><?= Locale::getValue('common.name') ?></td>
                <td>
                    <input type="text" name="name" value="<?= $pdf->getName() ?>" required>
                </td>
            </tr>
        </table>
        <button type="submit">
            <img src="./media/icons/edit.svg">
        </button>
    </form>
</div>