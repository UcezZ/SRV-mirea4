<div class="card-wrapper">
    <div class="card">
        <div class="card-header"><?= Locale::getValue('file.upload.title') ?></div>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="max_file_size" value="2147483647">
            <table class="card-contents">
                <tr>
                    <td><?= Locale::getValue('file.file') ?></td>
                    <td><input id="file" name="file" type="file" accept="application/pdf" value="" required /></td>
                </tr>
                <tr>
                    <td><?= Locale::getValue('common.name') ?></td>
                    <td><input id="name" name="name" required minlength="2" maxlength="255" value="<?= $_POST['name'] ?? '' ?>" /></td>
                </tr>
            </table>
            <div class="submit-wrapper">
                <button type="submit"><?= Locale::getValue('file.upload') ?></button>
            </div>
        </form>
    </div>
</div>
<script>
    let
        f = document.getElementById('file'),
        n = document.getElementById('name');

    f.addEventListener('change', () => {
        if (n.value.length == 0) {
            n.value = f.value.replace(/^.*[\\\/]/, '');
            n.value = n.value.substr(0, n.value.length - n.value.split('.').pop().length - 1);
        }
    });
</script>