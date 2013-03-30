<?php
include_once "facebook/facebook.php";

        $facebook = new Facebook(array(
            'appId' => 'YOUR APP ID',
            'secret' => 'YOUR API SECRET',
        ));

$scope = "email,user_photos";
        $params = array('scope' => $scope);
        $user = $facebook->getUser();
echo "user id is ".$user."<br>";
if(!$user){
        $loginUrl = $facebook->getLoginUrl($params);
        header("Location:$loginUrl");
        }
      $access_token = $facebook->getAccessToken();
if(!isset($_GET['id'])){
      $albums = $facebook->api("$user/albums");
      $albums = $albums['data'];
	echo '<ul style="display:inline">';
	foreach ($albums as $album){ 
		$album_id = $album['id'];
		$cover = $facebook->api("$album_id?fields=picture");
		$cover = $cover['picture'];	
	?>
		<li style="display:inline">
		<a href="index.php?id=<?php echo $album['id'];?>"><img src="<?php echo $cover;?>" style="width:100px;height:100px;padding:20px" title="<?php echo $album['name']?>"/></a>
		</li>
<?php	}
      ?>
</ul>
<?php } ?>
<?php if(isset($_GET['id'])){ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
<title>Facebook image slideshow</title>
<?php
	$id = $_GET['id'];
	$photos = $facebook->api("$id/photos");
	$photos = $photos['data'];
	$pictures = array();
	foreach ($photos as $photo){
		$pictures[] = $photo['source'];
	}
	$image = "";
	foreach ($pictures as $picture)
		$image .= '{'.'"'.'image'.'" : "'.$picture.'" },'
 ?>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">
var photos = [<?php echo $image; ?>];
</script>
</head>
<body>
<div id="header">
	<!-- jQuery handles to place the header background images -->
	<div id="headerimgs">
		<div id="headerimg1" class="headerimg"></div>
		<div id="headerimg2" class="headerimg"></div>
	</div>

	<!-- Slideshow controls -->
	<div id="headernav-outer">
		<div id="headernav">
			<div id="back" class="btn"></div>
			<div id="control" class="btn"></div>
			<div id="next" class="btn"></div>
		</div>
	</div>

</div>
</body>
<?php } ?>
</html>
