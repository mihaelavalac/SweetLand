<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('header.php'); ?>
  <title>Logout</title>
</head>

<body>
  <?php include('components/nav_bar.php'); ?>
  <?php include('functions.php'); ?>
  <?php
  session_start();
  session_unset();
  session_destroy();
  header("Location:index.php");
  ?>
  <?php include('components/footer.php');
  ?>
</body>

</html>