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
        <?php
          try{
              $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
              $stmt = $dbh->prepare("SELECT first_Name, surname, email FROM user_info WHERE username = ?");
              $stmt->execute(array($username));
              $row = $stmt->fetch(PDO::FETCH_ASSOC); 
              $firstName = $row['first_Name'];
              $surname = $row['surname'];
              $email = $row['email'];
              
              if(isset($_POST['saveChanges'])){
                 $newFirstName = htmlspecialchars(ucfirst(trim($_POST["firstName"])));
                 $newSurname = htmlspecialchars(ucfirst(trim($_POST["surname"])));
                 $newEmail = htmlspecialchars(trim($_POST["email"]));
                 $newUsername = htmlspecialchars(trim($_POST["username"]));
                 $pass1 = htmlspecialchars(trim($_POST["password1"]));
                 $pass2 = htmlspecialchars(trim($_POST["password2"]));

                 $emailTestCount = 0;
                 $usernameTestCount = 0;
                 if($newUsername != $username){
                    $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_info WHERE username = ?" );
                    $stmt->execute(array($newUsername));
                    $usernameTestCount =  $stmt->fetchColumn(0);
                 }
                 if($newEmail != $email){
                    $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_info WHERE email = ?" );
                    $stmt->execute(array($newEmail));
                    $emailTestCount = $stmt->fetchColumn(0);
                 }
              
	          
	             if($pass1 != $pass2) { //in case Javascript is disabled.
		            printf("<h2> Passwords do not match. </h2>");
	              }else{
		             if($emailTestCount > 0) {
			            printf("<h2> An account already exists with the given email. %s,    %s</h2>", $email, $newEmail);
		             }else if($usernameTestCount > 0){
                        printf("<h2> An account already exists with the given username. %s,%s, %s</h2>", $username, $newUsername, $usernameTestRows);
                     }else{
                        
                        if($pass1 == NULL){
                           $stmt = $dbh->prepare("UPDATE user_info SET first_Name = :firstName, surname = :surname, email = :email, WHERE username = :oldUserName");
                           $stmt->execute(array(':firstName' => $newFirstName, ':surname' => $newSurname, ':email' => $newEmail, ':oldUserName' => $username)); 
                        }else{
			               $siteSalt  = "paperreview";
			               $saltedHash = hash('sha256', $pass1.$siteSalt);
                     
                           $stmt = $dbh->prepare("UPDATE user_info SET first_Name = :firstName, surname = :surname, email = :email, password = :password WHERE username = :oldUserName");
                           $stmt->execute(array(':firstName' => $newFirstName, ':surname' => $newSurname, ':email' => $newEmail, ':password' => $saltedHash, ':oldUserName' => $username));
                        }
                        
                        $stmt = $dbh->prepare("UPDATE tasks SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUserName' => $newUserName, ':oldUserName' => $username));
                     
                        $stmt = $dbh->prepare("UPDATE flagged_tasks SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUserName' => $newUserName, ':oldUserName' => $username));
                        $stmt = $dbh->prepare("UPDATE flagged_tasks SET flaggedBy = :newUsername WHERE flaggedBy = :oldUserName" );
	                    $stmt->execute(array(':newUserName' => $newUserName, ':oldUserName' => $username));
                     
                     //dont think this is necessary
                     //$stmt = $dbh->prepare("UPDATE banned_user SET username = :newUsername WHERE username = :oldUserName" );
	                 //$stmt->execute(array(':newUserName' => $newUserName, ':oldUserName' => $username));
                      
                        $stmt = $dbh->prepare("UPDATE claimed_tasks SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUserName' => $newUserName, ':oldUserName' => $username));
                      
                        $stmt = $dbh->prepare("UPDATE user_tags SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUserName' => $newUserName, ':oldUserName' => $username));
                     
                        $_SESSION['username'] = $newUserName;
                     }
                 }
             }elseif(isset($_POST['delete'])){
                $stmt = $dbh->prepare("UPDATE task_status SET task_Id = 6 WHERE username = ?" );
	            $stmt->execute(array($username));
                $stmt = $dbh->prepare("UPDATE task_status SET task_Id = 6 FROM tasks JOIN claimed_tasks USING(task_Id) WHERE username = ?" );
	            $stmt->execute(array($username));
                $stmt = $dbh->prepare("DELETE FROM user_tags WHERE username = ?" );
	            $stmt->execute(array($username));
                $stmt = $dbh->prepare("DELETE FROM user_info WHERE username = ?" );
	            $stmt->execute(array($username));
                header("Location:./accountDeleted.php");
              }

              
              
           
              printf('<form class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                           <label class="col-sm-4  col-md-4  control-label">First name:</label>
                           <div class="col-sm-5 col-md-8 col-lg-8">
                              <input class="form-control" type="text" value= %s name="firstName">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-sm-4  col-md-4  control-label">Surname:</label>
                           <div class="col-sm-5 col-md-8 col-lg-8">
                              <input class="form-control" type="text" value= %s name="surname">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4  col-md-4  control-label">Email:</label>
                           <div class="col-sm-5 col-md-8 col-lg-8">
                              <input class="form-control" type="text" value=%s name="email">
                           </div>
                        </div>

                        <div class="form-group">
                           <label class="col-sm-4  col-md-4  control-label">Username:</label>
                           <div class="col-sm-5 col-md-8 col-lg-8">
                              <input class="form-control" type="text" value=%s name="username">
                           </div>
                        </div>
            
                        <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">New Password:<small>(8 characters, 1 uppercase and 1 digit)</small></label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="password" name="password1">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label">Confirm new password:</label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input class="form-control" type="password" name="password2">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4  col-md-4  control-label"></label>
            <div class="col-sm-5 col-md-8 col-lg-8">
              <input type="submit" class="btn btn-default" value="Save Changes" name="saveChanges">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
              <span></span>
              <button type="button" class="btn btn-danger btn-deleteAccount" data-toggle="modal" data-target="#deleteAccount">Delete Account</button>
              

              <!-- Modal -->
              <div class="modal fade" id="deleteAccount" role="dialog">
                <div class="modal-dialog">

                 <!-- Modal content-->
                 <div class="modal-content">
                   <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Are you sure you want to delete your account?</h4>
                   </div>
                   <div class="modal-body">
                      <p>Keep in mind that if you do, you will lose the opportunity to conect with UL students and staff that can help you reviewing your assignments.</p>
                   </div>
                   <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-danger btn-deleteAccount" data-dismiss="modal" name="delete">Delete Account</button>
                   </div>
                 </div>
               </div>
            </div>
         </div>
    </div>
    </form>', $firstName, $surname, $email, $username);
          
          }catch (PDOException $exception) {
              printf("Connection error: %s", $exception->getMessage());
           }
?>
          
          
</div>  <!-- container -->
</div>  <!-- topSpace -->
</div>
</div>

</div>
</body>
</html>
