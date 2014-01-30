<?php require_once( 'templates/header.php' ); ?>
<h1>Credits</h1>
<h2>Contributors</h2>
<h3>Walking Tour Project</h3>
The following people contributed to the <em>Walking Tour Project</em>:
<ul>
    <li>Dillon Cuffe</li>
    <li>Christopher Edwards</li>
    <li>Douglas Gardner</li>
    <li>Luke Horwood</li>
    <li>Jostein Kristiansen</li>
    <li>Ben Rainbow</li>
    <li>Ashley Smith</li>
    <li>James Woodside</li>
</ul>
<h3>Bootstrap</h3>
<p><a href="http://getbootstrap.com">Bootstrap</a> is &copy; 2011&#x2012;2014
<a href="http://twitter.com">Twitter, Inc.</a>. Bootstrap is used under the terms of the
<a href="http://opensource.org/licenses/MIT">MIT License</a>.
<h3>Google Maps API</h3>
<p>Google Maps API is &copy; <a href="http://google.com">Google</a>, 2014.</p>

<?php if ( isset( $data ) ) { ?>
<h2>Version information</h2>
The last commit reason is replicated below:
<pre><?php echo $data ?></pre>
<?php } require_once( 'templates/footer.php' ); ?>
