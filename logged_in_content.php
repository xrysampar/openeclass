<?PHP
/**===========================================================================
*              GUnet eClass 2.0
*       E-learning and Course Management Program
* ===========================================================================
*	Copyright(c) 2003-2006  Greek Universities Network - GUnet
*	A full copyright notice can be read in "/info/copyright.txt".
*
*  Authors:	Costas Tsibanis <k.tsibanis@noc.uoa.gr>
*				Yannis Exidaridis <jexi@noc.uoa.gr>
*				Alexandros Diamantidis <adia@noc.uoa.gr>
*
*	For a full list of contributors, see "credits.txt".
*
*	This program is a free software under the terms of the GNU
*	(General Public License) as published by the Free Software
*	Foundation. See the GNU License for more details.
*	The full license can be read in "license.txt".
*
*	Contact address: 	GUnet Asynchronous Teleteaching Group,
*						Network Operations Center, University of Athens,
*						Panepistimiopolis Ilissia, 15784, Athens, Greece
*						eMail: eclassadmin@gunet.gr
============================================================================*/

/**
 * Logged In Component
 *
 * @author Evelthon Prodromou <eprodromou@upnet.gr>
 * @version $Id$
 *
 * @abstract This component creates the content of the start page when the
 * user is logged in
 *
 */


$tool_content .= "<table cellpadding='4' width='99%' border='1' cellspacing='0'>";
$result2 = mysql_query("SELECT cours.code k, cours.fake_code c,
								cours.intitule i, cours.titulaires t, cours_user.statut s
								FROM cours, cours_user WHERE cours.code=cours_user.code_cours AND cours_user.user_id='".$uid."'
								AND (cours_user.statut='5' OR cours_user.statut='10')");
if (mysql_num_rows($result2) > 0) {
			$tool_content .= "<tr><td ><script type='text/javascript' src='modules/auth/sorttable.js'></script>
		      <table width='100%' cellpadding='0' cellspacing='1' valign=middle align=center style='border: 2px solid #FFFFFF;'>
          <tr><td class=color1 valign=middle style='border: 2px solid #FFFFFF;'><b>$langMyCoursesUser</b></td></tr>
					<tr><td>

    <table class='sortable' id='t1' cellpadding='0' cellspacing='0' align=center style='border: 2px solid #FFFFFF;'>";
	$tool_content .= "
    <thead>
	<tr>
	  <th>$langCourseCode</th>
	  <th width='30%'>$langProfessor</th>
	  <th width='5%'>$langUnCourse</th>
	</tr>
	</thead>";

// display courses
while ($mycours = mysql_fetch_array($result2)) {
         $dbname = $mycours["k"];
         $status[$dbname] = $mycours["s"];
         $tool_content .= "
	<tr onMouseOver=\"this.style.backgroundColor='#F5F5F5'\" onMouseOut=\"this.style.backgroundColor='transparent'\">";
         $tool_content .= "
	  <td height=25 style='border: 2px solid #FFFFFF;'>
	  <a href='${urlServer}courses/$mycours[k]' class=CourseLink>$mycours[i]</a>
	  <font color=#4175B9> ($mycours[c]) </font>
	  </td>
	  <td>$mycours[t]</td>
	  <td align=center><a href='${urlServer}modules/unreguser/unregcours.php?cid=$mycours[c]&u=$uid'>
	  <img src='template/classic/img/cunregister.gif' border='0' title='$langUnregCourse'></a>
	  </td>
	</tr>";
         }
				$tool_content .= "
	</table></td></tr></table>";

 }  else  {
           if ($_SESSION['statut'] == '5')  // if we are login for first time
           $tool_content .= "<tr><td style='border: 2px solid #FFFFFF;'>$langWelcomeStud</td></tr>\n";
} // end of if (if we are student)

// second case check in which courses are registered as a professeror
     $result2 = mysql_query("SELECT cours.code k, cours.fake_code c, cours.intitule i, cours.titulaires t, cours_user.statut s FROM cours, cours_user WHERE cours.code=cours_user.code_cours
				AND cours_user.user_id='".$uid."' AND cours_user.statut='1'");
        if (mysql_num_rows($result2) > 0) {
         $tool_content .= "<tr><td><br>
	<script type='text/javascript' src='modules/auth/sorttable.js'></script>
	<table width='100%' align='center'>
	<tr><td><b>$langMyCoursesProf</b></td></tr>
	<tr><td>
	    <table class='sortable' id='t1'>
		<thead>
	    <tr>
	      <th width='65%'>$langCourseCode</th>
		  <th width='30%'>$langProfessor</th>
	      <th width='5%'>$langManagement</th>
	    </tr>
		</thead>";

while ($mycours = mysql_fetch_array($result2)) {
             $dbname = $mycours["k"];
             $status[$dbname] = $mycours["s"];
	           $tool_content .= "
	    <tr onMouseOver=\"this.style.backgroundColor='#F5F5F5'\" onMouseOut=\"this.style.backgroundColor='transparent'\">";
             $tool_content .= "
	      <td><a class='CourseLink' href='${urlServer}courses/$mycours[k]'>$mycours[i]</a><font color=#4175B9> ($mycours[c])</font></td>
	      <td>$mycours[t]</span></td>
	      <td align=center valign=middle>
	      <a href='${urlServer}modules/course_info/infocours.php?from_home=TRUE&cid=$mycours[c]'>
	      <img src='template/classic/img/referencement.gif' border=0 title='$langManagement' align='absbottom'></img></a>
	      </td>
	    </tr>";
        }
	$tool_content .= '
	      </table>
          </td>
        </tr>
        </table>';
}  else {
         if ($_SESSION['statut'] == '1')  // if we are loggin for first time
         $tool_content .= "
        <tr><td>$langWelcomeProf</td></tr>\n";
} // if

$tool_content .= "
      </table>";
session_register('status');
?>
