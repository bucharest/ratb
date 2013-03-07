<?php
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate( 'D, d M Y H:i:s' ) . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false ); 
header("Pragma: no-cache"); 
  
require 'kernel/load.php';  // defines $dsn, $username, $password
  

$loc = $_POST['curlocation'];
$loc = substr($loc, 1, -1);
$loc = explode(",", $loc);
$lat = trim($loc[0]);
$lon = trim($loc[1]);

/*
  $lat = 44.4411855581497; 		//$_GET['lat'];  // latitude of centre of bounding circle in degrees
  $lon = 26.133369919821234; 	//$_GET['lon'];  // longitude of centre of bounding circle in degrees
*/ 

$rad = 1;						//$_GET['rad'];  	// radius of bounding circle in kilometers
  
$R = 6371;  // earth's radius, km
  
  // first-cut bounding box (in degrees)
  $maxLat = $lat + rad2deg($rad/$R);
  $minLat = $lat - rad2deg($rad/$R);
  // compensate for degrees longitude getting smaller with increasing latitude
  $maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
  $minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));
  
  // convert origin of filter circle to radians
  $lat = deg2rad($lat);
  $lon = deg2rad($lon);

   
  $sql = "
    Select id,title, body, lat, lon, type, 
           acos(sin($lat)*sin(radians(Lat)) + cos($lat)*cos(radians(Lat))*cos(radians(Lon)-$lon))*$R As distance
    From (
      Select * from statii
      Where lat>$minLat And lat<$maxLat
        And lon>$minLon And lon<$maxLon
      ) As FirstCut 
    Where acos(sin($lat)*sin(radians(Lat)) + cos($lat)*cos(radians(Lat))*cos(radians(Lon)-$lon))*$R < $rad
    Order by distance";
  
  //echo "$sql";
  
  $result = query($sql);
  $rows = array();

  while($r = mysql_fetch_assoc($result)) {
    

	$rows[] = $r;
    
}
echo json_encode($rows);

  
?>

