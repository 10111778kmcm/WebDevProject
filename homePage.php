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

  <!-- Nav Bar -->
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
        <a href="#body"><img src="images/ULlogo-azul.png" alt="UL Review logo" style="width: 182px; height: 50px;""></a>
        <!-- <a class="navbar-brand" href="#">UL Review</a> -->
      </div>

      <ul class="nav navbar-nav navbar-right">
       <ul class="nav navbar-nav btn-FlaggedTasks">
         <li><a href="flaggedTasks.html" target="_blank">Flagged Tasks</a></li>
       </ul>

       <!--   Dropdown Tasks -->
       <li class="dropdown btn-stickyNav">
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

      <!--     Search bar
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form> -->

      <!--   Dropdown Languages -->
      <li class="dropdown btn-stickyNav">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Español</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Deutsche</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Gaeilge</a></li>
        </ul>
      </li>

      <ul class="nav navbar-nav btn-stickyNav">
        <li><a href="#LogOut">My rating</a></li>
      </ul>

      <ul class="nav navbar-nav btn-stickyNav">
        <li><a href="#LogOut">Log out</a></li>
      </ul>

    </ul>
  </div><!-- /.container -->
</nav>

<!-- Welcome panel -->
<div class="container">
  <!-- Tasks Bottons -->
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="index col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-xl-6 col-xl-offset-3">
        <h1>Welcome!</h1>
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


<!-- My tasks -->
<div class="container" id="myTasks">
  <div class="panel panel-info">
    <div class="panel-heading"><h2>My Tasks</h2></div>
    <div class="panel-body">
      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-MyTasksPending btn-lg" data-toggle="modal" data-target="#myModal">Title: Abortion essay </br> Status: Pending </br> Date: 20/03/17</button>

      <!-- Modal ONE -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title title">Title: Abortion essay</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: essay
              </div>
              <div class="tags">
                Tags: Abortion, Health & Science
              </div>
              <div class="no-of-pages">
                No of pages: 5
              </div>
              <div class="no-of-words">
                No of word: 530
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: Abortion essay
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 15/05/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Pending</p>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->


      <!-- Other TWO-->

      <button type="button1" class="btn btn-MyTasksExpired btn-lg" data-toggle="modal" data-target="#myModal1">Title: Irish Essay </br> Status: Expired </br> Date: 20/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button1" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title: Irish Essay</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: Essay
              </div>
              <div class="tags">
                Tags: essay, Irish history, Literature
              </div>
              <div class="no-of-pages">
                No of pages: 5
              </div>
              <div class="no-of-words">
                No of word:2000
              </div>
              <div class="file-Format">
                File Format: pdf
              </div>
              <div class="description">
                Description: This is an essay about irish history from 1800 to 1900.
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 15/04/17
              </div>
              <div class="completion-deadline">
                Completion Deadline:21/04/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Completed</p>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->

      <!-- Other THREE-->

      <button type="button3" class="btn btn-MyTasksClaimed btn-lg" data-toggle="modal" data-target="#myModal3">Title: Chemistry notes </br> Status: Claimed </br> Date: 04/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button3" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title: Chemistry notes</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: notes
              </div>
              <div class="tags">
                Tags: notes, chemistry, organic chemistry
              </div>
              <div class="no-of-pages">
                No of pages: 2
              </div>
              <div class="no-of-words">
                No of word:500
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: My notes from Chemistry class
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 01/04/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 4/04/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Claimed</p>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->

      <!-- Other FOUR-->

      <button type="button4" class="btn btn-MyTasksCancelled btn-lg" data-toggle="modal" data-target="#myModal4">Title: Chinese poem </br> Status: Cancelled </br> Date: 20/03/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModal4" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button4" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title: Chinese poem</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: poem
              </div>
              <div class="tags">
                Tags: China, poem, literature
              </div>
              <div class="no-of-pages">
                No of pages: 1
              </div>
              <div class="no-of-words">
                No of word:50
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: Chinese Poem
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 15/05/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Cancelled</p>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->

      <!-- Other FIVE-->

      <button type="button5" class="btn btn-MyTasksCompleted btn-lg" data-toggle="modal" data-target="#myModal5">Title:FYP Dance as a </br>human expression </br> Status: Complete </br> Date: 20/01/17</button>
      <!-- data-target has to be unique for each -->
      <!-- Button type has to be unique -->

      <!-- Modal -->
      <div class="modal fade" id="myModal5" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button5" class="close" data-dismiss="modal">&times;</button>
              <!-- Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title: FYP Dance as a human expression</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: FYP
              </div>
              <div class="tags">
                Tags: Dance, contemporary dance,
              </div>
              <div class="no-of-pages">
                No of pages: 50
              </div>
              <div class="no-of-words">
                No of word:2516
              </div>
              <div class="file-Format">
                File Format: pdf
              </div>
              <div class="description">
                Description: FYP dance as a human expression
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 15/05/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Complete</p>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->



    </div> <!-- panel-body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->

