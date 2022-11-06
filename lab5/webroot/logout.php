<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/locale.php';

User::logout();

header("Location: ./");
