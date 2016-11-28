<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	$username = mysql_prep($_POST["username"]);
	$_SESSION["username"] = $_POST["username"];
	$password = mysql_prep($_POST["password"]);
	
	// validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	if (logged_in() || login($username,$password)) {
		// Already logged in, or upon successful login
		$_SESSION["message"] = "Logged in as: " . $_SESSION["logged_user"];
		redirect_to("admin.php");
	} else {
		$_SESSION["message"] = "Username and Password combination did not match!";
	}
	
	if (!empty($errors)) {
		// Errors found
		$_SESSION["errors"] = $errors;
		redirect_to("login.php");
	}
} 

?>


<div id="main">
  <div id="page">
		<?php echo message(); ?>
		<?php $errors = errors(); ?>
		<?php echo form_errors($errors); ?>
		
		<h2>Admin Login</h2>
		<form action="login.php" method="post">
		  <p>Username:
		    <input type="text" name="username" value="<?php echo (isset($_SESSION["username"]) ? $_SESSION["username"] : ""); ?>" />
		  </p>
		  <p>Password:
		    <input type="password" name="password" value="" />
		  </p>
		  <input type="submit" name="submit" value="Login" />
		</form>
		<br />
		<a href="index.php">&laquo; Back to Homepage</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