<!-- Create task -->
<div class="container" id="createTask">
  <div class="panel panel-info">
    <div class="panel-heading"><h2>Create Task</h2></div>
    <div class="panel-body">
      <h4>Create a task to get a peer to review it.</h4>
    </br>
    <form>
      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="title">Title</label>
        <input class=" form-control" type="text" id="title" placeholder="World War II">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="type">Type</label>
        <input class=" form-control" type="text" id="Type" placeholder="FYP, essay, notes">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="Tags">Tags</label>
        <input class=" form-control" data-role="tagsinput" type="text" id="Tags" placeholder="Amsterdam,Washington,Sydney,Beijing,Cairo">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="no-of-pages">No of pages</label>
        <input class=" form-control" type="number" id="No-of-pages" minlength="1" maxlength="50" placeholder="20">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="no-of-words">No of words</label>
        <input class=" form-control" type="number" id="No-of-words" minlength="100" maxlength="15000" placeholder="12456">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="file-Format">File Format</label>
        <select class="form-control" id="sel2">
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
        <input class=" form-control" type="text" maxlength="500" id="Description" placeholder="Max 100 words">
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="claimed-deadline">Claimed deadline</label>
        <div>
          <img src="images/calendar.png" alt="calendar">
        </div>
      </div>

      <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <label for="completion- deadline">Completion deadline</label>
        <div>
          <img src="images/calendar.png" alt="calendar">
        </div>
      </div>

      <br>
      <button class="btn btn-primary center-block">Create</button>
      <br>
      <br>
    </form>
  </div> <!-- panel-body -->
</div> <!-- panel panel-default -->
</div> <!-- container -->

<!-- Claimed tasks -->
<div class="container" id="claimedTasks">
  <div class="panel panel-info">
    <div class="panel-heading"><h2>Claimed Tasks</h2></div>
    <div class="panel-body">
      <!-- Trigger the modal with a button -->
      <button type="button" class="btn btn-MyTasksCompleted btn-lg" data-toggle="modal" data-target="#myModalClaimed">Title: FYP Dance as a <br>human expression </br> Status: Completed </br> Date: 20/03/17</button>

      <!-- Modal ONE -->
      <div class="modal fade" id="myModalClaimed" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title title">Title: FYP Dance as a human expression</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: FYP
              </div>
              <div class="tags">
                Tags: Dance, contemporary dance,
              </div>
              <div class="no-of-pages">
                No of pages: 50
              </div>
              <div class="no-of-words">
                No of word:2516
              </div>
              <div class="file-Format">
                File Format: pdf
              </div>
              <div class="description">
                Description: FYP dance as a human expression
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 15/05/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Complete</p>
              <button type="button" class="btn btn-default" data-dismiss="modal">Remove</button>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->


      <!-- Other TWO-->

      <button type="button1" class="btn btn-MyTasksExpired btn-lg" data-toggle="modal" data-target="#myModalClaimed1">Title:Chinese poem  </br> Status: Expired </br> Date: 20/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModalClaimed1" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button1" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title:Chinese poem </h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: poem
              </div>
              <div class="tags">
                Tags: China, poem, literature
              </div>
              <div class="no-of-pages">
                No of pages: 1
              </div>
              <div class="no-of-words">
                No of word:50
              </div>
              <div class="file-Format">
                File Format: pdf
              </div>
              <div class="description">
                Description: Chinese Poem
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 15/05/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Expired</p>
              <button type="button" class="btn btn-default" data-dismiss="modal">Re- upload</button>
            </div>
          </div>

        </div>
      </div> <!-- finish modal -->

      <!-- Other THREE-->

      <button type="button3" class="btn btn-MyTasksClaimed btn-lg" data-toggle="modal" data-target="#myModalClaimed3">Title:Chemistry notes</br> Status: Claimed </br> Date: 20/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModalClaimed3" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button3" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title:Chemistry notes</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: notes
              </div>
              <div class="tags">
                Tags: notes, chemistry, organic chemistry
              </div>
              <div class="no-of-pages">
                No of pages: 2
              </div>
              <div class="no-of-words">
                No of word:50
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: My notes from Chemistry class
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 01/04/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <p>Status: Claimed</p>
            </div>
          </div>
        </div>
      </div> <!-- finish modal -->

    </div> <!-- panel-body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->

