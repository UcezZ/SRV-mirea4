<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/controllers/pdf.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
} else {
    header('Location: ./');
    exit;
}

if (isset($_POST['f'])) {
    $pdf = PDF::getByAlias($_POST['f']);
    if ($pdf) {
        switch ($pdf->delete()) {
            case 0:
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './files.php');
                exit;
            case 1:
                $errorMessage = Locale::getValue('error.sql.message')/*'Ошибка обработки запроса<br>'*/ . htmlspecialchars(print_r(SQL::getErrors(), true));
                break;
            case 2:
                $errorMessage = Locale::getValue('error.filedelete.message'); //'У вас нет права удалять этот файл!';
                break;
        }
    } else {
        $errorMessage = Locale::getValue('error.file.message'); //'Запрошенный файл не найден или у вас нет к нему доступа!';
    }
}

require __DIR__ . '/private/views/pdf-remove.php';
