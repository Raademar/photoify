<?php
declare(strict_types=1);
if (!function_exists('redirect')) {
  /**
   * Redirect the user to given path.
   * 
   * @param string $path
   * 
   * @return void
   */
  function redirect(string $path) {
    header("Location: ${path}");
    exit;
  }
}

function contains($needle, $haystack) {
    return strpos($haystack, $needle) !== false;
}

  /**
   * Report error to the client.
   * 
   * @param string $errorMessage
   * 
   * @return void
   */
  function reportError(string $errorMessage, string $path) {
    $_SESSION['errors'] = $errorMessage;
		redirect($path);
		exit;
  }
