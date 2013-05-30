<?php
include 'includes/config.php';
$menu_active = 'Gästebuch';
include 'includes/header-include.php';
echo 'rtrt
<div class="cleared reset-box"></div>
<div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
                                <h2 class="art-postheader">Gästebuch
                                </h2><br />
                                                <div class="art-postcontent">
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell layout-item-0" style="width: 100%;">
';
/* header('<script type="text/javascript" src="ckeditor/ckeditor.js"></script>'); */

$db = mysql_connect('localhost', 'photowave_prod', 'Bue3vV-phYa!8twT4pOPfBWwW2') or die('Fehler beim Verbinden zum MySQL-Server');


$sql = "SELECT u.Mail, u.Name, u.Vorname, b.BeitragID, b.Beitrag, b.Datum, b.IP
		FROM tblUser AS u JOIN tblBeitraege AS b
		ON u.UserID = b.UserID
		ORDER BY Datum";

mysql_select_db('photowave_prod', $db) or die ("Datenbank kann nicht ausgewählt werden");
						 $ergebnis = mysql_query($sql)
						 	or die('Fehler bei der Datenbankabfrage');
						
							echo ("<table border=\"1\" width=\"100%\">");
							echo ("<tr>");
							echo ("<td><b>Beitrag</b></td>");		
							echo ('<td width="150"><b>Informationen</b></td>');
							if($_SESSION["groupid"] == 1)
								echo ('<td width="100"><b>Edit</b></td>');
							echo ("</tr>");		
						 	
						while ($zeile = mysql_fetch_array($ergebnis)) {
						$beitragsid = $zeile['BeitragID'];
    					$beitrag = $zeile['Beitrag'];
    					$datum = $zeile['Datum'];
   						$ip = $zeile['IP'];
						$username = $zeile['Mail'];
						$nachname = $zeile['Name'];
						$vorname = $zeile['Vorname'];
										
						echo ("<tr>");			
						echo ("<td>$beitrag</td>");
						echo ("<td>$username</td>");
						if($_SESSION["groupid"] == 1 or $username == $_SESSION["mail"])
						{
							echo ('<td>
								   <FORM METHOD="post" ACTION="guestbook.php?b='.$beitragsid.'">
								   <INPUT TYPE="submit" VALUE="edit">
								   <input type="submit" name="del" value="del">
								   <input type="hidden" name="beitragid" value="'.$beitragsid.'">
								   </FORM></td>');
						}
						echo ("</tr>");					 
  							}
						
						echo("</table>");
						// Löschen
						if(isset($_POST["del"]))
							{
								//$db = mysql_connect('localhost', 'photowave_prod', 'Bue3vV-phYa!8twT4pOPfBWwW2') or die('Fehler beim Verbinden zum MySQL-Server');
	
	
									$sql = 'DELETE FROM tblBeitraege 
											WHERE BeitragID = "'.$_POST["beitragid"].'"';
									
									mysql_select_db('photowave_prod', $db) or die ("Datenbank kann nicht ausgewählt werden");
															 $ergebnis = mysql_query($sql)
																or die('Fehler bei der Datenbankabfrage');
									$url = $_SERVER['PHP_SELF'];
									echo '<script type="text/javascript">';
									echo 'window.location.href="'.$url.'";';
									echo '</script>';
									echo '<noscript>';
									echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
									echo '</noscript>';
								
								echo 'Lösche '.$_POST["beitragid"].'<br />';
							}
  				   		    mysql_close($db);				

if(isset($_SESSION["userid"]))
	include("includes/ckeditor-include.php");
echo '      
    </div>
    </div>
</div>

                </div>
                <div class="cleared"></div>
                </div>

		<div class="cleared"></div>
    </div>
</div>';

include("includes/sidebar-include.php");
include("includes/footer-incude.php");

?>
