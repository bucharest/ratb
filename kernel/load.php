<?php
 /**********************************************************************
  * 
  * load.php - the load all the kernel files
  * 
  **********************************************************************/

/* time is money */

		$query_time = explode(' ',microtime());
		$start_time = $query_time[1].substr($query_time[0],1);

/* use theend(); to end it :) */

/* Load all other files */
	 include "config.php";
	 include "functions.php";	

// Let`s DO it... the connection of course
	DoConnect(); 
	header('Content-type: text/html; charset=utf-8');
 