<!-- Available tasks -->
<div class="container" id="availableTasks">
  <div class="panel panel-info">
    <div class="panel-heading"><h2>Available Tasks</h2></div>

    <!-- Panel body -->
    <div class="panel-body">
      <!-- Modal ONE -->
      <button type="button1" class="btn btn-MyTasksAvailable btn-lg" data-toggle="modal" data-target="#myModalAvailable">Title: Computing notes</br> Status: Available </br> Date: 20/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModalAvailable" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button1" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title:Computing notes</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: notes
              </div>
              <div class="tags">
                Tags: CSIS, Java, computing
              </div>
              <div class="no-of-pages">
                No of pages: 5
              </div>
              <div class="no-of-words">
                No of word:150
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: My notes from java lecture
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 01/04/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Claim</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Flag</button>
              <p>Status: Available</p>
            </div>
          </div>
        </div>
      </div> <!-- finish modal -->


      <!-- Other TWO-->

      <button type="button1" class="btn btn-MyTasksAvailable btn-lg" data-toggle="modal" data-target="#myModalAvailable1">Title: FYP Engineering <br> processes </br> Status: Available </br> Date: 20/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModalAvailable1" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button1" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title: FYP Engineering processes</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: FYP
              </div>
              <div class="tags">
                Tags: Engineering, civil engineering
              </div>
              <div class="no-of-pages">
                No of pages: 25
              </div>
              <div class="no-of-words">
                No of word:1526
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: FYP Engineering
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 01/04/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Claim</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Flag</button>
              <p>Status: Available</p>
            </div>
          </div>
        </div>
      </div> <!-- finish modal -->

      <!-- Other THREE-->

      <button type="button3" class="btn btn-MyTasksAvailable btn-lg" data-toggle="modal" data-target="#myModalAvailable3">Title: Volunteering side <br>effects</br> Status: Available </br> Date: 20/01/17</button>
      <!-- Button type has to be unique -->
      <!-- data-target has to be unique for each -->

      <!-- Modal -->
      <div class="modal fade" id="myModalAvailable3" role="dialog">
        <div class="modal-dialog">
          <!-- ID has to be = to data-target, also unique -->

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button3" class="close" data-dismiss="modal">&times;</button>
              <!--        Button type has to match with the on in line 44, that's how they connect -->
              <h4 class="modal-title title">Title: Volunteering side effects</h4>
            </div>
            <div class="modal-body">
              <!--         Not sure if this classes will help when allocating information from "Create Task", if not, remove. -->
              <div class="type">
                Type: essay
              </div>
              <div class="tags">
                Tags: occupational therapy, volunteering, effects
              </div>
              <div class="no-of-pages">
                No of pages: 25
              </div>
              <div class="no-of-words">
                No of word:1526
              </div>
              <div class="file-Format">
                File Format: word
              </div>
              <div class="description">
                Description: side effects of volunteering
              </div>
              <div class="claimed-deadline">
                Claimed Deadline: 01/04/17
              </div>
              <div class="completion-deadline">
                Completion Deadline: 29/05/07
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Claim</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Flag</button>
              <p>Status: Available</p>
            </div>
          </div>
        </div>
      </div> <!-- finish modal -->





    </div> <!-- panel-body -->
  </div> <!-- panel panel-default -->
</div> <!-- container -->

</div>
<script src="js.functions.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>