<?php
declare(strict_types=1);

// Init session
session_start();

// Set default timezone
date_default_timezone_get('UTC');

// Set default character encoiding
mb_internal_encoding('UTF-8');

// Include helper functions
require __DIR__.'/functions.php';

// Get the global config array
$config = require __DIR__.'/config.php';

// Setup the database connection
$pdo = new PDO($config{'database_path'});