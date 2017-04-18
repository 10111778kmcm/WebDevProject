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
      <a href="#body"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
      <!-- <a class="navbar-brand" href="#">UL Review</a> -->
    </div>

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
   <?php
      if($_SESSION['moderator'] == 1){
    ?>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="flaggedTasks.php">Flagged Tasks</a></li>
   <?php
      }
   ?>

     <!--   Dropdown Tasks -->
     <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tasks <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="#myTasks">My tasks</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#createTask">Create Task</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#claimedTasks">Claimed Tasks</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#availableTasks">Available Tasks</a></li>
      </ul>
    </li>

    <ul class="nav navbar-nav">
      <li><a href="profilePage.php">Profile</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Log out</a></li>
    </ul>
  </ul>
</div><!-- /.container -->

</nav>

<!-- Welcome panel -->
      <div class="topSpace">
<div class="container">
  <!-- Tasks Bottons -->
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="index col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xl-6 col-xl-offset-3">
        <?php
            $username = $_SESSION['username'];
            printf("<h1>Welcome, %s!</h1>", $username);
           ?>
      </div>
      <div class="index col-xs-12 col-sm-6 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3 col-xl-9 col-xl-offset-3">
        <p>Here you can add tasks, review your tasks, claim a task and view your settings.</p>
      </div>

      <div class=" col-xs-12 col-sm-6  col-md-3 col-lg-3  col-xl-3 ">
        <a href="#myTasks" type="button" class="btn btn-lg btn-TasksIndex"><div class="icon"><img src="images/circle-01.png" alt=""></div> <h2>My Tasks</h2></a>
      </div>


      <div class=" col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
        <a href="#createTask" type="button" class="btn btn-lg btn-TasksIndex"><div class="icon"><img src="images/circle-02.png" alt=""></div> <h2>Create Task</h2></a>
      </div>

      <div class=" col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
        <a href="#claimedTasks" type="button" class="btn btn-lg btn-TasksIndex"><div class="icon"><img src="images/circle-03.png" alt=""></div> <h2>Claimed Task</h2></a>
      </div>

      <div class=" col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
        <a href="#availableTasks" type="button" class="btn btn-lg btn-TasksIndex"><div class="icon"><img src="images/circle-04.png" alt=""></div> <h2>Available Tasks</h2></a>
      </div>
    </div> <!-- panel body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->
</div><!-- topSpace -->


