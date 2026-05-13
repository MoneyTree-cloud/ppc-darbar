<!-- admin.html -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- ======= Styles ====== -->
  <!--<link rel="stylesheet" href="../style.css">-->
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
            <!-- <span class="icon">
              <ion-icon name="logo-apple"></ion-icon>
            </span> -->
            <span class="title"><img src="../../assets/imgs/logo.png" alt=""></span>
          </a>
        </li>

        <li>
          <a href="index.php">
            <span class="icon">
              <ion-icon name="home"></ion-icon>
            </span>
            <span class="title">Overview</span>
          </a>
        </li>

         <li>
          <a href="team.php">
            <span class="icon">
              <ion-icon name="person-add"></ion-icon>
            </span>
            <span class="title">Team members</span>
          </a>
        </li>

        <li>
          <a href="#" onclick="openPopup('<p>Are You Sure, You want to Logout?</p>', true)" class="active">
            <span class="icon">
              <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Sign Out</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../../main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>