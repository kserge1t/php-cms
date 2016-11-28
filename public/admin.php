<?php require_once("../includes/functions.php"); ?>
<?php verify_login(); ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="page">
    <h2>Admin Menu</h2>
	<?php echo message(); ?>
    <p><?php echo $_SESSION["logged_user"]; ?>, welcome to the admin area!</p>
    <ul>
      <li><a href="manage_content.php">Manage Content</a></li>
	  <br>
      <li><a href="manage_admins.php">Manage Admins</a></li>
	  <br>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
