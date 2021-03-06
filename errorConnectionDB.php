<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700|Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>UL Review</title>
</head>
<body id="body">
    <?php
     //starting a session
     session_start();
     //checking if the username has been set to signify that a user is logged in
     if (!isset($_SESSION['username'])) {
       //if a user isnt logged in then redirect them to the log in page
       header("Location:/logIn.php");
     }
  ?>
    <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a href="logIn.php" target="_self"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
      </div>
    </div><!-- /.navbar-collapse **need to look at closing div tags-->
  </nav>


     <!-- Welcome panel -->
    <div class="container">
       <br>
    <!-- Tasks Bottons -->
       <div class="panel panel-default">
           <div class="panel-body">
             <div class="index col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xl-6 col-xl-offset-3">
                <br>
                <h2>Error to connect with the database.</h2></br>
                <br>
             </div>
           </div>
        </div>
    </div>

</body>
</html>
