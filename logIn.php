<!DOCTYPE html>
<html lang="en">

<head>
  <title>UL-Review Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700|Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<body>
    <?php 
        if (!isset ($_SESSION)) {
           session_start();							
        }
    ?>
  <!-- Navbar -->
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
        <!-- <a class="navbar-brand" href="#">UL Review</a> -->
      </div>

<ul class="nav navbar-nav navbar-right">
      <!--   Dropdown Languages -->
      <li class="dropdown ">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Español</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Deutsche</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Gaeilge</a></li>
        </ul>
      </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>

  <!-- Content Step 2 -->
  <div class="container">
    <?php
         if (isset($_POST["emailInput"]) && isset($_POST["passwordInput"]) && trim($_POST["emailInput"]) !='' && trim($_POST["passwordInput"]) != ''  ){
            try {
                $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
			    $email = trim(strtolower($_POST["emailInput"]));
                $password = $_POST["passwordInput"];	
                $passwordHash = "";
			
                $stmt = $dbh->prepare("SELECT username, email, password FROM user_info WHERE email = ?" );
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
                      
                   //statement to check points for moderator - needs to be changed to sql statement
                   $stmt = $dbh->prepare("SELECT points FROM user_info WHERE username = ?" );
		           $stmt->execute(array($username));
                   if($stmt->fetchColumn(0) >= 40){
                        $_SESSION['moderator'] = 1;  
                   } 
                                  
                   //puting in code to check if they have created any tags
                   $stmt = $dbh->prepare("SELECT username FROM user_tags WHERE username = ?" );
	               $stmt->execute(array($username));
                   $count = $stmt->rowCount();
                   if($count < 5){
                     header("Location:./firstStream.php");
                   }else{
                     header("Location:./homePage.php");
                   }
		          }else {
			          printf("<h2> Password incorrect or account not found. </h2>");
		          }
               } catch (PDOException $exception) {
                    printf("Connection error: %s", $exception->getMessage());
	           }
             }
         ?> 
    <div class="panel panel-info">
      <div class="panel-heading"><h2>Choose one:</h2></div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#Log-in">Log in</a></li>
          <li><a data-toggle="tab" href="#Register">Register</a></li>
          <li><a data-toggle="tab" href="#forgot-password">Forgot password?</a></li>
        </ul>
      </div>


      <div class="tab-content">
        <div id="Log-in" class="tab-pane fade in active">
          <div class="container">
            <form action="" class="form-horizontal" method="post">
              <div class="form-group row">
                <h1>Log in</h1></br>
                <label for="inputEmail3" class="col-sm-4 col-md-4 control-label">UL Email</label>
                <div class="col-sm-5 col-md-5">
                  <input class="form-control" id="inputEmail3" name="emailInput" pattern=".+@studentmail.ul.ie" placeholder="123456789@studentmail.ul.ie">
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-4  col-md-4 control-label">Password <small>(8 characters, 1 uppercase, 1 digit)</small></label>
                <div class="col-sm-5 col-md-5">
                  <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength = "8" name="passwordInput" class="form-control" id="inputPassword3" placeholder="Password">
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
                  <button class="btn btn-primary" type="submit"> Log in</button>
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
              <h1>Create new account</h1>
              <h4>To create an account you need a valid UL email account.</h4>
            </div>
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
               $test = True;
	           //check wheter user/email alerady exists
               try{
	             $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
               }catch(PDOException $exception){
                   print("<h2> Uh Oh1</h2>"); 
                   $test = False;
               }

	           $stmt = $dbh->prepare("SELECT username FROM user_info WHERE email = ?" );
	           $stmt->execute(array($email));
	           $emailTestRows = $stmt->rowCount();
            
               $stmt = $dbh->prepare("SELECT email FROM user_info WHERE username = ?" );
	           $stmt->execute(array($username));
	           $usernameTestRows = $stmt->rowCount();
	           if ($pass1 != $pass2) { //in case Javascript is disabled.
		         printf("<h2> Passwords do not match. </h2>");
                   $test = False;
	           } else {
		            if ($emailTestRows > 0) { 
			           printf("<h2> An account already exists with the given email.</h2>");
                        $test = False;
		            } else if($usernameTestRows > 0){
                       printf("<h2> An account already exists with the given username.</h2>");
                        $test = False;
                    }else {
			          $query = "INSERT INTO user_info VALUES (:username, :email, :password, :first_Name, :surname, :major, 40, 'N')";
                      $stmt = $dbh->prepare($query);
			          $siteSalt  = "paperreview";
			          $saltedHash = hash('sha256', $pass1.$siteSalt);	
			          $affectedRows = $stmt->execute(array(':username' => $username, ':email' => $email, ':password' => $saltedHash, ':first_Name' => $firstname, ':surname' => $surname, ':major' => $major));
			          header("Location:./createSucsessful.php");
			         /*if ($affectedRows > 0) {
					       //$insertId = $dbh->lastInsertId();
                           header("Location:./createSucsessful.php");
                     }else{
                        print("<h2> Uh Oh2</h2>");
                         $test = False;
                     }*/
			       }
	           }
	       } 
           ?>
          <form method="post">
            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="name">Name</label>
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
                <option>Arts, Humanities and Social Sciences</option>
                <option>Kemmy Business School</option>
                <option>Education and Health Sciences</option>
                <option>Science and Engineering</option>
                <option>Irish World Academy of Music and Dance</option>
              </select>
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="email">UL email address</label>
              <input class=" form-control" name="email" pattern=".+@studentmail.ul.ie" id="email" placeholder="12345678@studentmail.ul.ie">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="password">Password <small>(8 characters, 1 uppercase, 1 digit)</small> </label>
              <input class=" form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="password" name="pass1" placeholder="xxxxxxxxx">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="re-password">Re-enter password</label>
              <input class=" form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="re-password" name="pass2" placeholder="xxxxxxxxx">
            </div>
            <br>
            <button class="btn btn-primary center-block" type="submit" name="register">Register</button>
            <br>
            <br>
          </div>
        </form>
      </div>

      <div id="forgot-password" class="tab-pane fade">
        <div class="container">
          <div class="description-of-page">
            <h1>Forgot your password?</h1>
            <h4>Type your email address and we will send a temporary password that you can change at any time in Settings.</h4>
          </div>
        </br>
        <form action="" class="form-horizontal">
          <div class="form-group row">
            <label for="emailaddress" class="col-sm-4  col-md-4 control-label">UL Email</label>
            <div class="col-sm-5 col-md-5">
              <input pattern=".+@studentmail.ul.ie" class="form-control" id="emailaddress" placeholder="12345678@studentmail.ul.ie">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-6 col-xs-offset-4 col-sm-7 col-sm-offset-5 col-md-2 col-md-offset-5">
              <button type="submit" class="btn btn-primary">Send</button>
              <br>
              <br>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</div> <!-- panel-body -->
</div> <!-- panel panel-info -->
</div> <!-- container step 2 -->

<!-- <footer class="text-center bg-lightgray">
  <div class="container">
    <p>Limerick City © 2017
      <br>
      <span>Design By: Cynthia, Jack, Kevin &amp; Kieran</span></p>
    </div>
  </footer> -->


</body>
</html>
