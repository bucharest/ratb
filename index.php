<!DOCTYPE html>
<html> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Yet another foursquare client</title> 
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <link href="gfx/facebox.css" media="screen" rel="stylesheet" type="text/css" /> 
        <link href="gfx/style.css" media="screen" rel="stylesheet" type="text/css" /> 
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> 
		<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script> 
		<script type="text/javascript" src="js/js.js?<?php echo rand(1,9999);?>"></script> 
		<script type="text/javascript" src="js/facebox.js" ></script>
		
</head> 
    <body> 
	
<div id="mainmap"></div> 

<div id="vwraper">
 <div id="result"> 
    <h1 id="location"></h1> 
    <div id="venue"><strong>Loading Venues </strong><span></span></div>
 </div>
</div>

<div id="loader"></div>

</body> 



</html>