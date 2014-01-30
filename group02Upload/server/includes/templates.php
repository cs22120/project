<?php
/**
 * This file contains helper functions to generate pages from templates.
 *
 * @file
 */

# not a valid entry point
if ( !defined( 'ENTRYPOINT' ) ) {
  render( 'message' , ['Invalid entry point', 'Unable to render.'] );
  exit( 1 );
}

/**
 * Generates a HTML page with correct parameters.
 * @param the template to render
 * @param any data to parse to the template
 *
 * The data required differs from template to template; as a rule, muliple
 * pieces of data should be passed as an array.
 */
function render ( $templateName, $data = FALSE ) {
  require( "templates/$templateName.php" );
}
