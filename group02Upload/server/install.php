<?php
/**
 * This is the entry point for the installation wizard for the Walking Tour
 * Displayer.
 *
 * @file
 */

# valid entry point
define( 'ENTRYPOINT', true );

require ( 'includes/templates.php' );

/*
# check if config file has already been created
if ( file_exists( 'config.php' ) ) {
  # disallow access for security reasons
  header( 'HTTP/1.0 403 Forbidden' );
  die( render( 'message', ['Installation unavailable', 'config.php already exists!'] ) );
}
 */

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
  # user wants wizard
  # check if config is already there
  if ( file_exists( 'config.php' ) ) {
    render( 'installtables' );
  } else {
    render( 'installer' );
  }

} else if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
  header( 'HTTP/1.0 405 Method Not Allowed' );
  die( render( 'message', ['HTTP 405: Method Not Allowed', 'Please use POST or GET.'] ) );
} else {
  # installation is a go! (hopefully)

  if ( isset( $_POST['address'] ) ) {
    $config = "<?php\n" .
      "\$DB_ADDR = '" . $_POST['address'] . "';\n" .
      "\$DB_PASS = '" . $_POST['password'] . "';\n" .
      "\$DB_USER = '" . $_POST['username'] . "';\n" .
      "\$DB_NAME = '" . $_POST['dbname'] . "';\n?>";

    $file = fopen( 'config.php', 'w' );

    if ( $file === FALSE ) {
      # unable to open file
       die( render ( 'message', ['Automatic installation failed',
         'We were unable to open the configuration file for writing.</p>' .
         '<p>Please place the following into <code>config.php</code></p>' .
         '<pre>' . htmlentities( $config ) . '</pre>'] ) );
    }

    $write = fwrite( $file, $config );
    fclose( $file );

    if ( $write === FALSE ) {
      die( render ( 'message', ['Automatic installation failed',
        'We tried to write to the configuration file, but failed.</p>' .
        '<p>Please place the following into <code>config.php</code>:</p>' .
        '<pre>' . htmlentities( $config ) . '</pre>'] )
      );
    }
  } else {
    require_once( 'includes/database.php' );
    $creator = createDatabase();
    if ( is_object( $creator ) === FALSE ) {
      die( render ( 'message', [
        'Table creation failed',
        'We tried to create the MySQL tables for you, but something went wrong. Please try again',
        $creator
      ] ) );
    }
  }

  header( 'HTTP/1.0 301 Moved Permanently' );
  header( 'Location: index.php' );

}
