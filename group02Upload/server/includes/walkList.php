<?php
/**
 * This file generates the index of stored walks.
 *
 * @file
 */

if ( !defined( 'ENTRYPOINT' ) ) {
  die( 'Not a valid entry point.' );
}

require_once 'includes/database.php';
require( 'includes/templates.php' );

$result = executeSql( 'SELECT * from `tbl_routes`' );
if ( is_object( $result ) === FALSE ) {
  render( 'message', ['Database error', 'We were unable to get a list of walks.', $result ] );
  # something went wrong
}
$rows = "";
while ( $walk = $result->fetch_assoc() ) {
  # TODO: this is horrible, needs fixing
  $rows .= '<tr><td>';
  $rows .= '<a href="?walk=';
  $rows .= $walk['id'];
  $rows .= '">';
  $rows .= $walk['title'];
  $rows .= '</a></td><td>';
  $rows .= $walk['shortDesc'];
  $rows .= '</td><td>';
  $rows .= $walk['longDesc'];
  $rows .= '</td></tr>';
}
render( 'homepage', $rows );
