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
     <?php
        //starting a session and checking if a user is logged in and is a moderator
        //if a user isnt logged in or they are not a moderator then they are redirected to the log in page
        session_start();
        if (!isset($_SESSION['username']) && $_SESSION['moderator'] != 1) {
			header("Location:./logIn.php");
        }
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
        <a href="homePage.php" target="_self"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
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

      <!--ask cynthia about this -->
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#LogOut">My rating</a></li>

           <ul class="nav navbar-nav navbar-right">
            <li><a href="#LogOut">Log out</a></li>

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>

  <!-- Available tasks -->
  <div class="container" id="availableTasks">
    <div class="panel panel-info">
      <div class="panel-heading"><h2>Flagged Tasks</h2></div>

     <!-- Panel body -->
      <div class="panel-body">
          <script src="js/functions.js"></script>
          <script src="js/jquery.js"></script>
          <script src="js/bootstrap.min.js"></script>
       <?php

          try {
            //connecting to the database
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");

            //creating a variable to keep count of how many tasks are going to be displayed
            //this variable is used to trigger the relevant pop up to display the task information for each task
		    $counter = 0;

            //querying the database to return all relevant information for flagged tasks
            $stmt = $dbh->query("SELECT task_Id, title, flagged_count, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline FROM tasks JOIN task_status USING(task_Id) WHERE flagged_count > 0 AND status_Id <> 6 ORDER BY flagged_count ASC");

            //this while loop with go through the resulting rows and create the boxes and pop windows for each task
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                //variables used to display the task information
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

                //these variables are used to distinguish between each task so the
                //pop up that appears is related to the task that is clicked on
                $targetIdentifier = "#myModelFlagged";
                $target = "myModelFlagged";
                $buttonIdentifier = "buttonFlagged";
                $buttonID = $buttonIdentifier.$counter;
                $targetID  = $targetIdentifier.$counter;
                $target = $target.$counter;

                //these variables reformat the dates that are being stored in the databse so they are more readable for the user
                $ClaimDateFormat = explode("-", $claimDeadline);
                $SubmissionDateFormat = explode("-", $submissionDeadline);
                $claimDeadline = $ClaimDateFormat[2]."/".$ClaimDateFormat[1]."/".$ClaimDateFormat[0];
                $submissionDeadline = $SubmissionDateFormat[2]."/".$SubmissionDateFormat[1]."/".$SubmissionDateFormat[0];

                //variables to store tags being retrived in the following query
                $tags[0] = "";
                $tags[1] = "";
                $tags[2] = "";
                $tags[3] = "";

                //a variable to keep count of how many tags are goin to be displayed
                $tagCounter = 0;

                //query to get the tags that are associated with the task being displayed
                $stmt2 = $dbh->prepare("SELECT tag_Name FROM tag_ids JOIN assigned_tags USING(tag_Id) WHERE task_Id = ?");
                $stmt2->execute(array($taskID));

                //populating the tag array and appending them with a comma except
                //the last one so the appear more naturally in the pop up
                while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                   if($tagCounter < 3){
                      $tags[$tagCounter] = $row2['tag_Name'].",";
                   }else{
                      $tags[$tagCounter] = $row2['tag_Name'];
                   }
                      $tagCounter++;
                }

                //this printf will print out the html code to display each task
                printf('<button type= %s class="btn btn-MyTasksAvailable btn-lg" data-toggle="modal" data-target= %s >Title: %s</br> No. of Flags: %s </br> Date: %s</button>

                        <!-- Modal -->
                        <div class="modal fade" id= %s role="dialog">
                            <div class="modal-dialog">
                            <!-- ID has to be = to data-target, also unique -->
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
                                    <div class="modal-footer">
                                        <form method="post">
                                           <button type="submit" class="btn btn-default" name="delete" value="%s">Delete Task</button>
                                           <button type="submit" class="btn btn-default" name="unflag" value="%s">Unflag</button>
                                           <button type="submit" class="btn btn-default" name="ban" value="%s">Ban User</button>
                                        </form>
                                        <p>Status: Flagged</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $flagCount, $claimDeadline, $target, $buttonID, $title, $type, $tags[0], $tags[1], $tags[2], $tags[3],$pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $taskID, $taskID, $taskID);

                //incrementing the counter that us used to distinguish between each task being outputted
                $counter++;
            }
        }catch(PDOException $exception){
              //catching any errors in connecting to the database
             printf("Connection error: %s", $exception->getMessage());
        }

        //these queries will run if the moderator has decided to delete the task
        if(isset($_POST['delete'])){
           //the task id for the relevant task is stored in the button that is used
           $taskID = $_POST['delete'];
           //getting the status of the task being deleted
            $stmt3 = $dbh->prepare("SELECT status_Id FROM task_status WHERE task_Id = ?");
            $stmt3->execute(array($taskID));
            $row = $stmt3->fetch(PDO::FETCH_ASSOC);
            $status = $row['Status_Id'];
            
            //checking if the task has been claimed yet
            if($status == 1){
               //deleteing tasks created by the user that have not being claimed yet
               $stmt = $dbh->prepare("DELETE tasks FROM tasks JOIN task_status USING(task_Id) WHERE tasks.username = :username AND task_status.status_Id = 1 AND tasks.task_Id = :taskID");
	           $stmt->execute(array(':username' => $username, ':taskID' => $taskID));
              
              //deleting information on tags associated to this task
              $stmt = $dbh->prepare("DELETE FROM task_status WHERE task_Id = ?");
              $stmt->execute(array($taskID));
            }

            //updating database so the status of any tasks the deleted user has uploaded that has been claimed will be changed to 'Cancelled by Uploader"
            $stmt = $dbh->prepare("UPDATE task_status JOIN tasks USING(task_Id) SET status_Id = 6 WHERE tasks.username = ? AND status_Id = 2" );
	        $stmt->execute(array($username));

            //deleting information on tags associated to this task
            $stmt = $dbh->prepare("DELETE FROM assigned_tags WHERE task_Id = ?");
            $stmt->execute(array($taskID));
           //penalising the user for creating a task the moderator had to delete
           $stmt = $dbh->prepare("UPDATE user_info SET points = points - 15 WHERE username = (SELECT username FROM claimed_tasks WHERE task_Id = ?)");
           $stmt->execute(array($taskID));
        }
          //this query will run if the moderator has decided to unflag the task
          else if(isset($_POST['unflag'])){
           //the task id for the relevant task is stored in the button that is used
           $taskID = $_POST['unflag'];
           //resetting the flag count for this task
           $stmt = $dbh->prepare("UPDATE tasks SET flagged_count = 0 WHERE task_Id = ?");
           $stmt->execute(array($taskID));
        }else if(isset($_POST['ban'])){
           //the task id for the relevant task is stored in the button that is used
           $taskID = $_POST['ban'];
           //getting the username of the user to be banned
           $stmt = $dbh->prepare("SELECT username FROM tasks WHERE task_Id = ?");
           $stmt->execute(array($taskID));
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           $banUsername = $row['username'];         
           //inserting that user into the banned user table
           $stmt = $dbh->prepare("INSERT INTO banned_user VALUES (?, CURRENT_TIMESTAMP)");
           $stmt->execute(array($banUsername));
            
           //updating database so the status of any tasks the deleted user has uploaded that has been claimed will be changed to 'Cancelled by Uploader" - the status can be changed whenthe user becomes un banned
           $stmt = $dbh->prepare("UPDATE task_status JOIN tasks USING(task_Id) SET status_Id = 6 WHERE tasks.username = ?" );
	       $stmt->execute(array($username));
        }
?>


      </div> <!-- panel-body -->
    </div> <!-- panel panel-default -->
  </div> <!-- container -->
</div>
</body>
</html>
