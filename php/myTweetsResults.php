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
          <a class="navbar-brand" href="../index.php" name="top"><img src="../images/TwitterLogo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li><a href="../index.php">Home</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Keyword<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li>
							<p>&nbsp;Create a New Search</p>
						</li>
						<!--<li><a href="php/keywordSearch.php"><button class="btn btn-success btn-block" style="background-color: #00aced;">New Search</button></a></li>-->
						<li><form action="keywordSearch.php">
							<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">New Search</button>
						</form></li>
						<br>
						<li>
							<p>&nbsp;Quickly Search Here:</p>
						</li>
						  <form method="POST" action="keywordResults.php">
                              <div class="form-group">
								<li>
                                  <input type="text" class="form-control" value="" required="" title="Please enter a keyword!" name="keyword" placeholder="Technology">
                                </li>
								<span class="help-block"></span>
                              </div>
							  <li>
								<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">Find Keyword</button>
							  </li>
						  </form>
					</ul>
				</li>
				<li class="dropdown active">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Tweets<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li>
							<p>&nbsp;Create a New Search</p>
						</li>
						<li><form action="myTweetsSearch.php">
							<button type="submit" class="btn btn-success btn-block" style="background-color: #00aced;">New Search</button>
						</form></li>
						<br>
						<li>
							<p>&nbsp;Quickly Search Here:</p>
						</li>
						  <form method="POST" action="myTweetsResults.php">
                              <div class="form-group">
								<li>
                                  <input type="text" class="form-control" value="" required="" title="Please enter a keyword!" name="account" placeholder="UWWhitewater">
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
<!--
<div class="jumbotron">
  <div class="container text-center">
	<h1>Keyword Info</h1>
    <h1>Twitter Account Info</h1>      
  </div>
</div>
-->

<?php        

if(isset($_POST["account"])){
	//echo "<h1>Twitter Handle ". $_POST["account"] ."</h1>";
	$user = $_POST["account"];
}else{
	$user = "UWWhitewater";
}

require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
require_once('cred.php');

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";

//if (isset($_GET['user']))  {$user = $_GET['user'];}  else {$user  = "UWWhitewater";}
//if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 48;}

$count = 30;

$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);	

$profileError = 1;
$errorType = "";
$counter = 0;

if(count($string) > 1){
	foreach($string as $items)
	{
		if(!isset($items['user']['screen_name'])){
			$profileError = 5;
			$errorType = "private";
		}
	}
}else{
	$profileError = 5;
	$errorType = "nonexistant";
}

if($profileError == 5){
	$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	$requestMethod = "GET";

	$getfield = "?screen_name=TheHackersNews&count=$count";
	$twitter = new TwitterAPIExchange($settings);
	$string = json_decode($twitter->setGetfield($getfield)
	->buildOauth($url, $requestMethod)
	->performRequest(),$assoc = TRUE);	
}
/*
echo $string[0]['user']['profile_image_url_https'];
echo "<img src='".$string[0]['user']['profile_image_url_https']."'>";
echo $string[0]['user']['name'];
echo $string[0]['user']['screen_name'];
echo $string[0]['user']['location'];
echo $string[0]['user']['description'];
echo $string[0]['user']['followers_count'];
echo $string[0]['user']['friends_count'];
echo $string[0]['user']['verified'];
*/

/*
echo "<div class='jumbotron' style='background-color: #00aced;'>";
echo "<div class='container'>";    
echo "<div class='row'>";
echo "<div class='col-sm-4' id='profilePic'>"; # Add:  style='background-color:lavender;' to color
$subject = $string[0]['user']['profile_image_url_https'];
$search = '_normal';
$trimmed = str_replace($search, '', $subject);
echo "<img src='".$trimmed."' onerror=this.src='".$subject."' height='80%' width='80%' style='border-radius: 50%;'>";
echo "</div>";
echo "<div class='col-sm-4' style='color: white;'>";
echo "<p>Name: ".$string[0]['user']['name']."</p>";
echo "<p>Screenname: <a href='https://twitter.com/".$items['user']['screen_name']."' target='_blank' style='color: white; text-decoration: none;'>@".$string[0]['user']['screen_name']."</a></p>";
$followers = (int)$string[0]['user']['followers_count'];
echo "<p>Followers: ".number_format($followers)."</p>";
$following = (int)$string[0]['user']['friends_count'];
echo "<p>Following: ".number_format($following)."</p>";
echo "<p>Location: ".$string[0]['user']['location']."</p>";
echo "<p>Description: ".$string[0]['user']['description']."</p>";
echo "</div>";
echo "<div class='col-sm-4' id='emoji'>";
echo "<img src='../images/emoji/positive.png' height='80%' width='80%'>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
*/


