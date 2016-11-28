<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php verify_login(); ?>

<?php
	$current_admin = find_admin_by_id($_GET["admin_id"]);
	if (!$current_admin) {
		// admin ID was missing, invalid or couldn't be found in database
		redirect_to("manage_admins.php");
	}
	
	$admins_set = find_all_admins();
	if (mysqli_num_rows($admins_set) <= 1) {
		// There is only one admin in admins set
		$_SESSION["message"] = "Can't delete last admin.";
		redirect_to("edit_admin.php?admin_id={$current_admin["id"]}");
	}
	
	$id = $current_admin["id"];
	$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		// Success
		$_SESSION["message"] = "Admin deleted.";
		redirect_to("manage_admins.php");
	} else {
		// Failure
		$_SESSION["message"] = "Admin deletion failed.";
		redirect_to("edit_admin.php?admin_id={$current_admin["id"]}");
	}
	
?>
