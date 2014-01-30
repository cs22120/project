<?php
/**
 * This file contains database related functions.
 *
 * @file
 */

# prevent users from accessing this page via their browser
if ( !defined( 'ENTRYPOINT' ) ) {
  die( 'This is not a valid entry point.' );
}

require dirname( __FILE__ ) . '/../config.php';
/**
 * This function runs the query that will attempt to create the correct tables
 * in the database.
 *
 * @return a string detailing errors encountered, or FALSE if the query worked.
 */
function createDatabase() {
  $db = openConnection();

  $sql = <<<'SQL'
  CREATE TABLE tbl_routes (
    id int NOT NULL AUTO_INCREMENT, title varchar(255), shortDesc varchar(255), longDesc varchar(255),
    hours float(12), distance float(12), PRIMARY KEY (id));
  CREATE TABLE tbl_locations (
     id int NOT NULL AUTO_INCREMENT, walkId int NOT NULL, latitude float(12), longitude float(12), timestamp float(12),
     PRIMARY KEY (id), FOREIGN KEY (walkId) REFERENCES tbl_routes(id));
   CREATE TABLE tbl_places (
     id int NOT NULL AUTO_INCREMENT, locationId int NOT NULL, name varchar(255), description varchar(255),
     PRIMARY KEY (id), FOREIGN KEY (locationId) REFERENCES tbl_locations(id));
  CREATE TABLE tbl_images (
    id int NOT NULL AUTO_INCREMENT, placeId int NOT NULL, photoName varchar(255),
    PRIMARY KEY (id), FOREIGN KEY (placeId) REFERENCES tbl_places(id));
SQL;

  $query = executeSql( $sql );
  if ( !is_string( $query ) ) {
    return FALSE;
  } else {
    return $query;
  }
}

/**
 * This function inputs a walk into the database.
 *
 * @param a walk object, as created by the upload.php function
 * @return a string describing the error, or SUCCESS if things worked
 */
function inputWalk( $walk ) {
  # TODO
  # we need to escape the inputs to proof against SQL injections
  # see rfc 4389 2.5.2
  $values = [
    "NULL", # ID is assigned by the database thanks to AUTO_INCREMENT
    "'$walk->title'",
    "'$walk->shortDesc'",
    "'$walk->longDesc'",
    "NULL",
    "NULL"
    ];

  $sql = 'INSERT INTO tbl_routes VALUES (' . implode( $values, ',' ) . ');';

  $db = openConnection();
  $query = mysqli_query( $db, $sql );
  if ( is_bool( $query ) && $query === TRUE ) {
    # the SQL query worked and the data is stored
    # we need to request the data back to see what the ID has been set to
    $walkId = mysqli_insert_id( $db );
    foreach ( $walk -> locations as &$location ) {
      $query = null;
      $values = null;
      $values = [
        "NULL", # location ID
        $walkId,
        "'" . mysqli_real_escape_string( $db, $location->latitude ) . "'",
        "'" . mysqli_real_escape_string( $db, $location->longitude ) . "'",
        "'" . mysqli_real_escape_string( $db, $location->timestamp ) . "'"
      ];
      $query = "INSERT INTO tbl_locations VALUES (" . implode( $values, ',' ) . ");";
      $sql =  mysqli_query( $db, $query );
      if ( $sql === FALSE ) { return $query; }
      # now need to get the locationId
      $locID = mysqli_insert_id( $db );

      foreach ( $location -> descriptions as &$description ) {
        $description[0] = mysqli_real_escape_string( $db, $description[0] );
        $description[1] = mysqli_real_escape_string( $db, $description[1] );
        # TODO: BUG: doesn't actually work...
        $sql = "INSERT INTO tbl_places VALUES (NULL, '$locID', '$description[0]', '$description[1]');";
        $query = mysqli_query( $db, $sql );
        if ( $query === FALSE ) { return mysqli_error( $db ); }
      }

      foreach ( $location -> images as &$image ) {
        $sql = "INSERT INTO tbl_images VALUES (NULL, $locID, '$image[0]');";
        $query = mysqli_query( $db, $sql );
        if ( $query  === FALSE ) {
          return mysqli_error( $db );
        }
      }
    }

    # everything worked
    return 'SUCCESS'; # TODO: make this less hackish
  } else {
    return $query;
  }

}

/**
 * This function opens a connection to the database.
 * @return an active database connection.
 *
 * Use closeConnection() to close it again.
 */
function openConnection() {
  global $DB_ADDR, $DB_USER, $DB_PASS, $DB_NAME;
  $db = mysqli_connect( $DB_ADDR, $DB_USER, $DB_PASS, $DB_NAME );
  if ( !$db ) {
    # connection failed
    die( 'Could not connect to MySQL' );
  }
  return $db;
}

/**
 * Executes an SQL statement.
 * @param the SQL to execute
 * @return the result of the action
 *
 * On success it will return a mysqli_result() object when the SQL statement is
 * a SELECT, SHOW, DESCRIBE or EXPLAIN. Other successes will return TRUE.
 *
 * Failures will return a string explaining the error. Use is_object() to
 * discern between the error string and a result.
 */
function executeSql( $sql ) {
  $db = openConnection();
  $query = mysqli_query( $db, $sql );
  if ( $query === FALSE ) {
    $query = mysqli_error( $db );
  }
  closeDatabase( $db );
  return $query;
}

/**
 * Closes an active database connection.
 * @param the database connection to close.
 */
function closeDatabase( $db ) {
  mysqli_close( $db );
}
