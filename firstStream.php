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
        //starting a session and checking if a user is logged in
        //if a user isnt logged in they are redirected to the log in page
        session_start();
        if (!isset ($_SESSION['username'])) {
           header("Location: /logIn.php");					
        }
  ?>
    
  <!-- Navbar -->
  <nav class="navbar navbar-info">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
          <a href="homePage.php" target="_self"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
        <!-- <a class="navbar-brand" href="#">UL Review</a> -->
      </div><!-- /.navbar-header -->
    </div><!-- /.container -->
  </nav>

  <div class="container">
  <div class="panel panel-info">
    <div class="panel-heading"><h2>Just one more thing... </h2></div>
    <div class="panel-body">
      <h4>In order to create your personalized stream we need to know the subjects you care about.</h4>
      <p>Min 3 topics</p>
    </div>

    </br>
    <?php
        //getting the username of the user that is logged in
        $username = $_SESSION['username'];
        //checking if the form has been submitted
        if (isset($_POST) {
            //checking if the user has inserted 3 or more topics
            if(count($_POST) > 2) {
               //retriving the topics the user has submitted
               $topicArray[0] = htmlspecialchars(ucfirst(trim($_POST["topic1"])));
               $topicArray[1]  = htmlspecialchars(ucfirst(trim($_POST["topic2"])));
               $topicArray[2]  = htmlspecialchars(ucfirst(trim($_POST["topic3"])));
               $topicArray[3]  = htmlspecialchars(ucfirst(trim($_POST["topic4"])));
               $topicArray[4]  = htmlspecialchars(ucfirst(trim($_POST["topic5"])));
               $topicArray[5]  = htmlspecialchars(ucfirst(trim($_POST["topic6"])));
               
               //attempting to connect to the database
               try{
                 //connecting to the database
	             $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
                 
                 //this enhanced for loop goes through the array of tags
                 foreach($topicArray as $topic){
                    //check if the topic is not empty
                    if($topic != ''){
                       //removing any html special characters if any
                       $topic = htmlspecialchars(trim($topic));
                       //checking if this topic is already in the topics that have been inserted into the database
                       $stmt = $dbh->prepare("SELECT COUNT(*) FROM tag_ids WHERE tag_Name = ?" );
			           $stmt->execute(array($topic));
                    
                       //if the count returns 0 - the topic is not already in the database
                       if($stmt->fetchColumn(0) == 0 ){
                          //inserting the topic into the database
                          $stmt = $dbh->prepare("INSERT INTO tag_ids (tag_Name, tag_Id) VALUES (?, NULL)");
                          $stmt->execute(array($topic));
                       }
                       //retriving the tag id of the topic the user has entered
                       $stmt = $dbh->prepare("SELECT tag_Id FROM tag_ids WHERE tag_Name = ?");
                       $stmt->execute(array($topic));
                       $tagID = $stmt->fetchColumn(0);
                       //inserting this tag id into the table that holds the tags that the user has been associated with
                       $stmt = $dbh->prepare("INSERT INTO user_tags VALUES (:tagID, :username)");
                       $affectedRows = $stmt->execute(array(':tagID' => $tagID, ':username' => $username));
                       //checking that the tags have been entered so the user can be redirected to the home page
                       if($affectedRows > 0){
                          header("Location:./homePage.php");
                       }else{
                          //displaying an error
                          printf("<h2>ERROR</h2>");  
                       } 
                   }
                }              
              }
             //catching an error if there is a problem connecting to the database
             catch(PDOException $exception){
                 print("<h2> Uh Oh</h2>"); 
              }            
          }else{
             // header to appear on page if the user has not entered enough topics
             print("<h2> You must enter at least 3 topics</h2>");     
          }
       }
    ?>
    <form method="post">
    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <label for="Topic1">Topic #1</label>
      <input class=" form-control" type="text" id="Topic1" placeholder="English" name="topic1">
    </div>

    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <label for="Topic2">Topic #2</label>
      <input class=" form-control" type="text" id="Topic2" placeholder="HTML" name="topic2">
    </div>

    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <label for="Topic3">Topic #3</label>
      <input class=" form-control" type="text" id="Topic3" placeholder="Irish Literature" name="topic3">
    </div>

    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <label for="Topic4">Topic #4</label>
      <input class=" form-control" type="text" id="Topic4" placeholder="Contemporary Dance" name="topic4">
    </div>

    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <label for="Topic5">Topic #5</label>
      <input class=" form-control" type="text" id="Topic5" placeholder="Computer Science" name="topic5">
    </div>

    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
      <label for="Topic6">Topic #6</label>
      <input class=" form-control" type="text" id="Topic6" placeholder="Civil Engineering" name="topic6">
    </div>
    <br>
    
    <div class="btn-center">
    <button type="Submit" class="btn btn-primary center-block">Submit</button>
    </form>
    <br>
    <br>
    </div>

    </div>
    </div>
  </div>
</div> <!-- div container -->

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
