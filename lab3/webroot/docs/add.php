<div class="center-wrapper">
    <div class="add-wrapper">
        <form action="/lib/book-add.php" method="POST">
            <div class="center-wrapper">
                <button type="submit" title="Добавить книгу">
                    <img src="./media/add.svg">
                </button>
            </div>

            <div class="center-wrapper">
                <table>
                    <tr>
                        <td>Название: </td>
                        <td><input type="text" name="name" placeholder="Заполните это поле" required /></td>
                    </tr>
                    <tr>
                        <td>Автор: </td>
                        <td><input type="text" name="author" placeholder="Заполните это поле" required /></td>
                    </tr>
                    <tr>
                        <td>Обложка: </td>
                        <td><input type="text" name="url" placeholder="Введите ссылку" /></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>