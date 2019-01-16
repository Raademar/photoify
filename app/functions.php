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

/**
 * Report success message to the client.
 * 
 * @param string $successMessage
 * 
 * @return void
 */
function reportSuccess(string $successMessage, string $path) {
    $_SESSION['success'] = $successMessage;
        redirect($path);
        exit;
}

/**
 * Compress images before we save them to the database
 * 
 * @param 
 * 
 * 
 * 
 * 
 * @param int $quality
 * 
 */
function compress($source, $compressedImage, $quality) {

	$info = getimagesize($source);

	if ($info['mime'] === 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] === 'image/gif') 
			$image = imagecreatefromgif($source);

	elseif ($info['mime'] === 'image/png') 
			$image = imagecreatefrompng($source);

	imagejpeg($image, $compressedImage, $quality);
}

if (!function_exists('saved_to_database')) {
  /**
   * Exit script, clear errors and redirect.
   * 
   * @param string $path
   * 
   * @return void
   */
  function saved_to_database(string $path) {
		$_SESSION['errors'] = '';
    redirect($path);
  }
}
