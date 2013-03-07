<?php
 /**********************************************************************
  * 
  * For mor info look at the *.txt files
  *	
  * functions.php - some functions to make things look prettier
  * 
  **********************************************************************/

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


/**
 * Establishes a database connection.
 *
 * @param string $dbserver
 * @param string $dbuser
 * @param string $dbpassword
 * @param string $dbname
 */



function DoConnect() 
{
	global $dbhost, $dbuser, $dbpassword, $dbname;
	
	$success = mysql_connect($dbhost, $dbuser, $dbpassword);
	if (!$success)
		sqldie("$success");
		mysql_set_charset('utf8', $success); 
		$success = mysql_selectdb ($dbname);
	
	if (!$success) {
		sqldie($success);
	}
}
				

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


/**
 * The Query function
 *
 * @param string $message
 *
 * @todo: make this prettier
 */

function query($quer)
{
  $result = mysql_query($quer);

  if (mysql_error())
    dienice("<b>Message:</b> " . mysql_error() . "<br /><b>Query:</b> $quer");

  return $result;
}


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


 /**
 * Dies with a cleaner look than a standard die.
 *
 * @param string $message
 *
 * @todo: make this prettier
 */
function dienice($message)
{
	
	echo " <font color='#FF0000'><b>An error has occured and the script simply can't go on...</b><br></font>" . $message;
	die();
}



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/



 /**
 * Calls dienice with mysql_error appended to $message.
 *
 * @param string $message
 *
 * @todo: make this prettier
 */
function sqldie($message)
{
	dienice($message . " " . mysql_error());
}



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


 /**
 * Makes the end time
 *
 */
function theend()
{
	global $start_time;
	 $query_time = explode(' ',microtime());
	 $total_time = ($query_time[1].substr($query_time[0],1)) - $start_time;
	 echo ''.substr($total_time,0,8),' seconds';
}

