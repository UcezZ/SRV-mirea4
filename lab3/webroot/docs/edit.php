<div class="right-wrapper">
    <div class="edit-wrapper flex reverse">
        <form action="/lib/book-edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $book['ID'] ?>" />
            <div class="center-wrapper">
                <table>
                    <tr>
                        <td>Название: </td>
                        <td><input type="text" name="name" placeholder="Новое название" /></td>
                    </tr>
                    <tr>
                        <td>Автор: </td>
                        <td><input type="text" name="author" placeholder="Новый автор" /></td>
                    </tr>
                    <tr>
                        <td>Обложка: </td>
                        <td><input type="text" name="url" placeholder="Введите ссылку" /></td>
                    </tr>
                </table>
                <button type="submit" title="Изменить книгу" value="">
                    <img src="/media/edit.svg"> </button>

            </div>

        </form>
    </div>
    <form action="/lib/book-delete.php" method="POST">
        <input type="hidden" name="id" value="<?= $book['ID'] ?>" />
        <button type="submit" class="trash" title="Удалить книгу">
            <img src="/media/delete.svg">
        </button>
    </form>
</div>