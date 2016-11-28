<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php verify_login(); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_page(); ?>

<?php
	if (!$current_page) {
		// subject ID was missing, invalid or couldn't be found in database
		redirect_to("manage_content.php");
	}
?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	// validations
	$required_fields = array("subject_id");
	validate_presences($required_fields);
	
	if (empty($errors)) {
		// Perform Update

		$id = $current_page["id"];
		$subject_id = (int) $_POST["subject_id"];
		$position = (int) mysqli_num_rows(find_pages_for_subject($subject_id))+1;
	
		$query  = "UPDATE pages SET ";
		$query .= "position = {$position}, ";
		$query .= "subject_id = {$subject_id} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["message"] = "Page updated.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$message = "Page update failed.";
		}
	
	}
} else {
	// This is probably a GET request
	// Do nothing
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
		<?php echo navigation($current_subject, $current_page); ?>
  </div>
  <div id="page">
		<?php // $message is just a variable, doesn't use the SESSION
			if (!empty($message)) {
				echo "<div class=\"message\">" . htmlentities($message) . "</div>";
			}
		?>
		<?php echo form_errors($errors); ?>
		
		<h2>Change page's subject: <?php echo htmlentities($current_page["menu_name"]); ?></h2>
		<form action="change_subject.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
		  <p>Subject:
		    <select name="subject_id">
				<?php
					$subject_set = find_all_subjects();
					$subject_count = mysqli_num_rows($subject_set);
					while($subject = mysqli_fetch_assoc($subject_set)) {
						echo "<option value=\"{$subject["id"]}\"";
						if ($current_page["subject_id"] == $subject["id"]) {
							echo " selected";
						}
						echo ">{$subject["menu_name"]}</option>";
					}
				?>
		    </select>
		  </p>
		  <input type="submit" name="submit" value="Edit Subject" />
		</form>
		<br />
		<a href="manage_content.php?page=<?php echo urlencode($current_page["id"]); ?>">Cancel</a>
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