echo "<div class='jumbotron' style='background-color: #00aced;'>";
echo "<div class='container' style='color: white;'>";
echo "<div class='row'>";
echo "<div class='col-sm-4'>";
echo "<div id='profilePic'>"; # Add:  style='background-color:lavender;' to color
$subject = $string[0]['user']['profile_image_url_https'];
$search = '_normal';
$trimmed = str_replace($search, '', $subject);
echo "<img src='".$trimmed."' onerror=this.src='".$subject."' height='80%' width='80%' style='border-radius: 50%;'>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='col-sm-12'><p>Name: ".$string[0]['user']['name']."</p></div>";
echo "</div>";
echo "</div>";
echo "<div class='col-sm-4'>";
echo "<div>";
echo "<p>Screenname: <a href='https://twitter.com/".$items['user']['screen_name']."' target='_blank' style='color: white;'>@".$string[0]['user']['screen_name']."</a></p>";
$followers = (int)$string[0]['user']['followers_count'];
echo "<p>Followers: ".number_format($followers)."</p>";
$following = (int)$string[0]['user']['friends_count'];
echo "<p>Following: ".number_format($following)."</p>";
echo "<p>Location: ".$string[0]['user']['location']."</p>";
echo "<p>Description: ".$string[0]['user']['description']."</p>";
echo "</div>";
echo "</div>";
echo "<div class='col-sm-4'>";
echo "<div id='emoji'>";
echo "<img src='../images/emoji/positive.png' height='80%' width='80%'>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='col-sm-12'>";
echo "<p>Average Sentiment: .35";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

/* STRUCTURE OF CONTAINER

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h1>Hello World!</h1>
  <p>Resize the browser window to see the effect.</p>
  <div class="row">
    <div class="col-sm-4" style="background-color:lavender;">.col-sm-4
      <div class="row">
        <div class="col-sm-12" style="background-color:lightcyan;">.col-sm-4</div>
      </div>
    </div>
    <div class="col-sm-4" style="background-color:lavenderblush;">.col-sm-4</div>
    <div class="col-sm-4" style="background-color:lavender;">.col-sm-4
      <div class="row">
        <div class="col-sm-12" style="background-color:lightcyan;">.col-sm-4</div>
      </div>
    </div>
  </div>
</div>
    
</body>
</html>

*/

if($errorType == "private"){
	echo "<h3>&nbsp;&nbsp;The Twitter user is private. Showing Tweets for: The Hackers News</h3><br>";
}else if($errorType == "nonexistant"){
	echo "<h3>&nbsp;&nbsp;The Twitter user does not exist. Showing Tweets for: The Hackers News</h3><br>";
}

require_once __DIR__ . '/Sent/autoload.php';
$sentiment = new \PHPInsight\Sentiment();
	
foreach($string as $items)
{
	$counter = $counter + 1;
	if($counter % 3 == 1){
		echo "<div class='container'>";    
		echo "<div class='row'>";
	}
	echo "<div class='col-sm-4'>";
	echo "<div class='panel panel-primary'>";
	if(isset($items['user']['screen_name'])){
		echo "<div class='panel-heading'><a href='https://twitter.com/".$items['user']['screen_name']."' target='_blank' style='color: white;'>@".$items['user']['screen_name']."</a></div>";
	}else{
		echo "<div class='panel-heading'>ERROR</div>";
	}
	if(isset($items['created_at'])){
		echo "<div class='panel-heading' id='tweetDateHeader'>".$items['created_at']."</div>";
	}else{
		echo "<div class='panel-heading' id='tweetDateHeader'>ERROR</div>";
	}
	if(isset($items['text'])){
		echo "<div class='panel-body'>".$items['text']."</div>";
	}else{
		echo "<div class='panel-body'>ERROR</div>";
	}
	echo "<div class='panel-footer'><p><b>Sentiment: <span style='float:right;'>";
	
	
	
	#$string = "this is a test to see how accurate it is";
	$string = $items['text'];
	
	// calculations:
	$scores = $sentiment->score($string);
	$class = $sentiment->categorise($string);

	// output:
	#echo "String: $string\n";
	//echo "Dominant: $class, scores: ";
	//print_r($scores);
	//echo "<p>".$scores[$class]."</p>";
	#echo "\n";
	echo $class.": ".$scores[$class];

	
	
	
	echo "</p></b></div>";
	echo "</div>";
	echo "</div>";
	if($counter % 3 == 0){
		echo "</div>";
		echo "</div><br>";
	}
}
if($counter % 3 != 0){
	echo "</div>";
	echo "</div><br>";		
}


?>

<footer class="container-fluid text-center">
  <p><a href="#top">Go to Top</p>  
</footer>

</body>
</html>
