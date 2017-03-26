<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400,700|Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="styles/ihover.css" rel="stylesheet">
  <title>UL Review</title>
</head>
<body id="body">
     <?php 
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
        <a href="indexULReview.html" target="_self"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;"></a>
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

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#LogOut">My rating</a></li>

        <!-- My rating button-->
          <!-- <div class="navbar-form navbar-left">
             <div class="form-group">
               <button type="button" class="btn btn-default">
                 <span class="glyphicon glyphicon-star" aria-hidden="true"></span> My rating
               </button>
             </div>
           </div> --> <!-- My rating -->

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
       <?php try {
            $dbh = new PDO("mysql:host=localhost;dbname=Project", "root", "");
		    $counter = 0;
            
            $stmt = $dbh->query("SELECT task_Id, title, flagged_count, type, page_no, word_Count, file_format, description, claim_deadline, submission_deadline FROM tasks WHERE flagged_count > 0 order by flagged_count ASC");
        
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
                $targetIdentifier = "#myModelAvailable";
                $target = "myModelAvailable";
                $buttonIdentifier = "buttonAvailable";
                $buttonID = $buttonIdentifier.$counter;
                $targetID  = $targetIdentifier.$counter;               
                $target = $target.$counter;
                
                //going to need to do some funny stuff to display tags
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
                                            Tags: need to work on this
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
                                           <button type="submit" class="btn btn-default" name="delete" value="%s">Delete</button>
                                           <button type="submit" class="btn btn-default" name="unflag" value="%s">Unflag</button>
                                        </form>
                                        <p>Status: Flagged</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- finish modal -->', $buttonID, $targetID, $title, $flagCount, $claimDeadline, $target, $buttonID, $title, $type, $pageNo, $wordCount, $fileFormat, $description, $claimDeadline, $submissionDeadline, $taskID, $taskID);
                $counter++;
            }
        }catch(PDOException $exception){
             printf("Connection error: %s", $exception->getMessage());       
        }
        
        if(isset($_POST['delete'])){
           $val = $_POST['delete'];
           $stmt = $dbh->prepare("DELETE FROM tasks WHERE task_Id = ?");
           $stmt->execute(array($val));
           $stmt = $dbh->prepare("DELETE FROM task_status WHERE task_Id = ?");
           $stmt->execute(array($val));
           $stmt = $dbh->prepare("DELETE FROM assigned_tags WHERE task_Id = ?");
           $stmt->execute(array($val));
        }else if(isset($_POST['unflag'])){
           $val = $_POST['unflag'];
           $stmt = $dbh->prepare("UPDATE tasks SET flagged_count = 0 WHERE task_Id = ?");
           $stmt->execute(array($val));
        }
?>


      </div> <!-- panel-body -->
    </div> <!-- panel panel-default -->
  </div> <!-- container -->
</div>
</body>
</html>