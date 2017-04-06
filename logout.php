<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700|Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="styles/ihover.css" rel="stylesheet">
  <title>UL Review</title>
</head>
<body id="body">
    <?php 
        /*http://php.net/manual/en/function.session-unset.php*/
        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        session_regenerate_id(true);	
    ?>
    
  <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="logIn.php" target="_self"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
      </div> 
     </div><!-- /.navbar-collapse  **need to look at these divs, too many end div tags-->
      </div><!-- /.container -->
    </nav>

    
     <!-- Welcome panel -->
    <div class="container">
       <br>
    <!-- Tasks Bottons -->
       <div class="panel panel-default">
           <div class="panel-body">
             <div class="index col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xl-6 col-xl-offset-3">
                <br>
                <h1>You are now logged out!</h1>
                <br>
             </div>
           </div>
        </div>
    </div>
             
<script src="js/functions.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>