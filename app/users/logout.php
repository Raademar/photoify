<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

session_destroy();
setcookie('active_visit', 'active', time() - 3600);
redirect('/login.php');
