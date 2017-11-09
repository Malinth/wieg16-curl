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

				
<h1>Lägg till en artist</h1>
<form action="form.php" method="post">
<input type="text" name="fdjurnamn" placeholder="Djurnamn" value="" /> <br>
<input type="text" name="fantalBen" placeholder="Antal ben" value="" /> <br>
<input type="text" name="ftyp" placeholder="Djurtyp" value="" /> <br>

<button type="submit">Lägg till nytt djur</button>
</form>

<?php
if( isset($_POST['fdjurnamn']) ) {
// kolla om djuret finns i databasen
// jämföra kolumnen `namn` med $_POST['fdjurnamn']
$sql = "SELECT COUNT(*) AS 'antal_rader' FROM `djur` WHERE namn = :djurnamn";
$stm_count = $pdo->prepare($sql);
$stm_count->execute(['djurnamn' => $_POST['fdjurnamn']]);
foreach( $stm_count as $row ) {
$antal_rader = $row['antal_rader'];
}

if( $antal_rader > 0 ) {
// uppdatera befintligt djur
$sql = "UPDATE `djur` SET `antalBen` = :vantalben, `typ` = :vtyp WHERE `namn` = :vdjurnamn";
$stm_update = $pdo->prepare($sql);
$stm_update->execute(['vantalben' => $_POST['fantalBen'], 'vtyp' => $_POST['ftyp'], 'vdjurnamn' => $_POST['fdjurnamn']]);
echo "<p>{$_POST['fdjurnamn']} fanns redan, så nu är den uppdaterade.</p>";

} else {
// lägg till nytt
$sql = "INSERT INTO `djur` (`namn`, `antalBen`, `typ`) VALUES (:djurnamn, :antalben, :djurtyp) ";
$stm_insert = $pdo->prepare($sql);
$stm_insert->execute(['djurnamn' => $_POST['fdjurnamn'], 'antalben' => $_POST['fantalBen'], 'djurtyp' => $_POST['ftyp']]);
echo "<p>Du lade till nytt djur !!</p>";
}

} else {
echo "<p>Lägg gärna till en artist i tabellen.</p>";
}
?>

</body>
</html>