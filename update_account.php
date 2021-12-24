<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("head.php");
    include("global/form_validation_functions.php");
    include("global/mysql.php");
    include("./classes/user.class.php");
    ?>
</head>
<?php
$user = new User();
if (isset($_SESSION['email'])) {
    $user_info = $user->getUserInfo($conn, $_SESSION['email']);
    $user_id = $user_info[0]['id'];
    $f_name = $user_info[0]['first_name']; 
    $profile_image_data = $user_info[0]['image_data'];
    $profile_image_name = $user_info[0]['image_name'];
    $formErr = "";
    $targetFile = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['update_info'])) {

        $f_name = validate_name($_POST["fName"])["value"];
        $f_name_error = validate_name($_POST["fName"])["error"];

        $l_name = validate_name($_POST["lName"])["value"];
        $l_name_error = validate_name($_POST["lName"])["error"];

        $email = validate_email($_POST["email"])["value"];
        // $email_error = validate_email($_POST["email"])["error"];


        $phone = validate_phone($_POST["phone"])["value"];
        $phone_error = validate_phone($_POST["phone"])["error"];

        $password = validate_password($_POST["psw"], $_POST["password_rep"])["value"];
        $password_error = validate_password($_POST["psw"], $_POST["password_rep"])["error"];

        $address_1 = validate_address($_POST["address1"])["value"];
        $address_1_error = validate_address($_POST["address1"])["error"];
        $address_2 = clean_input($_POST["address2"]);

        $city = validate_name($_POST["city"])["value"];
        $city_error = validate_name($_POST["city"])["error"];

        $state = clean_input($_POST["state"]);

        $zip_code = validate_zip($_POST["zip_code"])["value"];
        $zip_code_error = validate_zip($_POST["zip_code"])["error"];

        $card_num  = validate_card_num($_POST["card_nr"])["value"];
        $card_num_error = validate_card_num($_POST["card_nr"])["error"];

        $exp_month = validate_exp_month($_POST["card_exp_month"])["value"];
        $exp_month_error = validate_exp_month($_POST["card_exp_month"])["error"];

        $exp_year = validate_exp_year($_POST["card_exp_year"])["value"];
        $exp_year_error = validate_exp_year($_POST["card_exp_year"])["error"];

        $card_cvv = validate_card_cvv($_POST["card_cvv"])["value"];
        $card_cvv_error = validate_card_cvv($_POST["card_cvv"])["error"];
        // $email_error = checkUserEmailIsUnique($conn, $email);

        if (empty($f_name_error) && empty($l_name_error) && empty($email_error) && empty($password_error) && empty($address_1_error) &&   empty($city_error) && empty($phone_error) && empty($zip_code_error) && empty($card_num_error) && empty($exp_month_error) && empty($exp_year_err) && empty($card_cvv_error)) {

            $user->update_user($conn, $user_id, $f_name, $l_name, $email, $phone, $password, $address_1, $address_2, $city, $state, $zip_code,  $card_num, $exp_month, $exp_year, $card_cvv);
        }
    } else {

        $targetFile = $_FILES["fileToUpload"]["name"];

        $kbFileSize = $_FILES["fileToUpload"]["size"] / 1000;

        if ($kbFileSize > 500) {
            $formErr = "Your file is too large. Max file size is 500 kb. Yours was $kbFileSize kb";
        }

        if (!empty($targetFile) && empty($formErr)) {
            $imageName = htmlspecialchars($targetFile);
            $imageData = file_get_contents($_FILES['fileToUpload']['tmp_name']);
            $user->uploadFile($conn, $user_id, $imageName, $imageData);
        }
    }
}

?>

