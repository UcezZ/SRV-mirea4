<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/core/locale.php';
include_once __DIR__ . '/private/core/theme.php';

if (TokenHandler::check()) {
    $user = User::getUser();
}

require __DIR__ . '/private/views/index.php';
