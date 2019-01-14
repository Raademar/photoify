<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

unset($_COOKIE['active_visit']);
setcookie('active_visit', 'false');
session_destroy();
redirect('/login.php');
