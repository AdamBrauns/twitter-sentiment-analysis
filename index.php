<!DOCTYPE html>
<html lang="en">
<head>
  <title>Homepage</title>
  <link rel="icon" href="../images/TwitterLogo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/template.css">
</head>
<body style='background-color: #00aced;'>
	<nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="index.php" name="top"><img src="../images/TwitterLogo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="../index.php">Home</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Keyword<b class="caret"></b></a>
					<ul class="dropdown-menu" style='background-color: black; color: white;'>
						<li>
							<p>&nbsp;Create a New Search</p>
						</li>
						<li><form action="php/keywordSearch.php">
							<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">New Search</button>
						</form></li>
						<br>
						<li>
							<p>&nbsp;Quickly Search Here:</p>
						</li>
						  <form method="POST" action="php/keywordResults.php">
                              <div class="form-group">
								<li>
                                  <input style='background-color: #FFFACD;' type="text" class="form-control" value="" required="" title="Please enter a keyword!" name="keyword" placeholder="Technology">
                                </li>
								<span class="help-block"></span>
                              </div>
							  <li>
								<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">Find Keyword</button>
							  </li>
						  </form>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Tweets<b class="caret"></b></a>
					<ul class="dropdown-menu" style='background-color: black; color: white;'>
						<li>
							<p>&nbsp;Create a New Search</p>
						</li>
						<li><form action="php/myTweetsSearch.php">
							<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">New Search</button>
						</form></li>
						<br>
						<li>
							<p>&nbsp;Quickly Search Here:</p>
						</li>
						  <form method="POST" action="php/myTweetsResults.php">
                              <div class="form-group">
								<li>
                                  <input style='background-color: #FFFACD;' type="text" class="form-control" value="" required="" title="Please enter a keyword!" name="account" placeholder="UWWhitewater">
                                </li>
								<span class="help-block"></span>
                              </div>
							  <li>
								<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">Find My Tweets</button>
							  </li>
						  </form>
					</ul>
				</li>
			</ul>
        </div>
      </div>
    </nav>
    <div id="login-overlay" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Welcome to the Twitter Sentiment Analysis Website!</h4>
			  <p>To begin, select the operation that you would like to view.</p>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xs-6">
                      <div class="well">
                          <form method="POST" action="php/keywordResults.php">
                              <div class="form-group">
                                  <label class="control-label">Keyword Search</label>
								  <p>In this section, you can enter in a keyword or phrase to see what people are saying about a certain topic!</p>
                                  <input type="text" class="form-control" value="" required="" title="Please enter a keyword!" name="keyword" placeholder="Technology">
                                  <span class="help-block"></span>
                              </div>
                              <button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">Find Keyword</button>
                          </form>
                      </div>
                  </div>
                  <div class="col-xs-6">
                      <div class="well">
                          <form method="POST" action="php/myTweetsResults.php">
                              <div class="form-group">
                                  <label class="control-label">View My Tweets</label>
								  <p>In this section, you can enter in your Twitter handle to view your tweets and the associating Sentiment Score!</p>
                                  <input type="text" class="form-control" value="" required="" title="Please enter your Twitter handle!" name="account" placeholder="UWWhitewater">
                                  <span class="help-block"></span>
                              </div>
                              <button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">Find Account</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</body>