<body>
    <?php include 'components/nav_bar.php' ?>
    <main class="container card border-2 shadow rounded-3 my-5 ">
        <!-- <h1 class='text-center mt-2'>Update Account Information</h1> -->
        <?php
        if ($profile_image_data == NULL || $profile_image_data == '') {
            echo ('
  <div class=" p-2 bg-secondary text-center">
    <p class="text-dark h2">Update profile image:</p>
    <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post" enctype="multipart/form-data">
      <div class="row ">
        <div class="col-sm-12 col-md-8 col-lg-10">
        <label for="fileToUpload"></label>
          <input class="form-control form-control-lg" id="user_img" type="file" name="fileToUpload" accept="image/png, image/gif, image/jpeg, image/jpg">
        </div>

        <div class="col-sm-12 col-md-4 col-lg-2">
          <input class=" btn-lg" type="submit" value="Upload Image" name="upload_image"><br>
        </div>
        
        <span class="h3 text-dark">*' . $formErr . '</span>
      </div>
    </form>
  </div>');
        } else {
            echo (" <div class='text-center'>
  <img class='rounded avatar-img' style='max-width: 200px !important; max-height:200px; display:contain;' src='data:image/png;base64," . base64_encode($profile_image_data) . "' alt='" . $profile_image_name . "'/></div>
<div class='text-center bg-secondary pt-2'>
<p class='text-dark h2'>Update profile image:</p>
  <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' enctype='multipart/form-data'>
      <div class='row p-2'>
        <div class='col-12 col-lg-7 text-lg-end text-lg-end text-sm-center'>
          <label for='fileToUpload'></label>
          <input class='form-control-file text-dark form-control-md' id='user_img' type='file' name='fileToUpload' accept='image/png, image/gif, image/jpeg, image/jpg'>
        </div>
        <div class='col-12 col-lg-5 text-lg-start text-sm-center'>
          <input class='btn-md' type='submit' value='Update Image' name='upload_image'>
        </div>
        <span class='h4 text-dark'>" . $formErr . "</span>
     
    </div></form></div>
  ");
        } ?>
    <h1 class='text-center mt-2'>Update Account Information</h1>
        <form method='POST' class="my-4 mx-5" action='<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
            <?php echo '<small class="text-primary">' . $form_error . '</small><br>' ?>
            <h2 class="h2">User Information</h2>
            <div class="row ">
                <div class="form-group col-md-6">
                    <label for="fName">First Name</label>
                    <input type="text" class="form-control" id="fName" name="fName" placeholder="First Name" value=<?php echo $user_info[0]['first_name'] ?> required>
                    <?php echo '<small class="text-primary">' . $f_name_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="lName">Last Name</label>
                    <input type="text" class="form-control" id="lName" name="lName" placeholder="Last Name" value=<?php echo $user_info[0]['last_name'] ?> required>
                    <?php echo '<small class="text-primary">' . $l_name_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value=<?php echo $email = $user_info[0]['email'] ?> required>
                    <?php echo '<small class="text-primary">' . $email_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone number " value=<?php echo $user_info[0]['phone'] ?>>
                    <?php echo '<small class="text-primary">' . $phone_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="psw" placeholder="********" value=<?php $user_info[0]['password'] ?> required>
                    <small class="form-text">Your password must be 8-20 characters long, contain letters and numbers.</small>
                    <br>
                    <?php echo '<span class="text-primary">' . $password_error . '</span><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="password_rep">Repeat</label>
                    <input type="password" class="form-control" id="password_rep" name="password_rep" placeholder="********" value=<?php $user_info[0]['password'] ?> required>
                </div>
            </div>
            <h2 class="h2">Address</h2>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="address1">Address 1</label>
                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" value='<?php echo $user_info[0]['address1']  ?> ' required>
                    <?php echo '<small class="text-primary">' . $address_1_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="address2">Address 2</label>
                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" value=<?php echo $user_info[0]['address2'] ?>>
                    <?php echo '<small class="text-primary">' . $address_2_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value=<?php echo $user_info[0]['city'] ?> required>
                    <?php echo '<small class="text-primary">' . $city_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-3">
                    <label for="state">State</label>
                    <select type="options" class="form-control" id="state" name="state" value=<?php $user_info[0]['state'] ?> required>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select><br>
                </div>
                <div class="form-group col-md-3">
                    <label for="zip_code">Zip Code</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code" value=<?php echo $user_info[0]['zip'] ?> required>
                    <?php echo '<small class="text-primary">' . $zip_code_error . '</small><br>' ?>
                </div>
            </div>
            <h3>Card Info</h3>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="card_nr">Card Nr.</label>
                    <input type="inputCard" class="form-control" id="card_nr" name="card_nr" placeholder="Card Number" value=<?php echo $user_info[0]['card_number'] ?> required>
                    <?php echo '<small class="text-primary">' . $card_num_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-2 col-sm-4">
                    <label for="card_exp_month">Exp. Month</label>
                    <input type="inputCard" class="form-control" id="card_exp_month" name="card_exp_month" placeholder="mm" value=<?php echo $user_info[0]['exp_month'] ?> required>
                    <?php echo '<small class="text-primary">' . $exp_month_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-2 col-sm-4">
                    <label for="card_exp_year">Exp. Year</label>
                    <input type="inputCard" class="form-control" id="card_exp_year" name="card_exp_year" placeholder="yyyy" value=<?php echo $user_info[0]['exp_year'] ?> required>
                    <?php echo '<small class="text-primary">' . $exp_year_err . '</small><br>' ?>
                </div>
                <div class="form-group col-md-2 col-sm-4">
                    <label for="card_cvv">CVV</label>
                    <input type="inputCard" class="form-control" id="card_cvv" name="card_cvv" placeholder="CVV" value=<?php echo $user_info[0]['card_cvv'] ?> required>
                    <?php echo '<small class="text-primary">' . $card_cvv_error . '</small><br>' ?>
                </div>


            </div><br>
            <button type="submit" name="update_info" class="btn btn-primary text-white">Update</button></br></br>
        </form>
    </main>
    <?php include("components/footer.php") ?>

</body>

</html>