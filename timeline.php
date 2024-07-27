<?php
require_once 'header.php';
$user = $_SESSION['user'];
echo "<div class='postcontainer'>";
echo "<div class='timelineform'>";
echo "<br>Welcome <strong>$user</strong>.<br><br>";

if(isset($_POST['content']) && isset($_FILES['photo']['name'])){
	$getcount = runthis($sql->ViewPhotosFromUser(),['user'=>$user]);
	$getcountrow = $getcount['fetch_array']->fetch(PDO::FETCH_BOTH,0);
	$count = $getcountrow==true?$getcountrow->count:0;
	$count = $count + 1;
	$saveto = "pics/" . $user . "pic" . $count . ".jpg";
	$detectedType = exif_imagetype($_FILES['photo']['tmp_name']);
	$allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
	if(in_array($detectedType, $allowedTypes)){
		move_uploaded_file($_FILES['photo']['tmp_name'], $saveto);
		$result  = runthis($sql->UpdatePhotosCountUser(),['count'=>$count,'user'=>$user]);
		$result  = $result['result']==false?runthis($sql->CreatePhotosCountUser(),['count'=>$count,'user'=>$user]):true;
		$content = cleanup($_POST['content']);
		runthis($sql->InsertPost(),['user'=>$user,'content'=>$content,'saveto'=>$saveto]);
	}else{
		echo "Error: file type must be .jpg or .png";
}}
?>

<form method='post' action='timeline.php' enctype='multipart/form-data'>
<label class='fileinput'>Upload a photo<input type='file' name='photo' style='display:none;'></label><br>
<input id='describe' type='text' name='content' placeholder='Write something about it...'>
<input class='submitbutton' type='submit' value='Post'>
</form>
</div>

<?php
$result = runthis($sql->ViewPostsIdDesc(),[]);
$n = $result['num_rows'];
for($j = 0; $j < $n; $j++)
{
	$row = $result['fetch_array']->fetch();
	$author = $row['author'];
	$addr = $row['photo'];
	$content = $row['content'];
	$upvotes = $row['upvotes'];
	echo "<div class='post'><div class='authorbar'>" .
			"<img src='$author.jpg' class='usericon'>" .
			"<span><a href='profile.php?view=$author'><strong>$author</strong></a></span>" . "</div>" .
			"<img src='$addr' style='height:600px; width:600px;'>" .  
			"<div class='commentbar'>$content<br><br>$upvotes upvotes</div>" .
		"</div>";
}
?>
</div>
</body>
</html>