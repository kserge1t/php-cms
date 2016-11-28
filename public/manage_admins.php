<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php verify_login(); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>

<div id="main">
  <div id="navigation">
	<br>
	<a href="admin.php">&laquo; Main Menu</a>
	<br><br>
	<a href="new_admin.php">+ Add admin</a>
	<br><br>
	<li><a href="logout.php">Logout</a>
  </div>
  <div id="page">
		<?php echo message(); ?>
	    <h2>Manage Admins</h2>
		
		<?php
			// Build HTML to list admins
			$output = "<ul class=\"admins\">";
			$admin_set = find_all_admins();
			while($admin = mysqli_fetch_assoc($admin_set)) {
				$output .= "<br><li>";
				$output .= "<a href=edit_admin.php?admin_id=";
				$output .= urlencode($admin["id"]);
				$output .= ">";
				$output .= htmlentities($admin["username"]);
				$output .= "</a></li>";		
			}
			mysqli_free_result($admin_set);
			$output .= "</ul>";
			echo $output;
		?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