<!-- My tasks -->
<div class="topSpace" id="myTasks">
<div class="container">
  <div class="panel panel-info">
    <div class="panel-heading"><h2>My Tasks</h2></div>
    <div class="panel-body">
     <?php

        try{
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
		    $counter = 0;
            $username = $_SESSION['username'];
            $stmt = $dbh->prepare("SELECT task_Id, title, flagged_count, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline, major, status_Id FROM tasks JOIN task_status USING(task_Id) WHERE username = ?");
            $stmt->execute(array($username));
            if($stmt->rowCount() == 0){
                printf("<h2 class='description-of-page'>You have not created any tasks yet.</h2>", $username);
            }else{
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   $taskID = $row['task_Id'];
                   $title = $row['title'];
                   $flagCount = $row['flagged_count'];
                   $type = $row['type'];
                   $pageNo = $row['page_no'];
                   $wordCount = $row['word_Count'];
                   $fileFormat = $row['file_format'];
                   $description = $row['description'];
                   $claimDeadline = $row['claim_deadline'];
                   $submissionDeadline = $row['submission_deadline'];
                   $major = $row['major'];
                   $status = $row['status_Id'];
                   $targetIdentifier = "#myModel";
                   $target = "myModel";
                   $buttonIdentifier = "button";
                   $buttonID = $buttonIdentifier.$counter;
                   $targetID  = $targetIdentifier.$counter;
                   $target = $target.$counter;
                   $relatedFile = "FileUploads/".$taskID.$fileFormat;


                  $ClaimDateFormat = explode("-", $claimDeadline);
                  $SubmissionDateFormat = explode("-", $submissionDeadline);
                  $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                  $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];

                   $tags[0] = "";
                   $tags[1] = "";
                   $tags[2] = "";
                   $tags[3] = "";
                   $tagCounter = 0;
                   $stmt2 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                   $stmt2->execute(array($taskID));
                   while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                       if($tagCounter < 3){
                          $tags[$tagCounter] = $row2['tag_Name'].",";
                       }else{
                          $tags[$tagCounter] = $row2['tag_Name'];
                       }
                       $tagCounter++;
                   }
                    //need to add code for submit rating

                   //This switch works off the status id's and are as follows
                   //1 - Pending Claim
                   //2 - Claimed
                   //3 - Expired
                   //4 - Cancelled By Claiment
                   //5 - Completed
                   switch($status){
                     case "1":
                        //Pending Claim
                        printf('<button type= %s class="btn btn-MyTasksPending btn-lg" data-toggle="modal"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Pending </br> <b>Date:</b> </br>%s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title title">Title: %s</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="type">
                                           Type: %s
                                        </div>

                                        <div class="type">
                                           Major: %s
                                        </div>

                                        <div class="tags">
                                            Tags: %s %s %s %s
                                        </div>
                                        <div class="no-of-pages">
                                            No of pages: %s
                                        </div>
                                        <div class="no-of-words">
                                            No of word: %s
                                        </div>
                                        <div class="file-Format">
                                            File Format: %s
                                        </div>
                                        <div class="description">
                                            Description: %s
                                        </div>
                                        <div class="claimed-deadline">
                                            Claim Deadline: %s
                                        </div>
                                        <div class="completion-deadline">
                                            Completion Deadline: %s
                                        </div>

                                        <embed src= %s width="200px" height="360px" />
                                        
                                        <a href=%s download=%s>Download Preview</a>
                                        
                                        <div class="modal-footer">
                                           <form method="post">
                                              <button type="submit" class="btn btn-default" name="delete" value= %s>Delete</button>
                                           </form>
                                           <p>Status: Pending Claim</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID);
                     break;

                     case "2":
                        //Claimed
                        printf('<button type= %s class="btn btn-MyTasksClaimed btn-lg" data-toggle="modal"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Claimed </br> <b>Date:</b> </br>%s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title title">Title: %s</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="type">
                                           Type: %s
                                        </div>
                                         <div class="type">
                                           Major: %s
                                        </div>
                                        <div class="tags">
                                            Tags: %s %s %s %s
                                        </div>
                                        <div class="no-of-pages">
                                            No of pages: %s
                                        </div>
                                        <div class="no-of-words">
                                            No of word: %s
                                        </div>
                                        <div class="file-Format">
                                            File Format: %s
                                        </div>
                                        <div class="description">
                                            Description: %s
                                        </div>
                                        <div class="claimed-deadline">
                                            Claim Deadline: %s
                                        </div>
                                        <div class="completion-deadline">
                                            Completion Deadline: %s
                                        </div>

                                        <embed src= %s width="200px" height="500px" />
                                        
                                        <a href=%s download=%s>Download Preview</a>
                                        
                                        <div class="modal-footer">
                                           <form method="post">
                                              <button type="submit" class="btn btn-default" name="cancel" value= %s>Cancel</button>
                                           </form>
                                           <p>Status: Claimed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID);
                     break;

                     case "3":
                        //Expired Claim - may need to get different deadline
                        printf('<button type= %s class="btn btn-MyTasksExpired btn-lg" data-toggle="modal"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Expired </br> <b>Date:</b> </br>%s</button>
                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title title">Title: %s</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="type">
                                           Type: %s
                                        </div>
                                         <div class="type">
                                           Major: %s
                                        </div>
                                        <div class="tags">
                                            Tags: %s %s %s %s
                                        </div>
                                        <div class="no-of-pages">
                                            No of pages: %s
                                        </div>
                                        <div class="no-of-words">
                                            No of word: %s
                                        </div>
                                        <div class="file-Format">
                                            File Format: %s
                                        </div>
                                        <div class="description">
                                            Description: %s
                                        </div>
                                        <div class="claimed-deadline">
                                            Claim Deadline: %s
                                        </div>
                                        <div class="completion-deadline">
                                            Completion Deadline: %s
                                        </div>

                                        <embed src= %s width="200px" height="500px" />
                                        
                                        <a href=%s download=%s>Download Preview</a>

                                    </div>
                                    <div class="modal-footer">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="delete" value= %s>Delete</button>
                                           <button type="submit" class="btn btn-default" name="reupload" value= %s>Re-Upload</button>
                                        </form>
                                        <p>Status: Expired</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID, $taskID);
                     break;

                     case "4":
                        //Cancelled Claim
                        printf('<button type= %s class="btn btn-MyTasksCancelled btn-lg"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Cancelled </br> <b>Date:</b> </br>%s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title title">Title: %s</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="type">
                                           Type: %s
                                        </div>
                                         <div class="type">
                                           Major: %s
                                        </div>
                                        <div class="tags">
                                            Tags: %s %s %s %s
                                        </div>
                                        <div class="no-of-pages">
                                            No of pages: %s
                                        </div>
                                        <div class="no-of-words">
                                            No of word: %s
                                        </div>
                                        <div class="file-Format">
                                            File Format: %s
                                        </div>
                                        <div class="description">
                                            Description: %s
                                        </div>
                                        <div class="claimed-deadline">
                                            Claim Deadline: %s
                                        </div>
                                        <div class="completion-deadline">
                                            Completion Deadline: %s
                                        </div>

                                        <embed src= %s width="200px" height="500px" />
                                        
                                        <a href=%s download=%s>Download Preview</a>

                                    </div>
                                    <div class="modal-footer">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="delete" value= %s>Delete</button>
                                           <button type="submit" class="btn btn-default" name="reupload" value= %s>Re-Upload</button>
                                        </form>
                                        <p>Status: Cancelled by Claiment</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID, $taskID);
                     break;

                     case "5":
                        //Completed
                        printf('<button type= %s class="btn btn-MyTasksCompleted btn-lg" data-toggle="modal"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Completed </br> <b>Date:</b> </br>%s</button>

                        <div class="modal fade" id= %s role="dialog">
                             <div class="modal-dialog">
                             <!-- Modal content-->
                               <div class="modal-content">
                                 <div class="modal-header">
                                   <button type= %s class="close" data-dismiss="modal">&times;</button>
                                   <h4 class="modal-title">%s</h4>
                                 </div>
                                 <div class="modal-body">
                                    <h3> Please rate the feedback you have recieved</h3>
                                    <form method="get">
                                       <button name ="good" type="submit" class="btn btn-lg btn-info" value = %s>
                                          <img src="images/happy.jpg" alt="submit" width="120px" height="120px">
                                       </button>
                                       <button name ="middle" type="submit" class="btn btn-lg btn-info" value = %s>
                                          <img src="images/neutral.jpg" alt="submit" width="120px" height="120px">
                                       </button>
                                       <button name ="bad" type="submit" class="btn btn-lg btn-info" value = %s>
                                          <img src="images/sad.jpg" alt="submit" width="120px" height="120px">
                                       </button>
                                    </form>
                                 </div>
                                 <div class="modal-footer">
                                    <p>Status: Completed</p>
                                 </div>
                              </div>
                            </div>
                         </div>', $buttonID, $targetID, $title, $submissionDeadline, $target, $buttonID,  $title, $taskID,$taskID,$taskID);
                    }
                  $counter++;
                }
             }
           } catch (PDOException $exception) {
                printf("Connection error: %s", $exception->getMessage());
          }

          if(isset($_POST['cancel'])){
            $taskID = $_POST['cancel'];
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 6 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
          }else if(isset($_POST['delete'])){
            $taskID = $_POST['delete'];
            $stmt = $dbh->prepare("DELETE FROM tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            $stmt = $dbh->prepare("DELETE FROM task_status WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            $stmt = $dbh->prepare("DELETE FROM assigned_tags WHERE task_Id = ?");
            $stmt->execute(array($taskID));
          }else if(isset($_POST['good'])){
            $taskID = $_POST['good'];
			$stmt = $dbh->prepare("UPDATE user_info SET points = points + 5 WHERE username = (SELECT username FROM claimed_tasks WHERE taskID = ?)");
			$stmt->execute(array($taskID));
          }else if(isset($_POST['middle'])){
            $taskID = $_POST['middle'];
            $stmt = $dbh->prepare("UPDATE user_info SET points = points + 2 WHERE username = (SELECT username FROM claimed_tasks WHERE taskID = ?)");
			$stmt->execute(array($taskID));
          }else if(isset($_POST['bad'])){
            $taskID = $_POST['bad'];
			$stmt = $dbh->prepare("UPDATE user_info SET points = points - 5 WHERE username = (SELECT username FROM claimed_tasks WHERE taskID = ?)");
			$stmt->execute(array($taskID));
          }


    ?>
    </div> <!-- panel-body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->
</div> <!-- topSpace -->

<!-- Create task -->
<div class="topSpace" id="createTask">
<div class="container" >
  <div class="panel panel-info">
    <div class="panel-heading"><h2>Create Task</h2></div>
    <div class="panel-body">





      <h4>Create a task to get a peer to review it.</h4>
    </br>
      <?php
        if (isset($_POST['createTaskSubmit'])) {
           $title = htmlspecialchars(ucfirst(trim($_POST["title"])));
           $type = htmlspecialchars(ucfirst(trim($_POST["type"])));
           $tagArray[0] = htmlspecialchars(ucfirst(trim($_POST["tags1"])));
           $tagArray[1] = htmlspecialchars(ucfirst(trim($_POST["tags2"])));
           $tagArray[2]= htmlspecialchars(ucfirst(trim($_POST["tags3"])));
           $tagArray[3] = htmlspecialchars(ucfirst(trim($_POST["tags4"])));
           $pageNum = htmlspecialchars(trim($_POST["pageNum"]));
           $wordNum = htmlspecialchars(trim($_POST["wordNum"]));
           $fileFormat = htmlspecialchars(trim($_POST["fileFormat"]));
           $description = htmlspecialchars(trim($_POST["description"]));
           $major = $_POST["major"];
           $claimDeadline = str_ireplace("/","-",$_POST["claimDeadline"]);
           $submissionDeadline = str_ireplace("/","-",$_POST["submissionDeadline"]);




           $username = $_SESSION['username'];

           $createTask = true;

           //file stuff $taskID taken from https://davidwalsh.name/basic-file-uploading-php and //https://www.w3schools.com/php/php_file_upload.asp

           $targetDirectory = "FileUploads/";
           $target_file = $targetDirectory.basename($_FILES["fileUpload"]["name"]);
           $fileType = ".".strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

           //printf("<h2> fileFormat: %s</h2>", $fileFormat);
           //printf("<h2> fileType: %s</h2>", $fileType);
           if($_FILES['fileUpload']['name']){
             if(!$_FILES['fileUpload']['error']){ //if there is no errors
                 if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
                     if(strcasecmp($fileFormat, $fileType) != 0){
                         print("<h2>File Types must match!</h2>");
                         $createTask = false;
                     }
                  }
              }else{
                 print("<h2>Error with upload!</h2>");
                 $createTask = false;
              }
            }else{
              print("<h2>No file uploaded!</h2>");
              $createTask = false;
            }
          if($createTask){
           try{
	         $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
             $query = "INSERT INTO tasks VALUES(:username, NULL, :title, :type, :pageNum, :wordCount, :fileFormat, :description, :claimDeadline, :submissionDeadline, 0, :major)";
             $stmt = $dbh->prepare($query);
             $affectedRows = $stmt->execute(array(':username' => $username, ':title' => $title, ':type' => $type, ':pageNum' => $pageNum, ':wordCount' => $wordNum, ':fileFormat' => $fileFormat, ':description' => $description, ':claimDeadline' => $claimDeadline, ':submissionDeadline' => $submissionDeadline, ':major' => $major));

             $query = "SELECT task_Id FROM tasks WHERE username = :username AND title = :title";
             $stmt = $dbh->prepare($query);
             $stmt->execute(array(':username' => $username, ':title' => $title));
             $taskID = $stmt->fetchColumn(0);

             $stmt = $dbh->prepare("INSERT INTO task_status VALUES (?, 1)");
             $stmt->execute(array($taskID));

             //using taskID to name uploaded file
             $newFileName = $taskID;
             move_uploaded_file($_FILES['fileUpload']['tmp_name'], $targetDirectory.$newFileName.$fileType);

             //inserting tags
             foreach($tagArray as $tag){
                $tag = htmlspecialchars(trim($tag));
                $stmt = $dbh->prepare("SELECT COUNT(*) FROM tag_ids WHERE tag_Name = ?" );
                $stmt->execute(array($tag));
                if ($stmt->fetchColumn(0) == 0 ){
                   $stmt = $dbh->prepare("INSERT INTO tag_ids (tag_Name, tag_Id) VALUES (?, NULL)");
                   $stmt->execute(array($tag));
                }
                $stmt = $dbh->prepare("SELECT tag_Id FROM tag_ids WHERE tag_Name = ?");
                $stmt->execute(array($tag));
                $tagID = $stmt->fetchColumn(0);
                $stmt = $dbh->prepare("INSERT INTO user_tags VALUES (:tagID, :username)");
                $affectedRows = $stmt->execute(array(':tagID' => $tagID, ':username' => $username));
                if($affectedRows == 0){
                    printf("<h2>ERROR</h2>");
                }else{
                    //header("Refresh:0");
                    //need a way to refresh the page so that the new task will appear in my tasks straight away
                }
                $stmt = $dbh->prepare("INSERT INTO assigned_tags VALUES(:taskID, :tagID)");
                $stmt->execute(array('taskID' => $taskID, ':tagID' => $tagID));
             }
           }catch(PDOException $exception){
              print("<h2> Uh Oh1</h2>");
           }
        }else{
           print("<h2> Uh OhBottom</h2>");
        }
      }
      ?>
    <form method="post" enctype="multipart/form-data">
      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="title">Title</label>
        <input class=" form-control" type="text" id="title" name="title"  placeholder="World War II">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="type">Type</label>
        <input class=" form-control" type="text" id="Type" name="type" placeholder="FYP, essay, notes">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="Tags">Tag 1</label>
        <input class=" form-control" data-role="tagsinput" type="text" id="Tags" name="tags1"  placeholder="History">
      </div>
        
      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="Tags">Tag 2</label>
        <input class=" form-control" data-role="tagsinput" type="text" id="Tags" name="tags2"  placeholder="Irish Literature">
      </div>
        
      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="Tags">Tag 3</label>
        <input class=" form-control" data-role="tagsinput" type="text" id="Tags" name="tags3"  placeholder="Solo Composition">
      </div>
        
      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="Tags">Tag 4</label>
        <input class=" form-control" data-role="tagsinput" type="text" id="Tags" name="tags4"  placeholder="Contract Law">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="no-of-pages">No of pages</label>
        <input class=" form-control" type="number" id="No-of-pages" minlength="1" maxlength="50" name="pageNum" placeholder="20">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="no-of-words">No of words</label>
        <input class=" form-control" type="number" id="No-of-words" minlength="100" maxlength="15000" name="wordNum" placeholder="12456">
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
            <option>Buisness</option>
            <option>Electrical Engineering</option>
            <option>Other</option>
         </select>
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="file-Format">File Format</label>
        <select class="form-control" id="sel2" name="fileFormat" >
          <option>.doc</option>
          <option>.docx</option>
          <option>.pdf</option>
          <option>.ppt</option>
          <option>.pptx</option>
          <option>.txt</option>
        </select>
      </div>

      <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <label for="description">Description</label>
        <input class=" form-control" type="text" maxlength="500" id="Description" name="description"  placeholder="Max 100 words">
      </div>



        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
          <label for="re-password">Claimed deadline</label>
             <div>

                 <p> Date: <input type="date" class="datepicker" name="claimDeadline"></p>
             </div>
        </div>

        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
           <label for="re-password">Completion deadline</label>
           <div>

              <p> Date: <input type="date" class="datepicker" name="submissionDeadline"></p>
           </div>
         </div>






        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
           <label for="re-password">File Upload (A short summary of your task)</label>
           <div>
              <input type="file" name="fileUpload" id="fileToUpload">
           </div>
         </div>

         <br>
         <button class="btn btn-primary center-block" type="submit" name="createTaskSubmit">Create</button>
         <br>
         <br>
     </form>
  </div> <!-- panel-body -->
