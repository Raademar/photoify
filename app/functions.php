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

/**
 * Recursively removes a folder along with all its files and directories
 * 
 * @param String $path 
 */
function rrmdir($path) {
  // Open the source directory to read in files
     $i = new DirectoryIterator($path);
     foreach($i as $f) {
         if($f->isFile()) {
             unlink($f->getRealPath());
         } else if(!$f->isDot() && $f->isDir()) {
             rrmdir($f->getRealPath());
         }
     }
     rmdir($path);
}
