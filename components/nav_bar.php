<nav id="nav" class=" navbar navbar-expand-lg bg-secondary">
    <div class="container-fluid">
        <a aria-label="Sweetland logo" class="logo" href="index.php"><img src="img/Sweetland-logos_transparent.png" alt="" width="200px" height="auto"></a>
        <button class="navbar-toggler navbar-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 text-dark">
                <li class="nav-item ">
                    <a class="nav-link text-black " aria-current="page" href="index.php">Home</a>
                </li>
                <?php if (isset($_SESSION['email'])) {
                        ?><li>
                    <div class="dropdown show bg-secondary">
                        <a class="text-primary dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong><?php echo $f_name ?></strong>

                        </a>

                        <div class="dropdown-menu text-primary bg-secondary" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="favorites.php">Favorites</a>
                            <a class="dropdown-item" href="orders_history.php">Orders</a>
                            <a class="dropdown-item" href="update_account.php">Account</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </div></li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link text-black " href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 bg-primary text-white fw-bold" href="sign_up.php">Sign Up</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link text-black" href="menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="contact.php">Contact</a>
                </li>
                <li><a name="shopping cart icon " id="shopping-cart" class="nav-link" href="shopping_cart.php" style="padding-top:0px !important; "><span style="position:relative;"> <span class="card-notification text-primary" style="font-size:large !important; font-weight:800; position:absolute; right:13px; top:-3px;"></span>
                            <svg aria-label="shopping cart icon " xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" class="bi bi-cart" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </svg></span></a></li>
            </ul>
        </div>
    </div>
</nav>