</div> <!-- panel panel-default -->
</div> <!-- container -->
</div> <!-- topSpace -->

<!-- Claimed tasks -->
<div class="topSpace" id="claimedTasks">
<div class="container" >
  <div class="panel panel-info">
    <div class="panel-heading"><h2>Claimed Tasks</h2></div>
    <div class="panel-body">
      <?php
        try {
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
		    $counter = 0;
            $username = $_SESSION['username'];
            $stmt = $dbh->prepare("SELECT task_Id, status_Id, title, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline , major FROM tasks JOIN task_status USING(task_Id) JOIN claimed_tasks USING(task_Id) WHERE claimed_tasks.username = ?");
            $stmt->execute(array($username));
            if($stmt->rowCount() == 0){
                printf("<h2 class='description-of-page'> You have not claimed any tasks. </h2>", $username);
            }else{
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $taskID = $row['task_Id'];
                $status = $row['status_Id'];
                $title = $row['title'];
                $type = $row['type'];
                $pageNo = $row['page_no'];
                $wordCount = $row['word_Count'];
                $fileFormat = $row['file_format'];
                $description = $row['description'];
                $claimDeadline = $row['claim_deadline'];
                $submissionDeadline = $row['submission_deadline'];
                $major = $row['major'];
                $targetIdentifier = "#myModelClaimed";
                $target = "myModelClaimed";
                $buttonIdentifier = "button";
                $buttonID = $buttonIdentifier.$counter;
                $targetID  = $targetIdentifier.$counter;
                $target = $target.$counter;

                  $ClaimDateFormat = explode("-", $claimDeadline);
                  $SubmissionDateFormat = explode("-", $submissionDeadline);
                  $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                  $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];

                $tags[0] = "";
                $tags[1] = "";
                $tags[2] = "";
                $tags[3] = "";
                $tagCounter = 0;
                $stmt2 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                $stmt2->execute(array($taskID));
                while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                       if($tagCounter < 3){
                          $tags[$tagCounter] = $row2['tag_Name'].",";
                       }else{
                          $tags[$tagCounter] = $row2['tag_Name'];
                       }
                       $tagCounter++;
                   }
                //this switch works off the status id's and are as follows
                //2 - Claimed ( awaiting completion)
                //3 - Expired
                //5 - Completed
                switch($status){
                    case "2":
                       printf('<button type= %s class="btn btn-MyTasksClaimed btn-lg"
                       data-target= %s data-toggle="modal"><b>Title:</b></br> %s</br> <b>Status:</b></br> Claimed </br> <b>Date:</b> </br>%s</button>
                               <!-- Modal -->
                               <div class="modal fade" id= %s role="dialog">
                                  <div class="modal-dialog">
                                  <!-- Modal content-->
                                     <div class="modal-content">
                                        <div class="modal-header">
                                           <button type= %s class="close" data-dismiss="modal">&times;</button>
                                           <h4 class="modal-title title">Title: %s</h4>
                                        </div>
                                        <div class="modal-body">
                                           <div class="type">
                                              Hello, I am ______  and I have claimed your task please send the file to my mail. 
                                           </div>
                                        </div>
                                        <div class="modal-footer">
                                           <form method="post">
                                              <button type="submit" class="btn btn-default" name="cancel" value= %s>Cancel</button>
                                              <button type="submit" class="btn btn-default" name="complete" value= %s>Complete</button>
                                           </form>
                                           <p>Status: Claimed</p>
                                       </div>
                                    </div>
                                </div>
                             </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $taskID, $taskID);
                    break;

                    case"3":
                        printf('<button type= %s class="btn btn-MyTasksExpired btn-lg" data-toggle="modal"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Expired </br> <b>Date:</b> </br>%s</button>

                               <!-- Modal -->
                               <div class="modal fade" id= %s role="dialog">
                                  <div class="modal-dialog">
                                     <!-- Modal content-->
                                     <div class="modal-content">
                                        <div class="modal-header">
                                           <button type= %s class="close" data-dismiss="modal">&times;</button>
                                           <h4 class="modal-title title">Title: %s</h4>
                                        </div>
                                        <div class="modal-body">
                                           <div class="type">
                                              Type: %s
                                           </div>
                                           <div class="type">
                                              Major: %s
                                           </div>
                                           <div class="tags">
                                              Tags: %s %s %s %s
                                           </div>
                                           <div class="no-of-pages">
                                              No of pages: %s
                                           </div>
                                           <div class="no-of-words">
                                              No of word: %s
                                           </div>
                                           <div class="file-Format">
                                              File Format: %s
                                           </div>
                                           <div class="description">
                                              Description: %s
                                           </div>
                                           <div class="claimed-deadline">
                                              Claim Deadline: %s
                                           </div>
                                           <div class="completion-deadline">
                                              Completion Deadline: %s
                                           </div>
                                       </div>
                                    </div>
                                  </div>
                               </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $type, $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline);
                    break;

                    case"6":
                          printf('<button type= %s class="btn btn-MyTasksCancelled btn-lg"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Cancelled </br> <b>Date:</b> </br>%s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title title">Title: %s</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h2> This task has been cancelled by the owner.</h2>
                                        <h2> Please press the "Okay" button to acknowledge this.<h2>

                                    </div>
                                    <div class="modal-footer">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="acknowledge" value= %s>Ok</button>
                                        </form>
                                        <p>Status: Cancelled by Claiment</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $taskID);
                    break;
                }
                $counter++;
             }
          }
        }catch(PDOException $exception){
            printf("Connection error: %s", $exception->getMessage());
        }

       if(isset($_POST['cancel'])){
            $taskID = $_POST['cancel'];
            $stmt = $dbh->prepare("DELETE FROM claimed_tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 1 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
			$stmt = $dbh->prepare("UPDATE user_info SET points = points - 15 WHERE username = ?");
			$stmt->execute(array($username));
       }else if(isset($_POST['complete'])){
            $taskID = $_POST['complete'];
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 5 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
       }else if(isset($_POST['acknowledge'])){
            $taskID = $_POST['acknowledge'];
            $stmt = $dbh->prepare("DELETE FROM claimed_tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            $stmt = $dbh->prepare("DELETE FROM tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            $stmt = $dbh->prepare("DELETE FROM task_status WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            $stmt = $dbh->prepare("DELETE FROM assigned_tags WHERE task_Id = ?");
       }


?>

    </div> <!-- panel-body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->
</div> <!-- topSpace -->

<!-- Available tasks -->
<div class="topSpace" id="availableTasks">
<div class="container" >
  <div class="panel panel-info">
    <div class="panel-heading">
        <h2>Available Tasks</h2>
    </div>

    <!-- Panel body -->
    <div class="panel-body">
      <?php try {
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
		    $counter = 0;
            $stmt = $dbh->prepare("SELECT DISTINCT(task_Id), title, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline ,major FROM tasks JOIN task_status USING(task_Id) JOIN assigned_tags USING(task_Id) JOIN user_tags USING(tag_Id) WHERE tasks.username != :username1 AND status_Id = 1 AND user_tags.username = :username2 AND flagged_count = 0");
            $stmt->execute(array(':username1' => $username, ':username2' => $username));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $taskID = $row['task_Id'];
                $title = $row['title'];
                $type = $row['type'];
                $pageNo = $row['page_no'];
                $wordCount = $row['word_Count'];
                $fileFormat = $row['file_format'];
                $description = $row['description'];
                $claimDeadline = $row['claim_deadline'];
                $submissionDeadline = $row['submission_deadline'];
                $major = $row['major'];
                $targetIdentifier = "#myModelAvailable";
                $target = "myModelAvailable";
                $buttonIdentifier = "button";
                $buttonID = $buttonIdentifier.$counter;
                $targetID  = $targetIdentifier.$counter;
                $target = $target.$counter;
                $relatedFile = "FileUploads/".$taskID.$fileFormat;
                
                $ClaimDateFormat = explode("-", $claimDeadline);
                $SubmissionDateFormat = explode("-", $submissionDeadline);
                $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];


                $tags[0] = "";
                $tags[1] = "";
                $tags[2] = "";
                $tags[3] = "";
                $tagCounter = 0;
                $stmt2 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                $stmt2->execute(array($taskID));
                while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                       if($tagCounter < 3){
                          $tags[$tagCounter] = $row2['tag_Name'].",";
                       }else{
                          $tags[$tagCounter] = $row2['tag_Name'];
                       }
                       $tagCounter++;
                   }

                printf('<button type= %s class="btn btn-MyTasksAvailable btn-lg" data-toggle="modal"
                data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Available </br> <b>Date:</b> </br>%s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title title">Title: %s</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="type">
                                            Type: %s
                                        </div>
                                         <div class="type">
                                           Major: %s
                                        </div>
                                        <div class="tags">
                                            Tags: %s %s %s %s
                                        </div>
                                        <div class="no-of-pages">
                                            No of pages: %s
                                        </div>
                                        <div class="no-of-words">
                                            No of word: %s
                                        </div>
                                        <div class="file-Format">
                                            File Format: %s
                                        </div>
                                        <div class="description">
                                            Description: %s
                                        </div>
                                        <div class="claimed-deadline">
                                            Claim Deadline: %s
                                        </div>
                                        <div class="completion-deadline">
                                            Completion Deadline: %s
                                        </div>
                                        
                                        <embed src= %s width="200px" height="360px" />
                                        
                                        <a href=%s download=%s>Download Preview</a>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="post">
                                            <button type="submit" class="btn btn-default" name="claim" value="%s">Claim</button>
                                            <button type="submit" class="btn btn-default" name="flag" value="%s">Flag</button>
                                        </form>
                                        <p>Status: Available</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID, $taskID);
                $counter++;
            }
        }catch(PDOException $exception){
             printf("Connection error: %s", $exception->getMessage());
        }
        if(isset($_POST['claim'])){
           $taskID = $_POST['claim'];
           $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 2 WHERE task_Id = ?");
           $stmt->execute(array($taskID));
           $stmt = $dbh->prepare("INSERT INTO claimed_tasks VALUES(:taskID, CURRENT_TIMESTAMP, :username)");
           $stmt->execute(array(':taskID' => $taskID, ':username' => $username));
		   $stmt = $dbh->prepare("UPDATE user_info SET points = points + 10 WHERE username = ?");
		   $stmt->execute(array($username));
        }else if(isset($_POST['flag'])){

           $taskID = $_POST['flag'];
           $stmt = $dbh->prepare("SELECT flagged_count FROM tasks WHERE task_Id = ?");
           $stmt->execute(array($taskID));
           $flaggedCount = $stmt->fetchColumn(0) + 1;

           $stmt = $dbh->prepare("UPDATE tasks SET flagged_count = :flaggedCount WHERE task_Id = :taskID");
           $stmt->execute(array(':flaggedCount' => $flaggedCount, ':taskID' => $taskID));
		   $stmt = $dbh->prepare("UPDATE user_info SET points = points + 2 WHERE username = ?");
		   $stmt->execute(array($username));
        }
?>
    </div> <!-- panel-body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->
    </div> <!-- topSpace -->
</div>
</body>
</html>
