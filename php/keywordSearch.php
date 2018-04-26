<!DOCTYPE html>
<html lang="en">
<head>
  <title>Twitter User Results</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/template.css">
</head>
<body>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="../index.php"><img src="../images/TwitterLogo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">Home</a></li>
            <li class="active"><a href="keywordSearch.php">Keyword</a></li>
            <li><a href="myTweetsSearch.php">My Tweets</a></li>
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
                      <div class="well">
                          <form method="POST" action="keywordResults.php">
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
      </div>
  </div>
</body>