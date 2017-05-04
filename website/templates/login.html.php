<form method="POST">
	<label>E-Mail</label>
	<input type="text" name="email" value="<?php (isset($email)) ? $email: ""?>"/>
	<label>Passwort</label>
	<input type="password" name="password"/>
	<input type="submit" Value="Submit"/>
</form>