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
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>

  <!-- Content Step 2 -->
  <div class="container">
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
            <form action="" class="form-horizontal">
              <div class="form-group row">
                <h1>Log in</h1></br>
                <label for="inputEmail3" class="col-sm-4 col-md-4 control-label">UL Email</label>
                <div class="col-sm-5 col-md-5">
                  <input class="form-control" id="inputEmail3" pattern=".+@studentmail.ul.ie" placeholder="123456789@studentmail.ul.ie">
                </div>
              </div>

              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-4  col-md-4 control-label">Password <small>(8 characters, 1 uppercase, 1 digit)</small></label>
                <div class="col-sm-5 col-md-5">
                  <input pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength = "8" class="form-control" id="inputPassword3" placeholder="Password">
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
          <form>
            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="name">Name</label>
              <input class=" form-control" type="text" id="name" placeholder="Jack">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="Surname">Surname</label>
              <input class=" form-control" type="text" id="Surname" placeholder="Kelleher">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="Username">Username</label>
              <input class=" form-control" type="text" id="Username" placeholder="JackKelleher">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="Major">Major/Subject</label>
              <select class="form-control" id="sel1">
                <option>Arts, Humanities and Social Sciences</option>
                <option>Kemmy Business School</option>
                <option>Education and Health Sciences</option>
                <option>Science and Engineering</option>
                <option>Irish World Academy of Music and Dance</option>
              </select>
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <label for="email">UL email address</label>
              <input class=" form-control" pattern=".+@studentmail.ul.ie" id="email" placeholder="12345678@studentmail.ul.ie">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="password">Password <small>(8 characters, 1 uppercase, 1 digit)</small> </label>
              <input class=" form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="password" placeholder="xxxxxxxxx">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
              <label for="re-password">Re-enter password</label>
              <input class=" form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8" id="re-password" placeholder="xxxxxxxxx">
            </div>
            <br>
            <button class="btn btn-primary center-block">Register</button>
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