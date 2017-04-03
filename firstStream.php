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
        $username = $_SESSION['username'];
        if (isset($_POST) && count($_POST) > 2) {
           $topic1 = htmlspecialchars(ucfirst(trim($_POST["topic1"])));
           $topic2 = htmlspecialchars(ucfirst(trim($_POST["topic2"])));
           $topic3 = htmlspecialchars(ucfirst(trim($_POST["topic3"])));
           $topic4 = htmlspecialchars(ucfirst(trim($_POST["topic4"])));
           $topic5 = htmlspecialchars(ucfirst(trim($_POST["topic5"])));
           $topic6 = htmlspecialchars(ucfirst(trim($_POST["topic6"])));
           $topicArray = array($topic1, $topic2, $topic3, $topic4, $topic5, $topic6);
           try{
	         $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
             foreach($topicArray as $topic){
                if($topic != ''){
                    $topic = htmlspecialchars(trim($topic));
                    $stmt = $dbh->prepare("SELECT COUNT(*) FROM tag_ids WHERE tag_Name = ?" );
			        $stmt->execute(array($topic));
                    if ($stmt->fetchColumn(0) == 0 ){
                       $stmt = $dbh->prepare("INSERT INTO tag_ids (tag_Name, tag_Id) VALUES (?, NULL)");
                       $stmt->execute(array($topic));
                    }
                    $stmt = $dbh->prepare("SELECT tag_Id FROM tag_ids WHERE tag_Name = ?");
                    $stmt->execute(array($topic));
                    $tagID = $stmt->fetchColumn(0);
                    $stmt = $dbh->prepare("INSERT INTO user_tags VALUES (:tagID, :username)");
                    $affectedRows = $stmt->execute(array(':tagID' => $tagID, ':username' => $username));
                    if($affectedRows > 0){
                       header("Location:./homePage.php");
                    }else{
                       printf("<h2>ERROR</h2>");  
                    } 
                 }
              }              
           }catch(PDOException $exception){
              print("<h2> Uh Oh</h2>"); 
           }            
        }else{
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
    <?php
      }
    ?>
    <br>
    <br>
    </div>

    <!-- <footer>
    <div class="container">
    <div class="footer-text">
      <p>Made in Ireland</p>
    </div>
    </div>
    </footer> -->
    </div>
    </div>
  </div>
</div> <!-- div container -->

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
