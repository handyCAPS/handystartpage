<div id="dbFormWrap">
	<h1>DB Set Up</h1>
	<form action="scripts/create-config.php" method="POST">
		<fieldset>
			<div class="db_form_help">
				<p>
					Set up the database connection.
				</p>
			</div>
			<label for="databaseName">Database Name</label>
			<input type="text" name="databaseName" id="databaseName"><br>
			<label for="databasePassword">Database Password</label>
			<input type="text" name="databasePassword" id="databasePassword"><br>
			<label for="databaseUser">Database User</label>
			<input type="text" name="databaseUser" id="databaseUser"><br>
			<label for="databaseHost">Database Host</label>
			<input type="text" name="databaseHost" id="databaseHost"><br>
			<input type="submit" value="Save">
		</fieldset>
	</form>
</div><!--  end dbFormWrap  -->