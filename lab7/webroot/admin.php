<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/controllers/pdf.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
}
if (!isset($user) || $user->getId() != 1) {
    header('Location: ./');
    exit;
}

if (isset($_POST['tokenid'])) {
    SQL::runQuery(
        "UPDATE token SET expires = NOW() WHERE ID = ?",
        'i',
        $_POST['tokenid']
    );
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './admin.php');
    exit;
}

require __DIR__ . '/private/views/admin.php';
