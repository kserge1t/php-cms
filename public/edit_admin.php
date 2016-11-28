<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php verify_login(); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
// Set Admin by ID, redirect on failure
$current_admin = find_admin_by_id($_GET['admin_id']);
	if (!$current_admin) {
		redirect_to("manage_admins.php");
	}
	
if (isset($_POST['submit'])) {
	// Process the form

	// validations
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("username" => 10);
	validate_max_lengths($fields_with_max_lengths);
	
	if (empty($errors)) {
		
		// Perform Update
		$username = mysql_prep($_POST["username"]);
		$hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$id = $current_admin["id"];
	
		$query  = "UPDATE admins SET ";
		$query .= "username = '{$username}', ";
		$query .= "hashed_password = '{$hashed_password}' ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["message"] = "Page updated.";
			redirect_to("manage_admins.php");
		} else {
			// Failure
			$_SESSION["message"] = "Page updated failed.";
			redirect_to("edit_admins.php?admin_id=".$id);
		}
	
	} else {
		$_SESSION["errors"] = $errors;
	}
}
?>


<div id="main">
  <div id="page">
		<?php echo message(); ?>
		<?php $errors = errors(); ?>
		<?php echo form_errors($errors); ?>
		
		<h2>Edit Admin</h2>
		<form action="edit_admin.php?admin_id=<?php echo $current_admin["id"] ?>" method="post">
		  <p>Username:
		    <input type="text" name="username" value="<?php echo $current_admin["username"] ?>" />
		  </p>
		  <p>Password:
		    <input type="password" name="password" value="" />
		  </p>
		  <input type="submit" name="submit" value="Edit Admin" />
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
		&nbsp;&nbsp;
		<a href="delete_admin.php?admin_id=<?php echo urlencode($current_admin["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Admin</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
