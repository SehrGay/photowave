<?php
include("includes/header-include.php");
echo '
<div class="cleared reset-box"></div>
<div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
<div class="art-box art-post">
    <div class="art-box-body art-post-body">
<div class="art-post-inner art-article">
                                <h2 class="art-postheader">Login
                                </h2>
                                                <div class="art-postcontent">
<div class="art-content-layout">
    <div class="art-content-layout-row">
    <div class="art-layout-cell layout-item-0" style="width: 100%;">
        <p>
		
';
$_db_host = "localhost";            # meist localhost
$_db_datenbank = "asameli_guestbook";
$_db_username = "samelidb";
$_db_passwort = "admin123-!";

SESSION_START();

# Datenbankverbindung herstellen
$link = mysql_connect($_db_host, $_db_username, $_db_passwort);

# Hat die Verbindung geklappt ?
if (!$link)
	{
	die("Keine Datenbankverbindung m�glich: " . mysql_error());
	}

# Verbindung zur richtigen Datenbank herstellen
$datenbank = mysql_select_db($_db_datenbank, $link);

if (!$datenbank)
	{
	echo "Kann die Datenbank nicht benutzen: " . mysql_error();
	mysql_close($link);        # Datenbank schliessen
	exit;                    # Programm beenden !
	}

##################################################################

# Ist die $_POST Variable submit nicht leer ???
# dann wurden Logindaten eingegeben, die m�ssen wir �berpr�fen !
if (!empty($_POST["send"]))
	{
	echo '<br />Submit!<br />';
	# Die Werte die im Loginformular eingegeben wurden "escapen",
	# damit keine Hackangriffe �ber den Login erfolgen k�nnen !
	# Mysql_real_escape ist auf jedenfall dem Befehle addslashes()
	# vorzuziehen !!! Ohne sind mysql injections m�glich !!!!
	$_username = mysql_real_escape_string($_POST["username"]);
	$_passwort = mysql_real_escape_string(md5($_POST["password"]));

	# Befehl f�r die MySQL Datenbank
	$_sql = "SELECT * FROM tblUser WHERE
				Mail='$_username' AND
				Password='$_passwort'
			LIMIT 1";

	# Pr�fen, ob der User in der Datenbank existiert !
	$_res = mysql_query($_sql, $link);
	$_anzahl = @mysql_num_rows($_res);

	# Die Anzahl der gefundenen Eintr�ge �berpr�fen. Maximal
	# wird 1 Eintrag rausgefiltert (LIMIT 1). Wenn 0 Eintr�ge
	# gefunden wurden, dann gibt es keinen Usereintrag, der
	# g�ltig ist. Keinen wo der Username und das Passwort stimmt
	# und user_geloescht auch gleich 0 ist !
	if ($_anzahl > 0)
		{
		echo "Der Login war erfolgreich.<br>";

		# In der Session merken, dass der User eingeloggt ist !
		$_SESSION["login"] = 1;

		# Den Eintrag vom User in der Session speichern !
		$_SESSION["user"] = mysql_fetch_array($_res, MYSQL_ASSOC);

		# Das Einlogdatum in der Tabelle setzen !
		#$_sql = "UPDATE login_usernamen SET letzter_login=NOW()
		# 		 WHERE id=".$_SESSION["user"]["id"];
		mysql_query($_sql);
		}
	else
		{
		echo "Die Logindaten sind nicht korrekt.<br>";
		}
	}

# Ist der User eingeloggt ???
if ($_SESSION["login"] == 0)
	{
	# ist nicht eingeloggt, also Formular anzeigen, die Datenbank
	# schliessen und das Programm beenden
	# include("login.php");
	mysql_close($link);
	exit;
	}

# Hier w�re der User jetzt g�ltig angemeldet ! Hier kann
# Programmcode stehen, den nur eingeloggte User sehen sollen !!
echo "Hallo, Sie sind erfolgreich eingeloggt !<br>";

##################################################################

# Datenbank wieder schliessen
mysql_close($link);

##################################################################

/*
$temp = $_SESSION["user"];
foreach($temp as $user => $name)
	echo $name.'<br />';
*/

# Variablen definieren
$temp = $_SESSION["user"];

$_SESSION["userid"] = $temp["UserID"];
$_SESSION["nachname"] = $temp["Name"];
$_SESSION["vorname"] = $temp["Vorname"];
$_SESSION["titel"] = $temp["Titel"];
$_SESSION["mail"] = $temp["Mail"];
$_SESSION["groupid"] = $temp["GroupID"];



echo 'User: '.$_SESSION["userid"];
echo 'Nachname: '.$_SESSION["nachname"];
echo 'Vorname: '.$_SESSION["vorname"];
echo 'Titel: '.$_SESSION["titel"];
echo 'Mail: '.$_SESSION["mail"];
echo 'Group: '.$_SESSION["groupid"];


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