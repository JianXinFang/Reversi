<?php require_once('Connections/reversi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "usertype";
  $MM_redirectLoginSuccess = "game.php";
  $MM_redirectLoginFailed = "loginerror.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_reversi, $reversi);
  	
  $LoginRS__query=sprintf("SELECT username, password, usertype FROM users WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $reversi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'usertype');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/normal_page.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<title>Reversi</title>
</head>

<body>
<div style="position:relative;top:0px;" align="center">
  <table width="1200" border="0">
    <tr>
      <td width="970"><span style="text-align: left; font-size: 30pt;"><img src="imgs/left arrow.png" width="75" height="27" alt="previous" />&nbsp;<a href="news.php">Welcome to reversi!</a>&nbsp;<img src="imgs/right arrow.png" width="75" height="27" alt="next" /></span></td>
      <td width="80"><img src="imgs/profile_icon.png" width="80" height="62" alt="profiles" /></td>
      <td width="142"><span style="text-align: left; font-size: 30pt;"><a href="user_profiles.php">User<br />Profiles</a></span>
      </td>
    </tr>
  </table>
</div>
<div style="position:relative;top:20px;" align="center">
  <table width="1117" border="0">
    <tr>
      <td width="105"><span style="text-align: left; font-size: 30pt;"><a href="home.php">Home</a>&nbsp;</span></td>
      <td width="10"><img src="imgs/menu div.png" width="10" height="50" /></td>
      <td width="193"><span style="text-align: left; font-size: 30pt;">&nbsp;<a href="dashboard.php">Dashboard&nbsp;</a></span></td>
      <td width="10"><img src="imgs/menu div.png" alt="" width="10" height="50" /></td>
      <td width="209"><span style="text-align: left; font-size: 30pt;">&nbsp;<a href="tournament.php">Tournament</a>&nbsp;</span></td>
      <td width="10"><img src="imgs/menu div.png" alt="" width="10" height="50" /></td>
      <td width="156"><span style="text-align: left; font-size: 30pt;">&nbsp;<a href="ranking.php">Ranking</a>&nbsp;</span></td>
      <td width="10"><img src="imgs/menu div.png" alt="" width="10" height="50" /></td>
      <td width="97"><span style="text-align: left; font-size: 30pt;">&nbsp;<a href="faq.php">FAQ</a>&nbsp;</span></td>
      <td width="10"><img src="imgs/menu div.png" alt="" width="10" height="50" /></td>
      <td width="196"><span style="text-align: left; font-size: 30pt;">&nbsp;<a href="abtus.php">About Us</a></span></td>
    </tr>
  </table>
</div>

<div style="position:relative;top:65px;" align="center"><img src="imgs/reversilogo.png" width="800" height="198" alt="REVERSI" /></div>
</div>
<div style="position:relative;top:65px;height:1400px;" align="center"><!-- InstanceBeginEditable name="content_area" -->
  <div class="subheader">LOGIN</div>
  <form id="login" name="login" method="POST" action="<?php echo $loginFormAction; ?>">
    <table width="900" border="0" align="center" class="tbl">
      <tr>
        <td width="379" height="54" align="right">Username&nbsp;</td>
        <td width="256"><span class="logintxtbox">
          <input name="username" type="text" class="logintxtbox" id="username" size="35" />
        </span></td>
        <td width="251" rowspan="2" align="left" class="small"><p><u>Forgot<br />
          Password?</u></p></td>
      </tr>
      <tr>
        <td align="right" >Password&nbsp;</td>
        <td width="256"><span class="logintxtbox">
          <input name="password" type="password" class="logintxtbox" id="password" size="35" />
        </span></td>
      </tr>
    </table>
    <table width="425" border="0" class="tbl">
      <tr>
        <td width="236" align="center" class="small"><p><u>Do not have an account?<br />
          Register Now!</u></p></td>
        <td width="179" align="center"><button class="astext"><u>Login</u></button></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </form>
<!-- InstanceEndEditable --></div>
<div style="position:relative;top:65px;" align="center"> REVERSI.COM 2015 ALL RIGHT RESERVED
</div>
</body>
<!-- InstanceEnd --></html>
