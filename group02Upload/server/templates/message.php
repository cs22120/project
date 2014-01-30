<?php
include 'header.php';
?>
  <h1><?php echo $data[0] ?></h1>
    <div class="panel-body">
<?php echo $data[1];
if ( isset( $data[2] ) ) {
  echo "<hr><samp>$data[2]</samp>";
}
?>
    </div>
</div>
<?php
    include 'footer.php';
?>
