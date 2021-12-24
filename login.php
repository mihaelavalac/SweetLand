<?php
include('global/mysql.php');
include("./classes/user.class.php");
include("global/form_validation_functions.php");

$email = "";
$password = "";
$email_Err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = clean_input($_POST["email"]);
  $password = clean_input($_POST["password"]);
}

$user = new User();

if (!empty($email)) {

  $email_Err =  $user->verifyUser($conn, $email, $password);
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("head.php"); ?>
</head>

<body>
  <?php include("components/nav_bar.php"); ?>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-2 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
                <?php echo '<small class="text-primary">' . $email_Err . '</small><br>' ?>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                <label class="form-check-label" for="rememberPasswordCheck">
                  Remember password
                </label>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-white fw-bold" type="submit">Sign
                  in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("components/footer.php") ?>
</body>

</html>