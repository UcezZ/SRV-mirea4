<?php
include_once __DIR__ . '/private/core/tokenhandler.php';
include_once __DIR__ . '/private/controllers/user.php';
include_once __DIR__ . '/private/core/locale.php';

User::logout();

header("Location: ./");
