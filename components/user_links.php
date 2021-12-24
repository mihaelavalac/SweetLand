<?php include './head.php';
include '../global/mysql.php'; ?>
<div class='container  user-links text-center'>
  <div class='row p-2'>
    <div class='col-sm-12 col-md-6 col-lg-4'>
      <div class='card m-2 bg-secondary' style='height:220px '>
        <a href='update_account.php' class='btn'>
          <img src='img/user.png' alt='An icon of a user/person.' class='link-img'>
          <p class='h5 card-title display-6'>Account</p>
        </a>
      </div>
    </div>
    <div class='col-sm-12 col-md-6 col-lg-4'>
      <div class='card m-2 bg-secondary' style=' height: 220px'>
        <a href='favorites.php' class='btn'>
          <img src='img/favorite.png' alt='An icon of a user/person.' class='link-img'>

          <p class='h5 card-title display-6'>Favorites</p>

        </a>
      </div>
    </div>

    <div class='col-sm-12 col-md-6 col-lg-4' style=' height: 200'>
      <div class='card m-2 bg-secondary' style=' height: 220px'>
        <a href='orders_history.php' class='btn'>
          <img src='img/history.png' alt='An icon of a user/person.' class='link-img'>
          <p class='h5 card-title display-6'>History</p>
        </a>
      </div>

    </div>
  </div>

</div>
</div>