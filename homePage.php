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
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>



  <?php
    //creating a session and checking a user is loggedin, if there isnt then the user is brough back to the log in page
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
      //checking if the user is a moderator so the flagged tasks option will appear for them
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
            //displaying a welcome message with the users username
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
        //**This section is the php code for the "MY Tasks" task stream
        try{
            //connecting to the databse
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");

            //this counter is used to distinguish between tasks so the pop ups that
            //appear when a task is clicked on will be associated with the correct task
		    $counter = 0;

            //setting the username equal to the username that us stored in the session
            $username = $_SESSION['username'];

            //this query retrives al relevant information on the tasks that the user has created
            $stmt = $dbh->prepare("SELECT task_Id, title, flagged_count, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline, major, status_Id FROM tasks JOIN task_status USING(task_Id) WHERE username = ?");
            $stmt->execute(array($username));

            //if no task information is returned then this message is displayed
            if($stmt->rowCount() == 0){
                printf("<h2 class='description-of-page'>You have not created any tasks yet.</h2>", $username);
            }else{

                //this while loop retirives the task information from the rown
                //returned by the query and displays the task button and the task pop up windows
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                   //retriving task information from each row returned by the query
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

                   //these variables are used as unique identifiers for each task button and task pop up
                   $targetIdentifier = "#myModel";
                   $target = "myModel";
                   $buttonIdentifier = "button";
                   $buttonID = $buttonIdentifier.$counter;
                   $targetID  = $targetIdentifier.$counter;
                   $target = $target.$counter;

                   //this is the file address for the file that is associated with the task
                   $relatedFile = "FileUploads/".$taskID.$fileFormat;

                  //these variables reformat the date so that it is easier to read for the user
                  $ClaimDateFormat = explode("-", $claimDeadline);
                  $SubmissionDateFormat = explode("-", $submissionDeadline);
                  $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                  $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];

                  //tag array for the tags associated with each task
                  $tags[0] = "";
                  $tags[1] = "";
                  $tags[2] = "";
                  $tags[3] = "";

                  //variable to keep count of how many tags are retrived
                  $tagCounter = 0;

                  //query returning the tags linked to each task
                  $stmt2 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                  $stmt2->execute(array($taskID));

                  //this while loop appends some of the tags with a comma so they look better when being displayed
                  while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                       if($tagCounter < 3){
                          $tags[$tagCounter] = $row2['tag_Name'].",";
                       }else{
                          $tags[$tagCounter] = $row2['tag_Name'];
                       }
                       $tagCounter++;
                   }

                   //if the users task has been claimed then we need to retrive some information on the user who claimed it
                   if($status == 2){
                        $stmt3 = $dbh->prepare("SELECT first_Name, surname, email FROM user_info JOIN claimed_tasks USING(username) WHERE claimed_tasks.task_Id = ?");
                        $stmt3->execute(array($taskID));
                        $row = $stmt3->fetch(PDO::FETCH_ASSOC);
                        $firstName = $row['first_Name'];
                        $surname = $row['surname'];
                        $claimentEmail = $row['email'];
                   }

                   /*This switch works off the status id's and are as follows
                   *1 - Pending Claim
                   *2 - Claimed
                   *3 - Expired
                   *4 - Cancelled By Claiment
                   *5 - Completed
                   * The switch displays all of the tasks that the has created and thei associated pop up box
                   */
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
                                        <h4 class="modal-title">Title: %s</h4>
                                    </div>
                                    <div class="modal-footer">
                                    <form role="form">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
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

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                      <embed src= %s width="200px" height="330px" />
                                      </br>
                                      <a href=%s download=%s>Download Preview</a>
                                      </br>
                                      <div class="btn-bottom-modals">
                                      <form method="post">
                                         <button type="submit" class="btn btn-default" name="delete" value= %s>Delete</button>
                                      </form>
                                      <p>Status: Pending Claim</p>
                                      </div>
                                    </div>
                                    </form>
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
                                    <div class="modal-footer">
                                    <form role="form">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-left">
                                        <div class="type">
                                           Type: %s
                                        </div>

                                        <div class="type">
                                           Major: %s
                                        </div>

                                        <div class="type">
                                           Claiment Name: %s %s
                                        </div>

                                        <div class="type">
                                           Claiment Email: %s
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

                                      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">

                                        <embed src= %s width="200px" height="500px" />

                                        <a href=%s download=%s>Download Preview</a>
                                        </br>
                                        <div class="btn-bottom-modals">
                                           <form method="post">
                                              <button type="submit" class="btn btn-default" name="cancel" value= %s>Cancel</button>
                                           </form>
                                           <p>Status: Claimed</p>
                                        </div>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major,$firstName, $surname, $claimentEmail,  $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID);
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
                                        <h4 class="modal-title">Title: %s</h4>
                                    </div>
                                    <div class="modal-footer">
                                    <form role="form">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
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
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <embed src= %s width="200px" height="500px" />
                                        </br>
                                        <a href=%s download=%s>Download Preview</a>
                                        </br>

                                        <div class="btn-bottom-modals">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="delete" value= %s>Delete</button>
                                           <button type="submit" class="btn btn-default" name="reupload" value= %s>Re-Upload</button>
                                        </form>
                                        <p>Status: Expired</p>
                                        </div>
                                      </div>
                                      </form>
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
                                        <h4 class="modal-title">Title: %s</h4>
                                    </div>
                                    <div class="modal-footer">
                                    <form role="form">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
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
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <embed src= %s width="200px" height="500px" />
                                        </br>
                                        <a href=%s download=%s>Download Preview</a>
                                        </br>

                                    <div class="btn-bottom-modals">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="delete" value= %s>Delete</button>
                                           <button type="submit" class="btn btn-default" name="reupload" value= %s>Re-Upload</button>
                                        </form>
                                        <p>Status: Cancelled by Claiment</p>
                                        </div>
                                      </div>
                                      </form>
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
                //catches an error if there is an issue connecting to the database
                printf("Connection error: %s", $exception->getMessage());
          }

          //if the user decides to cancel a task then the following queries are ran
          if(isset($_POST['cancel'])){
            $taskID = $_POST['cancel'];
            //this query updates the status of the cancelled task
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 6 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
          }
          //if the user decides to delete a task then the following queries are ran
          else if(isset($_POST['delete'])){
            $taskID = $_POST['delete'];

            //deleteing tasks created by the deleted user that have not being claimed yet
            $stmt = $dbh->prepare("DELETE FROM tasks JOIN task_status USING(task_Id) WHERE username = ? AND status_ID = 1");
	        $stmt->execute(array($username));

            //updating database so the status of any tasks the deleted user has claimed will be changed to 'Cancelled by Claiment"
            $stmt = $dbh->prepare("UPDATE task_status JOIN claimed_tasks USING(task_Id) SET status_Id = 4 WHERE claimed_tasks.username = ?" );
            $stmt->execute(array($username));


            //updating database so the status of any tasks the deleted user has uploaded that has been claimed will be changed to 'Cancelled by Uploader"
            $stmt = $dbh->prepare("UPDATE task_status JOIN tasks USING(task_Id) SET status_Id = 6 WHERE tasks.username = ? AND status_Id = 2" );
	        $stmt->execute(array($username));

            //deleting information on tags associated to this task
            $stmt = $dbh->prepare("DELETE FROM assigned_tags WHERE task_Id = ?");
            $stmt->execute(array($taskID));
          }
          //if the user rates the task feedback as good then the following queries are ran
          else if(isset($_POST['good'])){
            $taskID = $_POST['good'];
            //adding 5 points to the users score
			$stmt = $dbh->prepare("UPDATE user_info SET points = points + 5 WHERE username = (SELECT username FROM claimed_tasks WHERE taskID = ?)");
			$stmt->execute(array($taskID));
          }
          //if the user rates the task feedback as ok then the following queries are ran
          else if(isset($_POST['middle'])){
            $taskID = $_POST['middle'];
            //adding 2 points to the users score
            $stmt = $dbh->prepare("UPDATE user_info SET points = points + 2 WHERE username = (SELECT username FROM claimed_tasks WHERE taskID = ?)");
			$stmt->execute(array($taskID));
          }
          //if the user rates the task feedback as bad then the following queries are ran
          else if(isset($_POST['bad'])){
            $taskID = $_POST['bad'];
            //taking away five points from the users score
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
      //**This is the php code for creating a task **
        //checking if the form has been submitted
        if (isset($_POST['createTaskSubmit'])) {
           //retriving values submitted through the form
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

           //getting the username from the session variable
           $username = $_SESSION['username'];

           //creating a boolean that will turn to true when the task can be created
           $createTask = true;

           //code taken from https://davidwalsh.name/basic-file-uploading-php and referenced in write-up

           //setting the target directory folder
           $targetDirectory = "FileUploads/";
           //getting the file name
           $target_file = $targetDirectory.basename($_FILES["fileUpload"]["name"]);
           //getting the file extension from the file upload
           $fileType = ".".strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


           //checking if the file exists
           if($_FILES['fileUpload']['name']){
             //checking if there are no errors
             if(!$_FILES['fileUpload']['error']){
                 //checking if the file was uploaded
                 if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
                     //checking if the file types match
                     if(strcasecmp($fileFormat, $fileType) != 0){
                         print("<h2>File Types must match!</h2>");
                         $createTask = false;
                     }
                  }
              }else{
                 //printing error if there was a problem with the file upload
                 print("<h2>Error with upload!</h2>");
                 $createTask = false;
              }
            }else{
              //printin error if they have not uploaded a file
              print("<h2>No file uploaded!</h2>");
              $createTask = false;
            }
          //if all the pre requisits for task creation have been met then we can add it to the database
          if($createTask){
           try{
             //connecting to the database
	         $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");

             //query to insert new task into the database
             $stmt = $dbh->prepare("INSERT INTO tasks VALUES(:username, NULL, :title, :type, :pageNum, :wordCount, :fileFormat, :description, :claimDeadline, :submissionDeadline, 0, :major)");
             $affectedRows = $stmt->execute(array(':username' => $username, ':title' => $title, ':type' => $type, ':pageNum' => $pageNum, ':wordCount' => $wordNum, ':fileFormat' => $fileFormat, ':description' => $description, ':claimDeadline' => $claimDeadline, ':submissionDeadline' => $submissionDeadline, ':major' => $major));

             //getting the task id of the new task
             $query = "SELECT task_Id FROM tasks WHERE username = :username AND title = :title";
             $stmt = $dbh->prepare($query);
             $stmt->execute(array(':username' => $username, ':title' => $title));
             $taskID = $stmt->fetchColumn(0);

             //inserting into the task status table the new task id and its status
             $stmt = $dbh->prepare("INSERT INTO task_status VALUES (?, 1)");
             $stmt->execute(array($taskID));

             //using taskID to name uploaded file
             $newFileName = $taskID;
             move_uploaded_file($_FILES['fileUpload']['tmp_name'], $targetDirectory.$newFileName.$fileType);

             //inserting tags loop
             foreach($tagArray as $tag){
                //trimming and checking if the tag contains and html tags
                $tag = htmlspecialchars(trim($tag));

                //checking if this tag is already in the tags that have been inserted into the database
                $stmt = $dbh->prepare("SELECT COUNT(*) FROM tag_ids WHERE tag_Name = ?" );
                $stmt->execute(array($tag));

                //if the count returns 0 - the topic is not already in the database
                if($stmt->fetchColumn(0) == 0 ){
                   //inserting the topic into the database
                   $stmt = $dbh->prepare("INSERT INTO tag_ids (tag_Name, tag_Id) VALUES (?, NULL)");
                   $stmt->execute(array($tag));
                }
                //retriving the tag id of the topic the user has entered
                $stmt = $dbh->prepare("SELECT tag_Id FROM tag_ids WHERE tag_Name = ?");
                $stmt->execute(array($tag));
                $tagID = $stmt->fetchColumn(0);

                //inserting this tag id into the table that holds the tags that the user has been associated with
                $stmt = $dbh->prepare("INSERT INTO user_tags VALUES (:tagID, :username)");
                $affectedRows = $stmt->execute(array(':tagID' => $tagID, ':username' => $username));

                //checking that the tags have been entered
                if($affectedRows == 0){
                    printf("<h2>ERROR</h2>");
                }else{
                    //header("Refresh:0");
                    //need a way to refresh the page so that the new task will appear in my tasks straight away
                }

                //inserting the tag ids into a table with their related task id
                $stmt = $dbh->prepare("INSERT INTO assigned_tags VALUES(:taskID, :tagID)");
                $stmt->execute(array('taskID' => $taskID, ':tagID' => $tagID));
             }
           }catch(PDOException $exception){
              //catching an issue connecting the database
              print("<h2> Uh Oh1</h2>");
           }
        }else{
           //issue with creating task
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
            <option>Business</option>
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
                      <input type="date" value="2017-05-23" class="form-control" name="claimDeadline" id='datetimepicker1' ></input>
                  </div>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
               <label for="re-password">Completion deadline</label>
                  <div>
                     <input type="date" value="2017-05-23" class="form-control" name="submissionDeadline" id='datetimepicker2' ></input>
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
        //**This is the php for the claimed tasks stream**

        try {
            //connecting to the database
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");

            //this counter is used to distinguish between tasks so the pop ups that
            //appear when a task is clicked on will be associated with the correct task
		    $counter = 0;

            //retriving the username from the session variable
            $username = $_SESSION['username'];

            //this query returns all of the information recquired for each task
            $stmt = $dbh->prepare("SELECT task_Id, status_Id, title, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline , major FROM tasks JOIN task_status USING(task_Id) JOIN claimed_tasks USING(task_Id) WHERE claimed_tasks.username = ? ORDER BY submission_deadline ASC");
            $stmt->execute(array($username));

            //checking if any rows were returned
            if($stmt->rowCount() == 0){
                //displaying this message if the user has not claimed any tasks
                printf("<h2 class='description-of-page'> You have not claimed any tasks. </h2>", $username);
            }else{

                //this while loop retrives all of the information for each task and dispalys
                //them individually with their own pop up box when clicked on
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                //retriving all of the information form the query rows
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

                //these variables are used as unique identifiers for each task button and task pop up
                $targetIdentifier = "#myModelClaimed";
                $target = "myModelClaimed";
                $buttonIdentifier = "button";
                $buttonID = $buttonIdentifier.$counter;
                $targetID  = $targetIdentifier.$counter;
                $target = $target.$counter;

                //these variables reformat the date so that it is easier to read for the user
                $ClaimDateFormat = explode("-", $claimDeadline);
                $SubmissionDateFormat = explode("-", $submissionDeadline);
                $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];

                //tag array for the tags associated with each task
                $tags[0] = "";
                $tags[1] = "";
                $tags[2] = "";
                $tags[3] = "";

                //variable to keep count of how many tags are retrived
                $tagCounter = 0;

                //query returning the tags linked to each task
                $stmt2 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                $stmt2->execute(array($taskID));

                //this while loop appends some of the tags with a comma so they look better when being displayed
                while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                       if($tagCounter < 3){
                          $tags[$tagCounter] = $row2['tag_Name'].",";
                       }else{
                          $tags[$tagCounter] = $row2['tag_Name'];
                       }
                       $tagCounter++;
                   }
                /*This switch works off the status id's that are as follows
                * 2 - Claimed ( awaiting completion)
                * 3 - Expired
                * 5 - Completed
                * The switch will then print out and display all of the tasks and the pop up windows when the tasks are clicked on
                */
                switch($status){
                    case "2":
                       printf('<button type= %s class="btn btn-MyTasksClaimed btn-lg"
                       data-target= %s data-toggle="modal"><b>Title:</b></br> %s</br> <b>Status:</b></br> Claimed </br> <b>Deadline:</b> </br>%s</button>
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
                             </div> <!-- finish modal -->', $buttonID, $targetID, $title, $submissionDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $taskID, $taskID);
                    break;

                    case"3":
                        printf('<button type= %s class="btn btn-MyTasksExpired btn-lg" data-toggle="modal"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Expired </br> <b>Deadline:</b> </br>%s</button>

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
                                           <h2> The deadline to submit this task has passed.</h2>
                                           <h2> You have been penalised for this.<h2>
                                       </div>
                                       <div class="modal-footer">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="expired" value= %s>Ok</button>
                                        </form>
                                        <p>Status: Expired</p>
                                    </div>
                                    </div>
                                  </div>
                               </div> <!-- finish modal -->', $buttonID, $targetID, $title, $submissionDeadline, $target, $buttonID, $title, $taskID);
                    break;

                    case"6":
                          printf('<button type= %s class="btn btn-MyTasksCancelled btn-lg"
                        data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Cancelled </br> <b>Deadline:</b> </br>%s</button>

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
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $submissionDeadline, $target, $buttonID, $title, $taskID);
                    break;
                }
                $counter++;
             }
          }
        }catch(PDOException $exception){
            printf("Connection error: %s", $exception->getMessage());
        }

       //these queries are ran if the user cancels a task they've claimed
       if(isset($_POST['cancel'])){
            $taskID = $_POST['cancel'];
            //deletes the task from claimed tasks
            $stmt = $dbh->prepare("DELETE FROM claimed_tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            //updates the task status to "Cancelled by claiment"
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 4 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            //deducts 15 points form the user
			$stmt = $dbh->prepare("UPDATE user_info SET points = points - 15 WHERE username = ?");
			$stmt->execute(array($username));
       }
        //these queries are ran if the user completes a task they've claimed
        else if(isset($_POST['complete'])){
            $taskID = $_POST['complete'];
            //updates the status of the task to completed
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 5 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
       }
        //these queries are ran if the user acknowledges a task they've claimed has been cancelled by the uploader
        else if(isset($_POST['acknowledge'])){
            $taskID = $_POST['acknowledge'];
            //deletes the task from claimed tasks
            $stmt = $dbh->prepare("DELETE FROM claimed_tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            //deletes the task
            $stmt = $dbh->prepare("DELETE FROM tasks WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            //deletes the task from the task status table
            $stmt = $dbh->prepare("DELETE FROM task_status WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            //deletes the tag information on the tags that were associated to the task
            $stmt = $dbh->prepare("DELETE FROM assigned_tags WHERE task_Id = ?");
            $stmt->execute(array($taskID));
       }
       //these queries will run if a task the user has claimed is now expired
       else if(isset($_POST['expired'])){
            $taskID = $_POST['expired'];
            //changing the status of the task to "Cancelled by Claiment"
            $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 4 WHERE task_Id = ?");
            $stmt->execute(array($taskID));
            //penalising the claiment for not submitting the task in time
            $stmt = $dbh->prepare("UPDATE user_info SET points = points - 30 WHERE username = ?");
			$stmt->execute(array($username));
            
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
      <?php
        //**This is the php code for the "Available Tasks" stream**
        try {
            //connecting to the database
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");

            //this counter is used to distinguish between tasks so the pop ups that
            //appear when a task is clicked on will be associated with the correct task
		    $counter = 0;

            //this query returns all of the information recquired for each task
            $stmt = $dbh->prepare("SELECT DISTINCT(task_Id), title, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline ,major FROM tasks JOIN task_status USING(task_Id) JOIN assigned_tags USING(task_Id) JOIN user_tags USING(tag_Id) WHERE tasks.username != :username1 AND status_Id = 1 AND user_tags.username = :username2 AND flagged_count = 0 ORDER BY claim_deadline ASC");
            $stmt->execute(array(':username1' => $username, ':username2' => $username));

            //this while loop retrives all of the information for each task and dispalys
            //them individually with their own pop up box when clicked on
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //retriving all of the information form the query rows
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

                //these variables are used as unique identifiers for each task button and task pop up
                $targetIdentifier = "#myModelAvailable";
                $target = "myModelAvailable";
                $buttonIdentifier = "button";
                $buttonID = $buttonIdentifier.$counter;
                $targetID  = $targetIdentifier.$counter;
                $target = $target.$counter;
                $relatedFile = "FileUploads/".$taskID.$fileFormat;

                //these variables reformat the date so that it is easier to read for the user
                $ClaimDateFormat = explode("-", $claimDeadline);
                $SubmissionDateFormat = explode("-", $submissionDeadline);
                $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];

                //tag array for the tags associated with each task
                $tags[0] = "";
                $tags[1] = "";
                $tags[2] = "";
                $tags[3] = "";

                //variable to keep count of how many tags are retrived
                $tagCounter = 0;

                //query returning the tags linked to each task
                $stmt3 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                $stmt3->execute(array($taskID));

                //this while loop appends some of the tags with a comma so they look better when being displayed
                while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                       if($tagCounter < 3){
                          $tags[$tagCounter] = $row2['tag_Name'].",";
                       }else{
                          $tags[$tagCounter] = $row2['tag_Name'];
                       }
                       $tagCounter++;
                   }

                //This printf prints out all of the task buttons and the opo up windows once they are clicked on
                printf('<button type= %s class="btn btn-MyTasksAvailable btn-lg" data-toggle="modal"
                data-target= %s><b>Title:</b></br> %s</br> <b>Status:</b></br> Available </br> <b>Date:</b> </br>%s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type= %s class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Title: %s</h4>
                                    </div>
                                    <div class="modal-footer">
                                    <form role="form">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
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

                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <embed src= %s width="200px" height="360px" />
                                        </br>

                                        <a href=%s download=%s>Download Preview</a>
                                        </br>

                                    <div class="btn-bottom-modals">
                                        <form method="post">
                                            <button type="submit" class="btn btn-default" name="claim" value="%s">Claim</button>
                                            <button type="submit" class="btn btn-default" name="flag" value="%s">Flag</button>
                                        </form>
                                        <p>Status: Available</p>
                                        </div>
                                      </div>
                                      </form>
                                      </div>
                                  </div>
                              </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $claimDeadline, $target, $buttonID, $title, $type, $major, $tags[0],  $tags[1], $tags[2], $tags[3], $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $relatedFile, $relatedFile, $title, $taskID, $taskID);
                $counter++;
            }
        }catch(PDOException $exception){
             printf("Connection error: %s", $exception->getMessage());
        }

        //these queries are ran if a user decides to claim a task
        if(isset($_POST['claim'])){
           $taskID = $_POST['claim'];
           //updates the task status of the task
           $stmt = $dbh->prepare("UPDATE task_status SET status_Id = 2 WHERE task_Id = ?");
           $stmt->execute(array($taskID));

           //inserts the task id into the claimed tasks table
           $stmt = $dbh->prepare("INSERT INTO claimed_tasks VALUES(:taskID, CURRENT_TIMESTAMP, :username)");
           $stmt->execute(array(':taskID' => $taskID, ':username' => $username));

           //gives the user 10 points for claiming a task
		   $stmt = $dbh->prepare("UPDATE user_info SET points = points + 10 WHERE username = ?");
		   $stmt->execute(array($username));
        }
         //these queries are ran if a user decides to flag a task
         else if(isset($_POST['flag'])){
           $taskID = $_POST['flag'];

           //incremnting the flagged count
           $stmt = $dbh->prepare("UPDATE tasks SET flagged_count = flagged_count + 1 WHERE task_Id = ?");
           $stmt->execute(array($taskID));
           //give the user 2 points for flagging a task
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
