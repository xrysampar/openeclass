<?php 
/**=============================================================================
       	GUnet e-Class 2.0 
        E-learning and Course Management Program  
================================================================================
       	Copyright(c) 2003-2006  Greek Universities Network - GUnet
        � full copyright notice can be read in "/info/copyright.txt".
        
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
	newuser_info.php
	@last update: 07-06-2006 by Stratos Karatzidis
	@authors list: Karatzidis Stratos <kstratos@uom.gr>
		       Vagelis Pitsioygas <vagpits@uom.gr>
==============================================================================        
        @Description: Check the available platform authentication methods

 	Purpose: The file checks for the available authentication methods of the platform
 	and displays them for a user to select

==============================================================================
*/

$langFiles = array('registration','gunet');
include '../../include/baseTheme.php';
include 'auth.inc.php';
if(isset($already_second)) {
	session_register("uid");
	session_unregister("statut");
	session_unregister("prenom");
	session_unregister("nom");
	session_unregister("uname");
}

$nameTools = $reguser;

$tool_content = "";		// Initialise $tool_content

// Main body
$tool_content .= "<table width=\"99%\">
<tr valign=\"top\" bgcolor=\"".$color2."\">
<td>";
// $auth = get_auth_id();
$auth = get_auth_active_methods();
$e = 1;
$tool_content .= "<ul>";
$tool_content .= "<li><a href=\"newuser.php\">������� ������ �� ".get_auth_info($e)."</a><br /></li>";
if(!empty($auth))
{
	foreach($auth as $k=>$v)
	{
		if($v!=1)
		{
			$tool_content .= "<li><a href=\"ldapnewuser.php?auth=".$v."\">������� ������ �� ".get_auth_info($v)."</a></li>";
		}
		else
		{
			continue;
		}
	}
}
$tool_content .= "<ul>";

$tool_content .= "</td></tr></table>";


$tool_content .= "<br />";

draw($tool_content,0);
?>