<div class="center-wrapper">
    <div class="item-wrapper">
        <i>#
            <?= $book['ID'] ?>
        </i>
        <div class="center-wrapper">
            <table>
                <tr>
                    <td>Название: </td>
                    <td>
                        <?= $book['name'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Автор: </td>
                    <td>
                        <?= $book['author'] ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php
        if (isset($book['url']) && strlen($book['url']) > 0) {
            require __DIR__ . '/logo.php';
        }
        ?>

        <?php
        if (isset($_SESSION) && $_SESSION['login'] == 'admin') {
            require __DIR__ . '/edit.php';
        }
        ?>

    </div>
</div>