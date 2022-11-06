<tr>
    <td><?= $row['ID'] ?></td>
    <td><?= $row['login'] ?></td>
    <td><?= $row['expires'] ?></td>
    <td>
        <form class="card-contents" action="./admin.php" method="POST">
            <input type="hidden" name="tokenid" value="<?= $row['ID'] ?>">
            <input type="submit" value="<?= Locale::getValue('session.terminate') ?>">
        </form>
    </td>
</tr>