
<?php
//データベースへの接続
$dsn='データベース名;host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

//データベース内にテーブルを作成する
$sql="CREATE TABLE mission4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name CHAR(32),"
."comment TEXT,"
."date DATETIME,"
."pass CHAR(32)"
.");";
$stmt=$pdo->query($sql);


//投稿を編集する
//名前とコメントが空じゃない時
if(!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['pass'])){
	
	//受け取った隠された編集番号が空じゃない時
	if(!empty($_POST['bango'])){
		$id=$_POST['bango'];
		$name=$_POST['name'];
		$comment=$_POST['comment'];
		$date=date("Y/m/d H:i:s");
		$pass=$_POST['pass'];
		//入力データの編集
		$sql="update mission4 set name='$name',comment='$comment',date='$date',pass='$pass' where id=$id";
		$result=$pdo->query($sql);
	}
	//編集番号が空の時
	else{
		//データの入力
		$sql=$pdo->prepare("INSERT INTO mission4(name,comment,date,pass) VALUES(:name,:comment,:date,:pass)");
		$sql->bindParam(':name', $name, PDO::PARAM_STR);
		$sql->bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql->bindParam(':date', $date, PDO::PARAM_STR);
		$sql->bindParam(':pass', $pass, PDO::PARAM_STR);
	
		$name=$_POST['name'];
		$comment=$_POST['comment'];
		$date=date("Y/m/d H:i:s");
		$pass=$_POST['pass'];
		$sql->execute();
	}
}

//投稿を削除する
//削除対象番号が空じゃない時
if(ctype_digit($_POST['sakujo'])){
	$id=$_POST['sakujo'];

	$sql="SELECT*FROM mission4 where id=$id";
	$stmt=$pdo->query($sql);
	$result=$stmt->fetch();
	$password2=$_POST['password2'];
	$pass=$result['pass'];
	//パスワードが正しい時
	if($password2==$pass){
		//削除
		$delete="delete from mission4 where id=$id";
		$result=$pdo->query($sql);
		
	}
	//パスワードが間違っている時
	else{
		echo "パスワードが間違っています。";
	}
	
}


//投稿を編集
//編集番号が空じゃない時
if(!empty($_POST['henshu'])){
	$id=$_POST['henshu'];
	$sql="SELECT*FROM mission4 where id=$id";
	$stmt=$pdo->query($sql);
	$result=$stmt->fetch();


		$password3=$_POST['password3'];

		//入力されたパスワードが正しい時
		if($password3==$result['pass']){

			//投稿番号、名前。コメントを$dataとする
			$data0=$result['id'];
			$data1=$result['name'];
			$data2=$result['comment'];
			$data3=$result['pass'];
		}
	
		else{
			echo "パスワードが間違っています。";
		}
}

?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
</head>
<body>
<form action="mission_4-111.php" method="post">
名前：<input type="text" name="name" value="<?php echo $data1; ?>" placeholder="名前"><br>
コメント：<input type="text" name="comment" value="<?php echo $data2; ?>" placeholder="コメント"><br>
<input type="hidden" name="bango" value="<?php echo $data0; ?>">
<input type="text" name="pass" value="<?php echo $data3; ?>" placeholder="パスワード">
<input type="submit" value="送信"><br>
<br>
削除対象番号:<input type="text" name="sakujo" value="" placeholder="削除対象番号"><br>
<input type="text" name="password2" value="" placeholder="パスワード">
<input type="submit" value="削除"><br>
<br>
編集対象番号:<input type="text" name="henshu" value="" placeholder="編集対象番号"><br>
<input type="text" name="password3" value="" placeholder="パスワード">
<input type="submit" value="編集">

</form>
</body>
</html>

<?php
//投稿を表示する
$sql="SELECT*FROM mission4";
$results=$pdo->query($sql);
if(!empty($results)){
	foreach($results as $row){

		echo $row['id']." ";
		echo $row['name']." ";
		echo $row['comment']." ";
		echo $row['date']."<br>";
	}

}
?>


