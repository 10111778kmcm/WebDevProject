<!DOCTYPE html>
<html lang="en">

<head>
  <title>UL-Review Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700|Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/jquery.validate.js"></script>
  <script src="js/createAccountValidateScript.js"></script>
</head>


<body>
    <?php
        //creating a session if there isnt one already created
        if (!isset ($_SESSION)) {
           session_start();

        }
        //destrying a session so a user is automatically logged out if the move to this page
        else{
            session_start();
            session_unset();
            session_destroy();
            session_write_close();
            setcookie(session_name(),'',0,'/');
            session_regenerate_id(true);
        }
    ?>
  <!-- Navbar -->
  <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a href="logIn.php" target="_self"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
        <!-- <a class="navbar-brand" href="#">UL Review</a> -->
      </div>

      </div><!-- /.container -->
    </nav>

  <!-- Content Choose one -->
  <div class="container">
    <?php
         //**This is the php code for the log in functionality**

         //checking that the email and password fields have been filled in and are not empty
         if (isset($_POST["emailInput"]) && isset($_POST["passwordInput"]) && trim($_POST["emailInput"]) !='' && trim($_POST["passwordInput"]) != ''  ){
            try {
                //connecting to the database
                $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");

                //retriving the email that the user has entered
			    $email = trim(strtolower($_POST["emailInput"]));

                //retriving the password that the user has entered
                $password = $_POST["passwordInput"];
                $passwordHash = "";

                //getting the username and password that is associated with the email entered
                $stmt = $dbh->prepare("SELECT username, email, password FROM user_info WHERE email = ?" );
     	        $stmt->execute(array($email));

                //setting the username variable to null - will be used in a test later
                $username = null;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  //getting the username and hashed password from the database from the query
                  $username = $row['username'];
                  $passwordHash = $row['password'];
                }

                //this string is appeneded to the password
		        $siteSalt  = "paperreview";

                //the inputted password is appended with the site salt and hashed
		        $saltedHash = hash('sha256', $password.$siteSalt);

                //if the entered hashed password is equal to the hashed password
                //retrived from the database and the username has been set
                if ($passwordHash == $saltedHash && !is_null($username)) {
                    //checking if the user is on the banned user list
                   $stmt = $dbh->prepare("SELECT count(*) FROM banned_user WHERE username = ?" );
		           $stmt->execute(array($username));
			       if($stmt->fetchColumn(0) > 0){
                       //if they are on the banned list then redirect them to the banned page
                       header("Location:./bannedPage.php");
                   }else{
                      //if the user is not on the banned list the insert their username into a session variable
                      $_SESSION['username'] = $username;

                      //statement to check if the user has enough points to be considered a moderator
                      $stmt = $dbh->prepare("SELECT points FROM user_info WHERE username = ?" );
		              $stmt->execute(array($username));

                      //if they do have enough points then set a session variable equal to 1
                      //to signify that they are a moderator - else set the same session variable to 0
                      if($stmt->fetchColumn(0) >= 40){
                          $_SESSION['moderator'] = 1;
                      }else{
                          $_SESSION['moderator'] = 0;
                      }

                      //checking if any tasks are expired so we can change their status
                      $stmt = $dbh->prepare("UPDATE tasks JOIN task_status USING(task_Id) SET status_Id = 3 WHERE CURRENT_TIMESTAMP > claim_deadline");
	                  $stmt->execute();
                      $stmt = $dbh->prepare("UPDATE tasks JOIN task_status USING(task_Id) SET status_Id = 3 WHERE CURRENT_TIMESTAMP > submission_deadline");
	                  $stmt->execute();

                      //checking if the user has enough tags associated with them
                      $stmt = $dbh->prepare("SELECT username FROM user_tags WHERE username = ?" );
	                  $stmt->execute(array($username));

                      //variable to store the count of tags they have been associated with
                      $count = $stmt->rowCount();

                      //if they are not associated with enough tags then they are brought to a page to insert some
                      if($count < 2){
                         header("Location:./firstStream.php");
                      }
                      //if they have enough ags associated with them then they are brough to the home page
                      else{
                        header("Location:./homePage.php");
                      }
                   }

		       }else {
                  //displaying that the information the entered is not correct
			      printf("<h2> Password incorrect or account not found. </h2>");
		      }
          }catch (PDOException $exception) {
              //Javascript used to redirect the user to the databse error page
                     ?>
                      <script type="text/javascript">
                        window.location.href = './errorConnectionDB.php';
                      </script>
                      <?php
	      }
       }
    ?>
    <div class="panel panel-info">
      <div class="panel-heading"><h2>Choose One</h2></div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#Log-in">Log In</a></li>
          <li><a data-toggle="tab" href="#Register">Register</a></li>
        </ul>
      </div>


      <div class="tab-content">
        <div id="Log-in" class="tab-pane fade in active">
          <div class="container">
            <form action="" class="form-horizontal" method="post">
              <div class="form-group row">
                <h1>Log In</h1></br>
                <label for="inputEmail3" class="col-sm-4 col-md-4 control-label">UL Email</label>
                <div class="col-sm-5 col-md-5">
                  <input class="form-control" id="inputEmail3" name="emailInput" pattern=".+@studentmail.ul.ie" placeholder="123456789@studentmail.ul.ie">
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-4  col-md-4 control-label">Password<small>(8 characters, 1 uppercase and 1 digit)</small></label>
                <div class="col-sm-5 col-md-5">
                  <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength = "8" name="passwordInput" class="form-control" id="inputPassword3" type="Password">
                </div>
              </div>>

              <div class="form-group">
                <div class="col-xs-6 col-xs-offset-4 col-sm-7 col-sm-offset-5 col-md-2 col-md-offset-5">
                  <button class="btn btn-primary" type="submit">Log In</button>
                  <br>
                  <br>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Create new account -->
        <div id="Register" class="tab-pane fade">
          <div class="container">
            <div class="description-of-page">
              <h1>Create Account</h1>
              <h4>To create an account you need a valid UL email account.</h4>
            </div>
          </br>
          <?php
            //**This is the php code for creating an account**

            //checking if the user has submitted the form
            if (isset($_POST['register'])) {

               //retriving the values from the form that the user has submitted and removing
               //any html tags that they may have inserted
	           $firstname = htmlspecialchars(ucfirst(trim($_POST["firstname"])));
	           $surname = htmlspecialchars(ucfirst(trim($_POST["surname"])));
               $major = htmlspecialchars(ucfirst(trim($_POST["major"])));
               $username = htmlspecialchars(trim($_POST["username"]));
	           $email = trim(strtolower($_POST["email"]));
	           $pass1 = $_POST["pass1"];
	           $pass2 = $_POST["pass2"];

               try{
                 //connecting to the database
	             $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
               }catch(PDOException $exception){
                    //Javascript used to redirect the user to the databse error page
                     ?>
                      <script type="text/javascript">
                        window.location.href = './errorConnectionDB.php';
                      </script>
                      <?php
               }

               //query to check if the email they have inputted is already in the database
	           $stmt = $dbh->prepare("SELECT username FROM user_info WHERE email = ?" );
	           $stmt->execute(array($email));
               //returns a count of the amount of usernames that have that email
               //if it return any number above 0 then it is not unique
	           $emailTestRows = $stmt->rowCount();

               //query to check if the username they have inputted is already in the database
               $stmt = $dbh->prepare("SELECT email FROM user_info WHERE username = ?" );
	           $stmt->execute(array($username));
               //returns a count of the amount of emails that have that username
               //if it return any number above 0 then it is not unique
	           $usernameTestRows = $stmt->rowCount();

               //test to check if the passwords that they entered match
	           if ($pass1 != $pass2) {
                 //error to display if they do not match
		         printf("<h2> Passwords do not match. </h2>");

	           } else {
                   //checking if it is a unique email
		            if ($emailTestRows > 0) {
			           printf("<h2> An account already exists with the given email.</h2>");
		            }
                    //checking if it is a unique username
                    else if($usernameTestRows > 0){
                       printf("<h2> An account already exists with the given username.</h2>");
                        //$test = False;
                    }else {
                      //inserting the users data into the database
			          $query = "INSERT INTO user_info VALUES (:username, :email, :password, :first_Name, :surname, :major, 0)";
                      $stmt = $dbh->prepare($query);
                      //this is the salt used to append onto the users selected password
			          $siteSalt  = "paperreview";
                      //hashing their password
			          $saltedHash = hash('sha256', $pass1.$siteSalt);
                      //executing the query and inserting the variables into they query
			          $affectedRows = $stmt->execute(array(':username' => $username, ':email' => $email, ':password' => $saltedHash, ':first_Name' => $firstname, ':surname' => $surname, ':major' => $major));
			          
                      ?>
                      <!--Javascript used to redirect the user to the create sucsessful page -->
                      <script type="text/javascript">
                        window.location.href = './createSucsessful.php';
                      </script>
                      <?php
			       }
	           }
	       }
           ?>
          <form method="post" id="createAccountForm">
            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="name">First Name</label>
              <input class=" form-control" type="text" id="name" name="firstname" placeholder="Jack">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="Surname">Surname</label>
              <input class=" form-control" type="text" id="Surname" name="surname" placeholder="Kelleher">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="Username">Username</label>
              <input class=" form-control" type="text" id="Username" name="username" placeholder="JackKelleher">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="Major">Major/Subject</label>
              <select class="form-control" id="sel1" name="major">
                <option>IT</option>
                <option>Chemistry</option>
                <option>Physics</option>
                <option>Biology</option>
                <option>Music</option>
                <option>History</option>
                <option>Law</option>
                <option>Literature</option>
                <option>Dance</option>
                <option>Maths</option>
                <option>Engineering</option>
                <option>Journalism</option>
                <option>Business</option>
                <option>Electrical Engineering</option>
              </select>
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="email">UL Email</label>
              <input class=" form-control" name="email" pattern=".+@studentmail.ul.ie" id="email" placeholder="12345678@studentmail.ul.ie" type="email">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="password">Password<small>(8 characters, 1 uppercase and 1 digit)</small> </label>
              <input class=" form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="password" name="pass1" type="password">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="re-password">Re-enter Password</label>
              <input class=" form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="re-password" name="pass2" type="password">
            </div>
            <br>
            <button class="btn btn-primary center-block" type="submit" name="register">Register</button>
            <br>
            <br>
          </div>
        </form>
      </div>
  </div>

</div> <!-- panel-body -->
</div> <!-- panel panel-info -->
</div> <!-- container step 2 -->

<!-- Design By: Cynthia, Jack, Kevin & Kieran-->


</body>
</html>
