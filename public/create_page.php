<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php verify_login(); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	$menu_name = mysql_prep($_POST["page_name"]);
	$subject_id = mysql_prep($_POST["subject_id"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
	$content = mysql_prep($_POST["content"]);
	
	// validations
	$required_fields = array("page_name", "subject_id", "position", "visible", "content");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("page_name" => 30, "content" => 2000);
	validate_max_lengths($fields_with_max_lengths);
	
	if (!empty($errors)) {
		// Form errors present
		$_SESSION["errors"] = $errors;
		redirect_to("new_page.php");
	}
	
	$query  = "INSERT INTO pages (";
	$query .= "  menu_name, subject_id, position, visible, content";
	$query .= ") VALUES (";
	$query .= "  '{$menu_name}', {$subject_id}, {$position}, {$visible}, '{$content}'";
	$query .= ")";
	$result = mysqli_query($connection, $query);

	if ($result) {
		// Success
		$_SESSION["message"] = "Page created.";
		redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "Page creation failed.";
		redirect_to("new_page.php");
	}
	
} else {
	// This is probably a GET request
	redirect_to("new_subject.php");
}

?>


<?php
	if (isset($connection)) { mysqli_close($connection); }
?>
