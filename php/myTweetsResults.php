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
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Keyword<b class="caret"></b></a>
					<ul class="dropdown-menu" style='background-color: black; color: white;'>
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
				<li class="dropdown active">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" name="top">My Tweets<b class="caret"></b></a>
					<ul class="dropdown-menu" style='background-color: black; color: white;'>
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

<?php        

if(isset($_POST["account"])){
	$user = $_POST["account"];
}else{
	$user = "UWWhitewater";
}

require_once('TwitterAPIExchange.php');
require_once('cred.php');

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";

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



$negCounter = 0;
$neuCounter = 0;
$posCounter = 0;
$divider = count($string);
$totalSentiment = 0;
$userInfo = $string[0];
$tweetDiv = "";
if($errorType == "private"){
	$tweetDiv .= "<h3>&nbsp;&nbsp;The Twitter user is private. Showing Tweets for: The Hackers News</h3><br>";
}else if($errorType == "nonexistant"){
	$tweetDiv .= "<h3>&nbsp;&nbsp;The Twitter user does not exist. Showing Tweets for: The Hackers News</h3><br>";
}

require_once __DIR__ . '/Sent/autoload.php';
$sentiment = new \PHPInsight\Sentiment();
	
foreach($string as $items)
{
	$counter = $counter + 1;
	if($counter % 3 == 1){
		$tweetDiv .= "<div class='container'>";    
		$tweetDiv .= "<div class='row'>";
	}
	$tweetDiv .= "<div class='col-sm-4'>";
	$tweetDiv .= "<div class='panel panel-primary'>";
	if(isset($items['user']['screen_name'])){
		$tweetDiv .= "<div class='panel-heading'><a href='https://twitter.com/".$items['user']['screen_name']."' target='_blank' style='color: white;'>@".$items['user']['screen_name']."</a></div>";
	}else{
		$tweetDiv .= "<div class='panel-heading'>ERROR</div>";
	}
	if(isset($items['created_at'])){
		$tweetDiv .= "<div class='panel-heading' id='tweetDateHeader'>".$items['created_at']."</div>";
	}else{
		$tweetDiv .= "<div class='panel-heading' id='tweetDateHeader'>ERROR</div>";
	}
	if(isset($items['text'])){
		$tweetDiv .= "<div class='panel-body'>".$items['text']."</div>";
	}else{
		$tweetDiv .= "<div class='panel-body'>ERROR</div>";
	}
	$tweetDiv .= "<div class='panel-footer'><p><b>Sentiment: <span style='float:right;'>";
	
	
	
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
	$tweetDiv .= $class.": ".$scores[$class];
	#echo $class;
	if($class == 'neg'){
		$negCounter += 1;
		$temp = -1 * $scores[$class];
		#$tweetDiv .= $temp;
		$totalSentiment += $temp;
	}else if($class == 'pos'){
		$posCounter += 1;
		$temp = $scores[$class];
		#$tweetDiv .= $temp;
		$totalSentiment += $temp;
	}else if($class == 'neu'){
		$neuCounter += 1;
	}
	
	$tweetDiv .= "</p></b></div>";
	$tweetDiv .= "</div>";
	$tweetDiv .= "</div>";
	if($counter % 3 == 0){
		$tweetDiv .= "</div>";
		$tweetDiv .= "</div><br>";
	}
}
if($counter % 3 != 0){
	$tweetDiv .= "</div>";
	$tweetDiv .= "</div><br>";		
}











echo "<div class='jumbotron' style='background-color: #00aced;'>";
echo "<div class='container' style='color: white;'>";
echo "<div class='row'>";
echo "<div class='col-sm-4'>";
echo "<div id='profilePic'>"; # Add:  style='background-color:lavender;' to color
$subject = $userInfo['user']['profile_image_url_https'];
$search = '_normal';
$trimmed = str_replace($search, '', $subject);
echo "<img src='".$trimmed."' onerror=this.src='".$subject."' height='80%' width='80%' style='border-radius: 50%;'>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='col-sm-12'><p style='text-align: center;'>Name: ".$userInfo['user']['name']."</p></div>";
echo "</div>";
echo "</div>";
echo "<div class='col-sm-4'>";
echo "<div>";
echo "<p>Screenname: <a href='https://twitter.com/".$items['user']['screen_name']."' target='_blank' style='color: white;'>@".$userInfo['user']['screen_name']."</a></p>";
$followers = (int)$userInfo['user']['followers_count'];
echo "<p>Followers: ".number_format($followers)."</p>";
$following = (int)$userInfo['user']['friends_count'];
echo "<p>Following: ".number_format($following)."</p>";
if($userInfo['user']['location'] != ""){
	echo "<p>Location: ".$userInfo['user']['location']."</p>";
}
if($userInfo['user']['description'] != ""){
	echo "<p>Description: ".$userInfo['user']['description']."</p>";
}
echo "</div>";
echo "</div>";
echo "<div class='col-sm-4'>";
echo "<div id='emoji'>";

$imgSrc = "";
if(max($posCounter, $neuCounter, $negCounter) == $posCounter){
	//echo "<p>pos has the most</p>";
	if($negCounter/$divider <= .2){
		//Super happy
		$imgSrc = "../images/emoji/positive.png";
	}else{
		//Mild happy
		$imgSrc = "../images/emoji/positive2.png";
	}
}else if(max($posCounter, $neuCounter, $negCounter) == $negCounter){
	//echo "<p>neg has the most</p>";
	if($posCounter/$divider <= .2){
		//Super sad
		$imgSrc = "../images/emoji/negative.png";
	}else{
		//Mild sad
		$imgSrc = "../images/emoji/negative2.png";
	}
}else{
	//echo "<p>neu has the most</p>";
	if($posCounter > $negCounter){
		$ratio = $posCounter/($divider-$neuCounter);
		//echo "<p>".$ratio."</p>";
		if($ratio > .65){
			//Mild happy
			$imgSrc = "../images/emoji/positive2.png";
		}else{
			//Neutral
			$imgSrc = "../images/emoji/neutral.png";
		}
	}else{
		$ratio = $negCounter/($divider-$neuCounter);
		//echo "<p>".$ratio."</p>";
		if($ratio > .65){
			//Mild sad
			$imgSrc = "../images/emoji/negative2.png";
		}else{
			//Neutral
			$imgSrc = "../images/emoji/neutral.png";
		}
	}
}


echo "<img src='".$imgSrc."' height='80%' width='80%'>";
echo "</div>";
echo "<div class='row'>";
echo "<div class='col-sm-12'>";
echo "<p style='text-align: center;'>Average Sentiment: ".round($totalSentiment/$divider, 3)."</p>";
echo "<p style='text-align: center;'>Neg: ".$negCounter." || Neu: ".$neuCounter." || Pos: ".$posCounter." </p>";	
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

echo $tweetDiv;

/*
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

*/

?>

<footer class="container-fluid text-center">
  <p><a href="#top">Go to Top</p>  
</footer>

</body>
</html>
