<?php
/**
 * Image related functions.
 *
 * @file
 */

/**
 * Processes an image.
 *
 * @param The name of the image.
 * @param The base64 string to store.
 * @return FALSE if success, else an error code
 *  1 = file already exists, will not clobber
 *  2 = bad base64 encoding
 *  3 = file-put failed
 */
function processImage( $name, $string ) {
  if ( file_exists ( 'uploads/' . $name ) === TRUE ) {
    return 1;
  } else {
    $image = base64_decode( $string, TRUE );
    if ( !$image ) {
      return 2;
    } else if ( file_put_contents( 'uploads/' . $name, $image ) ) {
      return FALSE;
    } else {
      return 3;
    }
  }
}

