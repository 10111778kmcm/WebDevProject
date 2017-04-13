<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700|Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">



  <title>Profile</title>
</head>
<body id="body">
  <script src="js/functions.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <?php
     session_start();
     if (!isset($_SESSION['username'])) {
       header("Location:/logIn.php");
     }
  ?>

  <!-- Nav Bar -->
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
     <div class="navbar-header">
       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="homePage.php"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
      <!-- <a class="navbar-brand" href="#">UL Review</a> -->
    </div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
        <li><a href="homePage.php">Home</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
</div><!-- /.collapse navbar-collapse -->

</nav>

<!-- Profile panel  -->
<!-- http://www.bootply.com/sY7gQy6XF7 -->
<div class="topSpace" id="myTasks">
<div class="container">
  <div class="panel panel-info">
    <div class="panel-heading">
      <?php
          $username = $_SESSION['username'];
          printf("<h2>Hi %s!, here you can edit your profile.</h2>", $username);
         ?>
    </div>

<div class="panel-body">

      <!--form column -->
      <div class="col-md-9 personal-info">

        <h3>Personal info</h3>

        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">First name:</label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="text" value="Jane">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">Surname:</label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="text" value="Bishop">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">Email:</label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="text" value="janesemail@studentmail.ul.ie">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">Username:</label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="text" value="janeuser">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">New Password:<small>(8 characters, 1 uppercase and 1 digit)</small></label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="password" value="11111122333">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">Confirm new password:</label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="password" value="11111122333">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label"></label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input type="button" class="btn btn-default" value="Save Changes">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
              <span></span>
              <input type="button" class="btn btn-danger btn-deleteAccount" value="Delete Account">
            </div>
          </div>
        </form>
</div>  <!-- container -->
</div>  <!-- topSpace -->
</div>
</div>

</div>
</body>
</html>
