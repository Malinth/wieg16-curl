<!DOCTYPE html>
<html>
<head></head>
<body>

<?php

//Hitta databasen med hjälp av PDO, som bör ligga längst upp.

$host = 'localhost'; 
$db = 'curl';
$user = 'root';
$password = 'root';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_EMULATE_PREPARES   => false  ];
              
$pdo = new PDO($dsn, $user, $password, $options);
?>

				
<h1>Add a new artist here</h1>
<form action="form.php" method="post">
<input type="text" name="name" placeholder="Name" value="" /> <br>
<input type="text" name="song" placeholder="Song" value="" /> <br>
<button type="submit">Add a new artist</button>
</form>

<?php
if( isset($_POST['name']) ) {

// lägg till nytt
$sql = "INSERT INTO `artists` (`name`, `song`) VALUES (:name, :song) ";
$stm_insert = $pdo->prepare($sql);
$stm_insert->execute(['name' => $_POST['name'], 'song' => $_POST['song']]);
echo "<p>You added a new artist!</p>";

}

?>


</body>
</html>