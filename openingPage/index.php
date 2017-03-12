<!DOCTYPE html>
<html lang="en">
<head>
  <title>UL-Review Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Navbar -->

  <div class="container">
    <!-- <h2>Ul Review</h2> -->
    <img src="images/ULlogInPage.png" alt="UL Review logo" style="width: 548.33px; height: 150px;">
    <p> This is just a small paragraph to explain what is the site about and bla bla bla bla bla. </p>
    <hr>
    <p>Select your prefered languages</p>
    <button class="btn btn-sm">Español</button>
    <button class="btn btn-sm">Deutsche</button>
    <button class="btn btn-sm">Gaeilge</button>
    </br></br>
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#Log-in">Log in</a></li>
      <li><a data-toggle="tab" href="#Register">Register</a></li>
      <li><a data-toggle="tab" href="#forgot-password">Forgot password?</a></li>
    </ul>
    
    
    <?php 
        if (!isset ($_SESSION)) {
           session_start();
								
        }
    ?>
    
  <!-- *********************      LOGIN STUFF      **********************  -->
  <div class="tab-content">
    <div id="Log-in" class="tab-pane fade in active">
      <div class="container">
         <?php
             if (isset($_POST["emailInput"]) && isset($_POST["passwordInput"]) && trim($_POST["emailInput"]) !='' && trim($_POST["passwordInput"]) != ''  ){
                try {
                    $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
			        $email = trim(strtolower($_POST["emailInput"]));
                    $password = $_POST["passwordInput"];	
			        $passwordHash = "";
			
                    $stmt = $dbh->prepare("SELECT username, email, password FROM User_Info WHERE email = ?" );
			        $stmt->execute(array($email));
			        $username = null;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {        
                       $username = $row['username'];
                       $passwordHash = $row['password'];
                    }
		
		           $siteSalt  = "paperreview";
		           $saltedHash = hash('sha256', $password.$siteSalt);
		
		           if ($passwordHash == $saltedHash && !is_null($username)) {
			          $_SESSION['username'] = $username; 
			          //header("Location:./index.php");
                       printf("<h2> Bingo </h2>");
		           } else {
			          printf("<h2> Password incorrect or account not found. </h2>");
		           }

               } catch (PDOException $exception) {
                    printf("Connection error: %s", $exception->getMessage());
	           }
             }
         ?> 
          
        <form action="" method="post" class="form-horizontal">
          <div class="form-group row">
            <h1>Log in to UL Review</h1></br>
            <label for="inputEmail3" class="col-sm-4 col-md-4 control-label">Email (valid UL.ie address)</label>
            <div class="col-sm-5 col-md-4">
              <input type="text" class="form-control" id="inputEmail3" type ="email" name="emailInput"placeholder="JacKel@ul.ie" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-4  col-md-4 control-label">Password (minimum 6 characters)</label>
            <div class="col-sm-5 col-md-4">
              <input type="password" class="form-control" id="inputPassword3" name="passwordInput" minLength="2" placeholder="Password" required>
            </div>
          </div>

          <div class="form-group">
            <div class="checkbox col-xs-6 col-xs-offset-4 col-sm-7 col-sm-offset-5 col-md-2 col-md-offset-5">
              <label for="">
                <input type="checkbox">Remember me
              </label>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6 col-xs-offset-4 col-sm-7 col-sm-offset-5 col-md-2 col-md-offset-5">
              <button class="btn btn-primary"> Log in</button>
            </div>
          </div>
        </form>
        <script>
            $("#NAME").validate();
        </script>
        
        
      </div>
    </div>

    
    
    
    
    
    <!-- *********************      CREATE ACCOUNT STUFF      **********************  -->
    
    <div id="Register" class="tab-pane fade">
      <div class="container">
        <h1>Create new account</h1>
        <p>To create an account you need a valid UL email account.</p>

      </br>
    <?php
        if (isset($_POST) && count ($_POST) > 0) {
	       $firstname = htmlspecialchars(ucfirst(trim($_POST["firstname"])));
	       $surname = htmlspecialchars(ucfirst(trim($_POST["surname"])));
           $major = htmlspecialchars(ucfirst(trim($_POST["major"])));
           $username = htmlspecialchars(trim($_POST["username"]));
	       $email = trim(strtolower($_POST["email"]));
	       $pass1 = $_POST["pass1"];
	       $pass2 = $_POST["pass2"];
            
	
	       //check wheter user/email alerady exists
            try{
	          $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
            }catch(PDOException $exception){
                print("<h2> Uh Oh1</h2>"); 
            }
           //This is slightly changed from the original 
	       $stmt = $dbh->prepare("SELECT username FROM Users WHERE email = ?" );
	       $stmt->execute(array($email));
	       $emailTestRows = $stmt->rowCount();
            
           $stmt = $dbh->prepare("SELECT email FROM Users WHERE username = ?" );
	       $stmt->execute(array($username));
	       $usernameTestRows = $stmt->rowCount();
	       if ($pass1 != $pass2) { //in case Javascript is disabled.
		      printf("<h2> Passwords do not match. </h2>");
	       } else {
		         if ($emailTestRows > 0) { 
			          printf("<h2> An account already exists with the given email.</h2>");
		         } else if($usernameTestRows > 0){
                     printf("<h2> An account already exists with the given username.</h2>");
                 }else {
			         $query = "INSERT INTO User_Info SET username = :username, password = :password, email = :email, firstname = :firstname, surname = :surname, major = :major, points = null, verified_email = null";
			         $stmt = $dbh->prepare($query);
			         $siteSalt  = "paperreview";
			         $saltedHash = hash('sha256', $pass1.$siteSalt);	
			         $affectedRows = $stmt->execute(array(':username' => $username, ':email' => $email, ':firstname' => $firstname, ':surname' => $surname, ':major' => $major, ':password' => $saltedHash));
			
			         if ($affectedRows > 0) {
					       $insertId = $dbh->lastInsertId();
					       printf("<h2> Welcome %s! Please <a href=\"./login.php\"> login </a> to proceed. </h2>", $firstname);
													 //logout first
								/*http://php.net/manual/en/function.session-unset.php*/
                           session_unset();
				           session_destroy();
				           session_write_close();
				           setcookie(session_name(),'',0,'/');
				           session_regenerate_id(true);		
                     }else{
                        print("<h2> Uh Oh2</h2>"); 
                     }
			    }
	       }
	}else if (!isset($_POST) || count($_POST) == 0) { ?>
        
      <form method ="post">
        <div class="form-group">
          <label for="name">First Name</label>
          <input class=" form-control" type="text" id="Firstname" name="firstname" placeholder="Jack">
        </div>

        <div class="form-group">
          <label for="Surname">Surname</label>
          <input class=" form-control" type="text" id="Surname" name="surname" placeholder="Kelleher">
        </div>

        <div class="form-group">
          <label for="Username">Username</label>
          <input class=" form-control" type="text" id="Username" name="username"placeholder="JackKelleher">
        </div>

        <div class="form-group"> 
          <label for="Major">Major/Subject</label>
          <input class=" form-control" type="text" id="Major" name="major" placeholder="Medicine">
        </div>

        <div class="form-group">
          <label for="email">UL email address</label>
          <input class=" form-control" type="text" id="email" name="email" placeholder="12345678@studentmail.ul.ie">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input class=" form-control" type="password" id="password" name="pass1"placeholder="xxxxxxxxx">
        </div>

        <div class="form-group">
          <label for="re-password">Re-enter password</label>
          <input class=" form-control" type="password" id="re-password" name="pass2" placeholder="xxxxxxxxx">
        </div>

        <button class="btn btn-primary">Register</button>
      </div>
    </form>
<?php 
   } 
   ?>	
    
  </div>




