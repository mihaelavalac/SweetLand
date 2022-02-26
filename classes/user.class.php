<?php 


class User {

  public function getUserInfo($conn, $email){
    $selectUser = "SELECT * FROM users WHERE email=:email";
    $stmt = $conn->prepare($selectUser);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $matchingUser =  $stmt->fetchAll();
    return $matchingUser;
  }



  public function verifyUser($conn, $email, $password){
    $selectUser = "SELECT email, `password` FROM users WHERE email=:email";
    $stmt = $conn->prepare($selectUser);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $allMatchingUsers = $stmt->fetchAll();
    if (!empty($allMatchingUsers)) {
      foreach ($allMatchingUsers as $listRow) {
        $hashedPassword = $listRow['password'];
        if (password_verify($password, $hashedPassword)) {
          //session_start();
          $_SESSION['email'] = $email;
          header("Location: index.php");
        } else {
          return "Incorrect Password";
        }
      }
    } else {
      return "There is no email address: $email";
    }
  }
  
  public function checkUserEmailIsUnique($conn, $email){
    $selectUser = "SELECT email FROM users WHERE email=:email";
    $stmt = $conn->prepare($selectUser);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return empty($stmt->fetchAll()) ? "" : "Email is already taken";
  }
  
  public function add_user($conn, $f_name, $l_name, $email, $phone, $password, $address_1, $address_2, $city, $state, $zip_code,  $card_num, $exp_month, $exp_year, $card_cvv){
    $insert = "INSERT INTO users (first_name,last_name,email,phone,password,address1,address2,city,state,zip,card_number,exp_month,exp_year,card_cvv)
    VALUES (:f_name, :l_name, :email, :phone,:password,:address_1,:address_2,:city,:state,:zip_code,:card_num,:exp_month,:exp_year,:card_cvv)";
    $stmt = $conn -> prepare($insert);
    $stmt->bindParam(':f_name', $f_name);
    $stmt->bindParam(':l_name', $l_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':address_1', $address_1);
    $stmt->bindParam(':address_2', $address_2);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':zip_code', $zip_code);
    $stmt->bindParam(':card_num', $card_num);
    $stmt->bindParam(':exp_month', $exp_month);
    $stmt->bindParam(':exp_year', $exp_year);
    $stmt->bindParam(':card_cvv', $card_cvv);
    $stmt->execute();
    if(!empty($stmt)){
      //session_start();
      $_SESSION['email'] = $email;
      header("Location: index.php");
    }
  }
  
  public function update_user($conn, $id, $f_name, $l_name, $email, $phone, $password, $address_1, $address_2, $city, $state, $zip_code,  $card_num, $exp_month, $exp_year, $card_cvv){
    $update = "UPDATE users
                SET first_name = '$f_name' ,last_name = '$l_name',email ='$email', phone ='$phone',password='$password',address1='$address_1',address2 = '$address_2',city = '$city',state='$state',zip = '$zip_code',card_number = '$card_num',exp_month='$exp_month',exp_year='$exp_year',card_cvv='$card_cvv' 
                WHERE id=:id";
    $stmt = $conn->prepare($update);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if(!empty($stmt)){
      // session_start();
      $_SESSION['email'] = $email;
      header("Location: update_account.php");
    }
  }
  
  // function used in the update account page to add user profile image
  public function uploadFile( $conn, $id, $imageName, $imageData) {
    $insert = "UPDATE users SET image_name = :image_name, image_data = :image_data
   WHERE id=:id";
    $stmt = $conn->prepare($insert);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':image_name', $imageName);
    $stmt->bindParam(':image_data', $imageData);
    $stmt->execute();
    if(!empty($stmt)){
      header("Refresh:0");
    }
  }

}

?>