<?php
require_once 'includes/templates.php';
$commit = shell_exec( 'git log -n1' );
render( 'credits', $commit );
