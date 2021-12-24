<?php

include("global/mysql.php"); 
include("global/form_validation_functions.php"); 
include("./classes/user.class.php");
$f_name = $l_name = $email = $password = $address_1 = $address_2 = $city = $state = "";
//Variables for numeric input.
$phone = $zip_code = $card_num = $exp_month = $exp_year = $card_cvv ='';
//Variables for error output. 
$f_name_error = $l_name_error = $email_error = $password_error = $address_1_error = $address_2_error = $city_error = $phone_error = $zip_code_error = $card_num_error = $exp_month_error = $exp_year_err = $card_cvv_error = "";
$new_user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_name = validate_name($_POST["fName"])["value"];
    $f_name_error = validate_name($_POST["fName"])["error"];
    
    $l_name = validate_name($_POST["lName"])["value"];
    $l_name_error = validate_name($_POST["lName"])["error"];

    $email = validate_email($_POST["email"])["value"];
    $email_error = validate_email($_POST["email"])["error"];


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
    $email_error =  $new_user->checkUserEmailIsUnique($conn, $email);

    if (empty($f_name_error) && empty($l_name_error) && empty($email_error) && empty($password_error) && empty($address_1_error) &&   empty($city_error) && empty($phone_error) && empty($zip_code_error) && empty($card_num_error) && empty($exp_month_error) && empty($exp_year_err) && empty($card_cvv_error)) {
        $new_user -> add_user($conn, $f_name, $l_name, $email, $phone, $password, $address_1, $address_2, $city, $state, $zip_code,  $card_num, $exp_month, $exp_year, $card_cvv);
    }
    
}



?>


<!DOCTYPE html>
<html lang="en">

<head><?php include("head.php"); ?></head>

<body>
    <?php include 'components/nav_bar.php' ?>
    <main class="container card border-2 shadow rounded-3 my-5 ">
        <h1 class='text-center mt-2'>Sign Up</h1>
        <form method='POST' class="my-4 mx-5" action='<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
            <h2 class="h2">User information</h2>
            <div class="row ">
                <div class="form-group col-md-6">
                    <label for="fName">First Name</label>
                    <input type="text" class="form-control" id="fName" name="fName" placeholder="First Name" required>
                    <?php echo '<small class="text-primary">' . $f_name_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="lName">Last Name</label>
                    <input type="text" class="form-control" id="lName" name="lName" placeholder="Last Name" required>
                    <?php echo '<small class="text-primary">' . $l_name_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    <?php echo '<small class="text-primary">' . $email_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="0000000000">
                    <?php echo '<small class="text-primary">' . $phone_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="psw" placeholder="Password" required>
                    <small class="form-text">Your password must be 8-20 characters long, contain letters and numbers.</small>
                    <br>
                    <?php echo '<span class="text-primary">' . $password_error . '</span><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="password_rep">Repeat</label>
                    <input type="password" class="form-control" id="password_rep" name="password_rep" placeholder="Repeat Password" required>
                    <!-- <small class="form-text">Error</small> -->
                </div>
            </div>
            <h2 class="h2">Address</h2>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="address1">Address 1</label>
                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" required>
                    <?php echo '<small class="text-primary">' . $address_1_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="address2">Address 2</label>
                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2">
                    <?php echo '<small class="text-primary">' . $address_2_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                    <?php echo '<small class="text-primary">' . $city_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-3">
                    <label for="state">State</label>
                    <select type="options" class="form-control" id="state" name="state" required>
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
                    <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code" required>
                    <?php echo '<small class="text-primary">' . $zip_code_error . '</small><br>' ?>
                </div>
            </div>
            <h3>Card Info</h3>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="card_nr">Card Nr.</label>
                    <input type="inputCard" class="form-control" id="card_nr" name="card_nr" placeholder="Card Number" required>
                    <?php echo '<small class="text-primary">' . $card_num_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-2 col-sm-4">
                    <label for="card_exp_month">Exp. Month</label>
                    <input type="inputCard" class="form-control" id="card_exp_month" name="card_exp_month" placeholder="mm" required>
                    <?php echo '<small class="text-primary">' . $exp_month_error . '</small><br>' ?>
                </div>
                <div class="form-group col-md-2 col-sm-4">
                    <label for="card_exp_year">Exp. Year</label>
                    <input type="inputCard" class="form-control" id="card_exp_year" name="card_exp_year" placeholder="yyyy" required>
                    <?php echo '<small class="text-primary">' . $exp_year_err . '</small><br>' ?>
                </div>
                <div class="form-group col-md-2 col-sm-4">
                    <label for="card_cvv">CVV</label>
                    <input type="inputCard" class="form-control" id="card_cvv" name="card_cvv" placeholder="CVV" required>
                    <?php echo '<small class="text-primary">' . $card_cvv_error . '</small><br>' ?>
                </div>


            </div><br>
            <button type="submit" class="btn btn-primary text-white">Submit</button></br></br>
        </form>
    </main>
    <?php include("components/footer.php") ?>
</body>

</html>