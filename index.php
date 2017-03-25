<html>
  <head>
      <link rel = "stylesheet" type = "text/css" href = "bootstrap/css/bootstrap.css">
      <link rel = "stylesheet" type = "text/css" href = "css/style.css">
      <script type = "text/javascript" src = "js/jquery-3.1.1.js"></script>
      <script type = "text/javascript" src = "bootstrap/js/bootstrap.js"></script>
      <script type="text/javascript" src="js/jquery-bootpag/lib/jquery.bootpag.js"></script>

      <script type="text/javascript" src = "js/home.js"></script>
      <script type = "text/javascript" src = "js/login.js"></script>
      <script type="text/javascript" src = "js/statistics.js"></script>


      <link href="/bootstrap/css/pe-icon-7-stroke.css" rel="stylesheet" />
      <link href="/bootstrap/css/ct-navbar.css" rel="stylesheet" />
      <script src="/bootstrap/js/ct-navbar.js"></script>
      <script src = "/js/Chart.js"></script>
  </head>
  <body>
    <div id="navbar-green">
        <nav class="navbar navbar-ct-green" role="navigation">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a id = "home" class="navbar-brand" href="#/">
                <i class = "pe-7s-home">KSU</i>
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id = "navbarCollapse">
                <ul class="nav navbar-nav navbar-right" >
                    <!--<li>
                          <a id = "login" href="/#login">
                                <i class="pe-7s-angle-right"></i>
                                <p>Увійти</p>
                           </a>
                    </li>-->
                    <li>
                          <a id = "stat" href="/#statistics">
                                <i class="pe-7s-graph1"></i>
                                <p>Статистика</p>
                           </a>
                    </li>
               </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </div>

    <div class="container">
      <div id = "mainContent" class="col-md-12">
        <!--
        <div id = "loginColumn">
          <div class="container">

            <div class="row" style="margin-top:60px">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
              			<fieldset>
              				<h2>Please Sign In</h2>
              				<hr class="colorgraph">
              				<div class="form-group">
                              <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address"></input>
              				</div>
              				<div class="form-group">
                              <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password"></input>
              				</div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name = "remember">Remember me</input>
                        </label>
                      </div>
              				<hr class="colorgraph">
              				<div class="row">
              					<div class="col-xs-6 col-sm-6 col-md-6">
                                      <button id = "loginSubmit" class="btn btn-lg btn-success btn-block">Sign In</button>
              					</div>
              				</div>
              			</fieldset>
            	</div>
            </div>
          </div>
          -->

        </div>


        <div id = "statistics">
          <div class = "row">
            <div id = "repoInfo">
              <h3>Загальна кількість дисертацій: <b id = "common"></b></h3>
            </div>
          </div>
          <div id = "pieCon">
              <canvas id="pieRepo" width="300" height="300"></canvas>
          </div>
          <div id = "barYearCon">
            <canvas id="barYearRepo" width="300" height="300"></canvas>
          </div>
        </div>

        <div class = "row">
          <div id = "filter" class = "col-md-12">

          </div>
        </div>
        <br>
        <div class = "row">
            <div id = "repoContent" class = "col-md-12">

            </div>
          </div>
      </div>
    </div>
    <div id = "anchor">
         <span id = "anchorUp" class="glyphicon glyphicon-circle-arrow-up"></span>
    </div>
  </body>
</html>
