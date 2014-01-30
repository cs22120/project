<?php require_once( 'templates/header.php' ); ?>
<h1>Walking Tour Displayer</h1>
<p class="lead">You can upload your routes via the Walking Tour Creator, and they will appear here.</p>
<table class="table table-striped walks">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
			<th>Long Description</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $data; ?>
    </tbody>
</table>
<?php require_once( 'templates/footer.php' ); ?>
