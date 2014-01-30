<?php
/**
 * This is the main web entry point for the Walking Tour Displayer.
 *
 * If you are able to read this in a web browser, the server this is
 * running on is *not* set up correctly to work with PHP applications.
 * See php.net for installation instructions.
 *
 * --------
 * By using this software, you are advised that:
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
 * REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
 * INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
 * LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
 * OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
 * PERFORMANCE OF THIS SOFTWARE.
 *
 * @file
 */

# This is a valid entry point
define( 'ENTRYPOINT', true );

# store install directory in a variable for convenience
$WD = realpath( '.' );
if ( !$WD ) { # realpath returns FALSE on failure
    $WD = dirname( __DIR__ );
}

# try to get configuration
if ( file_exists ( "$WD/config.php" ) ) {
  require_once "$WD/config.php";
} else {
  # if file doesn't exist, assume we require installation
  header( 'Location: install.php' );
  die( 'Installation required!' );
}

if ( isset( $_GET["xml"] ) ) {
  require_once 'includes/walkXml.php';
} else if ( isset( $_GET["credits"] ) ) {
  require_once 'includes/credits.php';
} else if ( isset( $_GET["walk"] ) ) {
  # we have a walk ID, display a walk
  require_once 'includes/walkDetail.php';
} else {
  # no walk ID, list all the walks instead
  require_once 'includes/walkList.php';
}

?>
