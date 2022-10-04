<?php
include("./database.php");

$aboutme = $db->prepare("SELECT * FROM aboutme");
$aboutme->execute(array());
$aboutResults = $aboutme->fetchAll();
foreach ($aboutResults as $aboutt) {
}

$file = "About.txt";
$txt = fopen($file, "w") or die("Unable to open file!");
fwrite($txt, "About Blogger\n\n");
fwrite($txt, $aboutt["about"]);
fclose($txt);

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=' . basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/plain");
readfile($file);