<!-- *********************      FORGOT PASSWORD STUFF      **********************  -->

  <div id="forgot-password" class="tab-pane fade">
   <div class="container">
    <h1>Forgot your password?</h1>
    <p>Type your email address and we will send a temporary password that you can change at any time in Setings.</p>
  </br>
      
      
  <?php
   if(isset($_POST["forgotEmail"]) && trim($_POST["forgotEmail"]) != ''){
       try {
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
            $email = trim(strtolower($_POST["forgotEmail"]));
            
            $stmt = $dbh->prepare("SELECT username, email, password FROM User_Info WHERE email = ?" );
            $stmt->execute(array($email));
            $emailTestRows = $stmt->rowCount(); //may need to change variable name
            if($emailTestRows > 0){
                printf("<h2>We have sent an email to the corresponding address with a new password.</h2>");
            }else{
                printf("<h2>There is no account with the address you have given.</h2>");
            }
       }catch(PDOException $exception){
           printf("Connection error: %s", $exception->getMessage());
       }
   }else{ ?> 
       <form method="post">
          <div class="form-group">
             <label for="emailaddress">Email</label>
            <input class=" form-control" type="text" id="emailaddress" name="forgotEmail" placeholder="12345678@studentmail.ul.ie">
          </div>
     
          <button class="btn btn-primary">Enviar</button>
        </form>
   <? } ?>
    </div>
   
    
   
</div>


</div>
</div>

</body>
</html>
