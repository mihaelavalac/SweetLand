<?php
// I need to add more validation for some inputs. Will work on them later.  
function clean_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function validate_name($input){
  $clean_val = clean_input($input);
  if (!preg_match("/^([a-zA-Z' ]+)$/", $input)) {
    return array("error" => 'Only letters and white space allowed', "value" => "");
  }
  return array("error" => "", "value" => $clean_val);
}

function validate_email($input){
  $clean_val = clean_input($input);
  if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
    return array("error" => 'Invalid email format', "value" => "");
  }
  return array("error" => "", "value" => $clean_val);
}

function validate_phone($input){
  $phone = clean_input($input);
  if (!preg_match("/^[0-9]{10}$/", $phone)) {
    return array("error" => "Invalid phone number.", "value" => "");
  }
  return array("error" => "", "value" => $phone);
}

function validate_password($f_password, $l_password){
  $f_password = clean_input($f_password);
  $l_password = clean_input($l_password);
  if ($f_password !== $l_password) {
    return array("error" => "Passwords should match!", "value" => null);
  }
  return array("error" => "", "value" => password_hash($f_password, PASSWORD_DEFAULT));
}

function validate_address($input){
  $address = clean_input($input);
  if (!preg_match("/^\\d+ [a-zA-Z ]+$/", $address)) {
    return array("error" => "Invalid address input.", "value" => "");
  }
  return array("error" => "", "value" => $address);
}

function validate_zip($input){
  $zip = clean_input($input);
  if (!preg_match("/^[0-9]{5}$/", $zip)) {
    return array("error" => "Invalid zip code value.", "value" => "");
  }
  return array("error" => "", "value" => $zip);
}


function validate_card_num($input){
  $input = clean_input($input);
  if (!preg_match("/^[0-9]{16}$/", $input)) {
    return array("error" => "Invalid card number entered.", "value" => "");
  }
  return array("error" => "", "value" => $input);
}

function validate_exp_month($input){
  $input = clean_input($input);
  if (!preg_match("/^[0-9]{2}$/", $input)) {
    return array("error" => "Invalid card expiration month entered.", "value" => "");
  }
  return array("error" => "", "value" => $input);
}

function validate_exp_year($input){
  $input = clean_input($input);
  if (!preg_match("/^[0-9]{4}$/", $input)) {
    return array("error" => "Invalid card expiration year entered.", "value" => "");
  }
  return array("error" => "", "value" => $input);
}

function validate_card_cvv($input){
  $input = clean_input($input);
  if (!preg_match("/^[0-9]{3}$/", $input)) {
    return array("error" => "Invalid card cvv code entered.", "value" => "");
  }
  return array("error" => "", "value" => $input);
}