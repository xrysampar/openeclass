<?php
/**=============================================================================
       	GUnet e-Class 2.0 
        E-learning and Course Management Program  
================================================================================
       	Copyright(c) 2003-2006  Greek Universities Network - GUnet
        A full copyright notice can be read in "/info/copyright.txt".
        
       	Authors:    Costas Tsibanis <k.tsibanis@noc.uoa.gr>
        	    Yannis Exidaridis <jexi@noc.uoa.gr> 
      		    Alexandros Diamantidis <adia@noc.uoa.gr> 

        For a full list of contributors, see "credits.txt".  
     
        This program is a free software under the terms of the GNU 
        (General Public License) as published by the Free Software 
        Foundation. See the GNU License for more details. 
        The full license can be read in "license.txt".
     
       	Contact address: GUnet Asynchronous Teleteaching Group, 
        Network Operations Center, University of Athens, 
        Panepistimiopolis Ilissia, 15784, Athens, Greece
        eMail: eclassadmin@gunet.gr
==============================================================================*/

/**===========================================================================
	auth.php
	@last update: 27-06-2006 by Stratos Karatzidis
	@authors list: Karatzidis Stratos <kstratos@uom.gr>
		       Vagelis Pitsioygas <vagpits@uom.gr>
==============================================================================        
	@Description: Platform Authentication Methods and their settings

 	This script displays the alternative methods of authentication 
	and their settings.

 	The admin can: - choose a method and define its settings

==============================================================================
*/

// LANGFILES, BASETHEME, OTHER INCLUDES AND NAMETOOLS
$langFiles = array('admin','about');
$require_admin = TRUE;
include '../../include/baseTheme.php';
include_once '../auth/auth.inc.php';
$nameTools = $langUserAuthentication;		// Define $nameTools

$tool_content = "";			// Initialise $tool_content

$auth = isset($_GET['auth'])?$_GET['auth']:"";
$active = isset($_GET['active'])?$_GET['active']:"";
if((!empty($auth)) && (!empty($active)))
{
	$s = get_auth_settings($auth);
	$settings = $s['auth_settings'];
	
	switch($active)
	{
		case 'yes': $q = empty($settings)?'0':'1';
		break;
		case 'no': $q = '0';
		break;
		default:	$q = '0';
		break;
	}
	$qry = "UPDATE auth SET auth_default=".$q." WHERE auth_id='".mysql_real_escape_string($auth)."'";
	if(!empty($qry))
	{
	$sql = mysql_query($qry,$db);		// do the update as the default method
	}
}
$auth_methods = get_auth_active_methods();

$tool_content .= "<table width=\"99%\">
<tr><td>";

if(empty($auth))
{
	$tool_content .= "������� ������ ������������:<br>";
	if(!empty($auth_methods))
	{
		$tool_content .= "<ul>";
		foreach($auth_methods as $k=>$v)
		{
			$tool_content .= "<li>".get_auth_info($v) . "</li>";
		}
		$tool_content .= "</ul>";
	}
}
else
{
	//$s = get_auth_settings($auth);
	//$settings = $s['auth_settings'];
	if(empty($settings))
	{
		$tool_content .= "H " . get_auth_info($auth) . " ��� ������ �� �������������,
		����� ��� ����� ��������� �� settings ����� ��� ������ ������������. ";
	}
	else
	{
		if($active == 'yes')
		{
			$tool_content .= "����� �������������� ��� " . get_auth_info($auth);
		}
		else
		{
			$tool_content .= "����� ���������������� ��� " . get_auth_info($auth);
		}
	}
}

$tool_content .= "</td></tr></table><br /><br />";

	
$tool_content .= "<table width=\"99%\">
<tr><td>";

//$tool_content .= "<form name=\"authmenu\" method=\"post\" action=\"auth_process.php\">
$tool_content .= $langChooseAuthMethod.":<br /><br />";

//$tool_content .= "<input type=\"radio\" name=\"auth\" value=\"2\">POP3&nbsp;&nbsp;";
$tool_content .= "POP3&nbsp;&nbsp;";
$tool_content .= in_array("2",$auth_methods)? "<a href=\"auth.php?auth=2&active=no\">".$langAuthDeactivate."</a>":"<a href=\"auth.php?auth=2&active=yes\">".$langAuthActivate."</a>";
$tool_content .= "&nbsp;&nbsp;<a href=\"auth_process.php?auth=2\">���������</a>";
$tool_content .= "<br />";
//$tool_content .= "<input type=\"radio\" name=\"auth\" value=\"3\">IMAP&nbsp;&nbsp;";
$tool_content .= "IMAP&nbsp;&nbsp;";
$tool_content .= in_array("3",$auth_methods)? "<a href=\"auth.php?auth=3&active=no\">".$langAuthDeactivate."</a>":"<a href=\"auth.php?auth=3&active=yes\">".$langAuthActivate."</a>";
$tool_content .= "&nbsp;&nbsp;<a href=\"auth_process.php?auth=3\">���������</a>";
$tool_content .= "<br />";
//$tool_content .= "<input type=\"radio\" name=\"auth\" value=\"4\">LDAP&nbsp;&nbsp;";
$tool_content .= "LDAP&nbsp;&nbsp;";
$tool_content .= in_array("4",$auth_methods)? "<a href=\"auth.php?auth=4&active=no\">".$langAuthDeactivate."</a>":"<a href=\"auth.php?auth=4&active=yes\">".$langAuthActivate."</a>";
$tool_content .= "&nbsp;&nbsp;<a href=\"auth_process.php?auth=4\">���������</a>";
$tool_content .= "<br />";
//$tool_content .= "<input type=\"radio\" name=\"auth\" value=\"5\">EXTERNAL DB&nbsp;&nbsp;";
$tool_content .= "EXTERNAL DB&nbsp;&nbsp;";
$tool_content .= in_array("5",$auth_methods)? "<a href=\"auth.php?auth=5&active=no\">".$langAuthDeactivate."</a>":"<a href=\"auth.php?auth=5&active=yes\">".$langAuthActivate."</a>";
$tool_content .= "&nbsp;&nbsp;<a href=\"auth_process.php?auth=5\">���������</a>";
$tool_content .= "<br />";
//$tool_content .= "<br /><input type=\"submit\" name=\"submit\" value=\"$langNextStep\"><br />";
//$tool_content .= "</form><br />";
$tool_content .="<br /></td></tr></table>";

draw($tool_content,3);
?>
