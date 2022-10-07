<?php
require "lib.php";
safe_session_start();
unset($_SESSION['login']);
header('Location: ../');
