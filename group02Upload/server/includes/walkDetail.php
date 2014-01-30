<?php
/**
 * This file generates the detailed per-walk page.
 *
 * @file
 */

# not a valid entry point
if ( !defined( 'ENTRYPOINT' ) ) {
  die( 'Not a valid entry point.' );
}
require_once 'includes/database.php';
require_once 'includes/templates.php';
$id = $_GET['walk'];

if ( !is_numeric( $id ) ) {
  header( 'HTTP/1.1 400 Bad Request' );
  render( 'message', ['Error 400: Bad walk ID', 'The walk ID you requested is invalid.'] );
  die();
}

$sql = <<<SQL
  SELECT * FROM tbl_locations
  INNER JOIN tbl_routes
  ON tbl_routes.id = tbl_locations.walkId
  INNER JOIN tbl_places
  ON tbl_locations.id = tbl_places.locationId
  WHERE tbl_routes.id = $id
  ORDER BY timestamp ASC
SQL;

$query = executeSql( $sql );
if ( is_object( $query ) === FALSE ) {
  render( 'message', ['Database error', 'We were unable to get the details of your walk.', $query] );
  die();
}
if ( $query->num_rows == 0 ) {
  header( 'HTTP/1.1 404 File Not Found' );
  render( 'message', ['Error 404: Walk not found', 'Please check the walk ID and try again.', ( var_export( $query, true ) )] );
  die();
}

while ( $walk = $query->fetch_assoc() ) {
  if ( !isset( $body ) ) {
    $body = "";
    $body .= '<h1>' . $walk['title'] . '</h1>';
    $body .= '<p class="lead">' . $walk['longDesc'] . '</p>';
    $body .= '<div id="map"></div>';
    $body .= '<table class="table table-striped">';
    $body .= '<tr><th>&deg;N of the Equator</th><th>&deg;E of Greenwich</th>';
    $body .= '<th>Name</th>';
    $body .= '<th>Description</th></tr>';
  }
  $body .= '<tr>';
  $body .= '<td>' . $walk['latitude'] . '</td>';
  $body .= '<td>' . $walk['longitude'] . '</td>';
  $body .= '<td>' . $walk['name'] . '</td>';
  $body .= '<td>' . $walk['description'] . '</td>';
  $body .= '</tr>';
}
$body .= '</table>';

render( 'skeleton', $body );

?>
