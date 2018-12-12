<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

session_destroy();
redirect('/index.php');
