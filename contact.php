<?php
include "global/db_functions.php";
include 'global/mysql.php';
include './classes/user.class.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include "head.php";
  if (isset($_SESSION['email'])) {
    $user = new User();
    $user_info = $user->getUserInfo($conn, $_SESSION['email']);
    $f_name = $user_info[0]['first_name'];
    $user_id = $user_info[0]['id']; }
  ?>
</head>

<body>
  <style>
    #contact {
      background-color: white;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .contact-box {
      width: clamp(100px, 90%, 1000px);
      margin: 80px 50px;
      display: flex;
      flex-wrap: wrap;
    }

    .contact-links,
    .contact-form-wrapper {
      width: 50%;
      padding: 8% 5% 10% 5%;
    }


    .contact-links {
      background-image: url("./img/bg-contact.jpg");
      background-repeat: no-repeat;
      background-size: cover;
    }

    .contact-form-wrapper {
      /* background-color: #ffffff8f; */
      border-radius: 0 10px 10px 0;
    }

    @media only screen and (max-width: 800px) {

      .contact-links,
      .contact-form-wrapper {
        width: 100%;
      }

      .contact-links {
        border-radius: 10px 10px 0 0;
      }

      .contact-form-wrapper {
        border-radius: 0 0 10px 10px;
      }
    }

    @media only screen and (max-width: 400px) {
      .contact-box {
        width: 95%;
        margin: 8% 5%;
      }
    }

    h2 {
      font-family: 'Arimo', sans-serif;
      color: #fff;
      font-size: clamp(30px, 6vw, 60px);
      letter-spacing: 2px;
      text-align: center;
      transform: scale(.95, 1);
    }

    .links {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding-top: 50px;
    }

    .link {
      text-decoration: none;
      margin: 10px;
      cursor: pointer;
    }

    .link-img {

      width: 55px;
      height: 55px;
      transition: 0.2s;
      user-select: none;
    }

    .link-img:hover {
      transform: scale(1.1, 1.1);
    }

    .link-img:active {
      transform: scale(1.1, 1.1);
    }

    .form-item {
      position: relative;
    }

    label,
    input,
    textarea {
      font-family: 'Poppins', sans-serif;
    }

    label {
      position: absolute;
      top: 10px;
      left: 2%;
      color: #999;
      font-size: clamp(14px, 1.5vw, 18px);
      pointer-events: none;
      user-select: none;
    }


    input,
    textarea {
      width: 100%;
      outline: 0;
      border: 1px solid #dd5b45;
      border-radius: 4px;
      margin-bottom: 20px;
      padding: 12px;
      font-size: clamp(15px, 1.5vw, 18px);
    }

    input:focus+label,
    input:valid+label,
    textarea:focus+label,
    textarea:valid+label {
      font-size: clamp(13px, 1.3vw, 16px);
      color: #777;
      top: -20px;
      transition: all .225s ease;
    }

    .submit-btn {
      background-color: #dd5b45;
      color: #fff;
      font-weight: bold;
      font-size: clamp(16px, 1.6vw, 18px);
      display: block;
      padding: 12px 20px;
      margin: 2px auto;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      user-select: none;
      transition: 0.2s;
    }

    .submit-btn:hover {
      transform: scale(1.1, 1.1);
    }

    .submit-btn:active {
      transform: scale(1.1, 1.1);
      filter: sepia(0.5);
    }

    @media only screen and (max-width: 800px) {
      h2 {
        font-size: clamp(40px, 10vw, 60px);
      }
    }

    @media only screen and (max-width: 400px) {
      h2 {
        font-size: clamp(30px, 12vw, 60px);
      }

      .links {
        padding-top: 30px;
      }

      .link-img {
        width: 60px;
        height: 60px;
      }
    }
  </style>
  <?php include("components/nav_bar.php"); ?>
  <section id="contact">
    <div class="contact-box bg-secondary">
      <div class="contact-links">
        <h2>CONTACT</h2>
        <div class="links">
          <div class="link">
            <a href="mailto: sweetland@gmail.com"><img class="link-img rounded p-2 bg-primary" src="./img/email-64.png" alt="linkedin"></a>
          </div>
          <div class="link">
            <a href="https://www.facebook.com/" target="_blank"><img class="link-img rounded p-2 bg-primary" src="./img/facebook-64.png" alt="email"></a>
          </div>
          <div class="link">
            <a href="tel:614-345-6789"><img class="link-img rounded p-2 bg-primary" src="./img/phone-46-64.png" alt="email"></a>
          </div>
        </div>
      </div>
      <div class="contact-form-wrapper">
        <form method="POST" action='<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
          <div class="form-item">
            <input type="text" name="sender" required>
            <label for="sender">Name:</label>
          </div>
          <div class="form-item">
            <input type="email" name="email" required>
            <label for="email">Email:</label>
          </div>
          <div class="form-item">
            <textarea class="" name="message" required></textarea>
            <label for="message">Message:</label>
          </div>
          <button class="submit-btn" type="submit" name="send_message">Send</button>
        </form>
      </div>
    </div>
  </section>
  <?php


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function addMessage($conn, $name, $email, $message) {
      $sql = "INSERT INTO contact (name, email, message) VALUES (:name, :email,:message)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':message', $message);
      $stmt->execute();
    };

    if (isset($_POST['send_message'])) {
      $name = ($_POST["sender"]);
      $email = ($_POST["email"]);
      $message = ($_POST["message"]);
      addMessage($conn, $name, $email, $message);
    }
  };


  include("components/footer.php");
  ?>
</body>

</html>