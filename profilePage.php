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
    //starting the sessaion and checking if a user is logged in, 
    //if there is no logged in user then the user is redirected to the log in page
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
          //retriving the username from the session and displaying it in a message
          $username = $_SESSION['username'];
          printf("<h2>Hi %s!, here you can edit your profile.</h2>", $username);
         ?>
    </div>

<div class="panel-body">

      <!--form column -->
      <div class="col-md-9 personal-info">

        <h3>Personal info</h3>
        <?php
          //**This is the php for altering a users information and also deleting their account
          try{
              //connecting to the database
              $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
              //retriving their name and email from the database
              $stmt = $dbh->prepare("SELECT first_Name, surname, email FROM user_info WHERE username = ?");
              $stmt->execute(array($username));
              $row = $stmt->fetch(PDO::FETCH_ASSOC); 
              //storing the results of the query in variables
              $firstName = $row['first_Name'];
              $surname = $row['surname'];
              $email = $row['email'];
              
              //if the user has made changes and wishes to chenge them
              if(isset($_POST['saveChanges'])){
                 //trimming and ensuring the inputted values do not have html tags in them
                 $newFirstName = htmlspecialchars(ucfirst(trim($_POST["firstName"])));
                 $newSurname = htmlspecialchars(ucfirst(trim($_POST["surname"])));
                 $newEmail = htmlspecialchars(trim($_POST["email"]));
                 $newUsername = htmlspecialchars(trim($_POST["username"]));
                 $pass1 = htmlspecialchars(trim($_POST["password1"]));
                 $pass2 = htmlspecialchars(trim($_POST["password2"]));
                  
                 //variables used to check if the inputted email and username are unique
                 $emailTestCount = 0;
                 $usernameTestCount = 0;
                  
                 //if the inputted username is not the same as th origional then run the following queries
                 if($newUsername != $username){
                    //getting a count of how many times the username appears in the database to check if it is unique
                    $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_info WHERE username = ?" );
                    $stmt->execute(array($newUsername));
                    $usernameTestCount =  $stmt->fetchColumn(0);
                 }
                 if($newEmail != $email){
                    //getting a count of how many times the email appears in the database to check if it is unique
                    $stmt = $dbh->prepare("SELECT COUNT(*) FROM user_info WHERE email = ?" );
                    $stmt->execute(array($newEmail));
                    $emailTestCount = $stmt->fetchColumn(0);
                 }
              
	             //checking that the inputted passwords match
	             if($pass1 != $pass2) {
		            printf("<h2> Passwords do not match. </h2>");
	              }else{
                     //checking that the email is unique
		             if($emailTestCount > 0) {
			            printf("<h2> An account already exists with the given email. %s,    %s</h2>", $email, $newEmail);
		             }
                     //checking that the username is unique
                     else if($usernameTestCount > 0){
                        printf("<h2> An account already exists with the given username. %s,%s, %s</h2>", $username, $newUsername, $usernameTestRows);
                     }else{
                        //checking if they have not put values for a new password
                        if($pass1 == NULL && $pass2 == NULL){
                           //running a query to update their account with the relevant information
                           $stmt = $dbh->prepare("UPDATE user_info SET first_Name = :firstName, surname = :surname, email = :email, username = :newUsername WHERE username = :oldUserName");
                           $stmt->execute(array(':firstName' => $newFirstName, ':surname' => $newSurname, ':email' => $newEmail, ':newUsername' => $newUsername, ':oldUserName' => $username)); 
                        }else if($pass1 == NULL || $pass2 == NULL){
                            print("<h2>If you want to change your password you need to enter it twice</h2>");
                        }else{
                           //the site salt that is appended to the new password
			               $siteSalt  = "paperreview";
                            //the new hashed password
			               $saltedHash = hash('sha256', $pass1.$siteSalt);
                        
                           //updating their user information
                           $stmt = $dbh->prepare("UPDATE user_info SET first_Name = :firstName, surname = :surname, email = :email, username = :newUsername, password = :password WHERE username = :oldUserName");
                           $stmt->execute(array(':firstName' => $newFirstName, ':surname' => $newSurname, ':email' => $newEmail, ':newUsername' => $newUsername,':password' => $saltedHash, ':oldUserName' => $username));
                        }
                        
                        //updating their username in the tasks table
                        $stmt = $dbh->prepare("UPDATE tasks SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUsername' => $newUsername, ':oldUserName' => $username));
                     
                        //updating their username in the flagged tasks table - if they created a task that was flagged
                        $stmt = $dbh->prepare("UPDATE flagged_tasks SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUsername' => $newUsername, ':oldUserName' => $username));
                         
                        //updating their username in the flagged tasks table - if they flagged a task
                        $stmt = $dbh->prepare("UPDATE flagged_tasks SET flaggedBy = :newUsername WHERE flaggedBy = :oldUserName" );
	                    $stmt->execute(array(':newUsername' => $newUsername, ':oldUserName' => $username));
                      
                        //updating their username in the claimed tasks table
                        $stmt = $dbh->prepare("UPDATE claimed_tasks SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUsername' => $newUsername, ':oldUserName' => $username));
                      
                        //updating their username in the user tags table
                        $stmt = $dbh->prepare("UPDATE user_tags SET username = :newUsername WHERE username = :oldUserName" );
	                    $stmt->execute(array(':newUsername' => $newUsername, ':oldUserName' => $username));
                     
                        //setting the username session variable equal to the new username
                        $_SESSION['username'] = $newUsername;
                        
                        //bringing them back to the home page
                        header("Location:./homePage.php");
                     }
                 }
             }
              //these queries will execute if the have decided to delete their account
              elseif(isset($_POST['delete'])){
                //deleteing tasks created by the deleted user that have not being claimed yet
                $stmt = $dbh->prepare("DELETE tasks FROM tasks JOIN task_status USING(task_Id) WHERE tasks.username = :username AND task_status.status_Id = 1 AND tasks.task_Id = :taskID");
	            $stmt->execute(array(':username' => $username, ':taskID' => $taskID));

 
                //updating database so the status of any tasks the deleted user has claimed will be changed to 'Cancelled by Claiment"
                $stmt = $dbh->prepare("UPDATE task_status JOIN claimed_tasks USING(task_Id) SET status_Id = 4 WHERE claimed_tasks.username = ?" ); 
                $stmt->execute(array($username));
                
                  
                //updating database so the status of any tasks the deleted user has uploaded that has been claimed will be changed to 'Cancelled by Uploader"
                $stmt = $dbh->prepare("UPDATE task_status JOIN tasks USING(task_Id) SET status_Id = 6 WHERE tasks.username = ? AND status_Id = 2" );
	            $stmt->execute(array($username));
                  
                //deleting the information on the tags the user was associated with
                $stmt = $dbh->prepare("DELETE FROM user_tags WHERE username = ?" );
	            $stmt->execute(array($username));
                
                //deleting the users information
                $stmt = $dbh->prepare("DELETE FROM user_info WHERE username = ?" );
	            $stmt->execute(array($username));
                
                //navigating them to the account deleted page
                header("Location:./accountDeleted.php");
              }

              
              
              //this displays the form that is being used on the page
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
              //catching any errors that may occur connecting to the database
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
