<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/core/filestream.php';
include_once __DIR__ . '/private/controllers/pdf.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
} else {
    header('Location: ./');
    exit;
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['tmp_name']) {
        if (strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)) == 'pdf') {
            $pdf = PDF::prepare($_POST['name']);
            if (!file_exists(__DIR__ . '/private/files/')) {
                mkdir(__DIR__ . '/private/files/', 0777, true);
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $pdf->getPath())) {
                $pdf->register();
            } else {
                $errorMessage = Locale::getValue('error.upload.message0');
            }
        } else {
            $errorMessage = Locale::getValue('error.upload.message1');
        }
    } else {
        $errorMessage = Locale::getValue('error.upload.message2');
    }
}

require __DIR__ . '/private/views/pdf-add.php';
