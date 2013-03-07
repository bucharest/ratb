<?
include "kernel/load.php";
echo "<pre>";
$file = file_get_contents("json");

$jsn = json_decode($file, true);
$i = 0;
foreach ($jsn["markers"]["markers"] as $markers){

$nid = $markers["nid"];
$lat = $markers["lat"];
$lon = $markers["lon"];
$type = $markers["type"];
$title = $markers["title"];
$body = $markers["body"];

$sql = "INSERT INTO `statii` (`id`, `nid`, `lon`, `lat`, `type`, `title`, `body`) 
					  VALUES (NULL, '$nid', '$lon', '$lat', '$type', '$title', '$body');";
query($sql);

$i++					  ;

}
echo "$i values added<br />";

theend();