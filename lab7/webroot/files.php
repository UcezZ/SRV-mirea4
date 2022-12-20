<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/controllers/pdf.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';


if (TokenHandler::check()) {
    $user = User::getUser();
    $pdfCollection = PDF::getAllByUser();
} else {
    header('Location: ./');
    exit;
}

if (isset($_GET['f'])) {
    if ($pdf = PDF::getByAlias($_GET['f'])) {
        if (isset($_GET['q']) && $_GET['q'] == 'download') {
            $pdf->sendDownloadStream();
        } else {
            $pdf->sendStream();
        }
    } else {
        $errorMessage = Locale::getValue('error.file.message');
    }
}

require __DIR__ . '/private/views/files.php';
