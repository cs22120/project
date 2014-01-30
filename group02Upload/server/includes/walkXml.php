<?php
// code borrowed from Google https://developers.google.com/maps/articles/phpsqlajax_v3

if ( !defined( 'ENTRYPOINT' ) ) {
  die( 'Not a valid entry point.' );
}

function parseToXML( $htmlStr )
{
$xmlStr = str_replace( '<', '&lt;', $htmlStr );
$xmlStr = str_replace( '>', '&gt;', $xmlStr );
$xmlStr = str_replace( '"', '&quot;', $xmlStr );
$xmlStr = str_replace( "'", '&#39;', $xmlStr );
$xmlStr = str_replace( "&", '&amp;', $xmlStr );
return $xmlStr;
}

require_once 'includes/database.php';
$con = openConnection();

$query = "SELECT * FROM tbl_places";
$result = mysqli_query( $con, $query );
if ( !$result ) {
  die( 'Invalid query: ' . mysql_error() );
}

$i = 0;
while ( $row = mysqli_fetch_assoc( $result ) ) {
  $name[$i] = $row['name'];
  $description[$i] = $row['description'];
  $id[$i] = $row['id'];
  $i = $i + 1;
}

$query = "SELECT * FROM tbl_images";
$result = mysqli_query( $con, $query );
if ( !$result ) {
  die( 'Invalid query: ' . mysql_error() );
}

$i = 0;
while ( $row = mysqli_fetch_assoc( $result ) ) {
  $image[$i] = $row['photoName'];
  $i = $i + 1;
}


// Select all the rows in the markers table
$query = "SELECT * FROM tbl_locations";
  $result = mysqli_query( $con, $query );
if ( !$result ) {
  die( 'Invalid query: ' . mysql_error() );
}

header( "Content-type: text/xml" );
$xml = "";
// Start XML file, $xml .= parent node
$xml .= '<markers>';

// Iterate through the rows, printing XML nodes for each
$i = 0;
$j = 1;
while ( $row = mysqli_fetch_assoc( $result ) ) {
  // ADD TO XML DOCUMENT NODE
  if ( ( isset( $_GET['walk'] ) ) && ( $row['walkId'] == $_GET['walk'] ) ) {
  $xml .= '<marker ';
  $xml .= 'id="' . $row['id'] . '" ';
  $xml .= 'walkId="' . $row['walkId'] . '" ';
  $xml .= 'latitude="' . $row['latitude'] . '" ';
  $xml .= 'longitude="' . $row['longitude'] . '" ';
  $xml .= 'timestamp="'. $row['timestamp'] . '" ';
  if ( $id[$i] == $row['id'] ) {
  $xml .= 'name="' . $name[$i] . '" ';
  $xml .= 'description="' . $description[$i] . '" ';
  $xml .= 'image="' . $image[$i] . '" ';
  }
  $xml .= 'poiNo="' . $j . '" ';
  $j = $j + 1;
  $xml .= '/>';
  }
  $i = $i + 1;
}

// End XML file
$xml .= '</markers>';

echo $xml;

?>
