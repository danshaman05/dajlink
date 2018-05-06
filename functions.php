<?php

function head_func(){
	?>
	<!DOCTYPE html>
	<html lang="sk">
	   <head>
	      <meta charset="utf-8">
	      <title>Daniel Grohol</title>
	      <link rel="stylesheet" href="style-full.css" media="all" />
	      <link rel="stylesheet" href="style-mini.css" media="screen and (max-device-width:482px)" />
	      <!-- <script src="script.js"></script> -->

              <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine"> <!-- Edited 23.4.2018 -->
              <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+sans"> <!-- Edited 23.4.2018 -->
	   </head>
	   <body>

      <header>
		<a href="index.php"><img src="img/mensi.png" alt="logo" id="logo"></a> 
        <a href="index.php" id="site_name">Rozcestník matfyzáka</a>

     <div id='login'>
    <?php
       ################ PRIHLASOVANIE USERA: ##########################################    
       if ( isset($_POST['login_but']) && isset($_POST['email']) && isset($_POST['pass']) ){   // ak bol odoslany login formular 

        $email = $_POST['email'];
        $pass = $_POST['pass'];

            if  ( nazov_ok($email) && nazov_ok($pass) && ( $user = check_user($email, $pass) )   ) { // ochrana proti SQL injection a potom hlada usera v DB

               //$_SESSION['email'] = $user['email'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['admin'] = $user['admin'];
                $_SESSION['user_table'] = $user['user_table']; #zapamata sa tabulka daneho usera (jej nazov)
                
            }
       } elseif (isset($_POST['logout_but'])) { // ak bol odoslany formular s odhlasenim

				session_unset();
                session_destroy();
                header("Location: index.php"); # po stlaceni "Odhlas" tlacidla sa presmeruje na index.php (nemoze ostat na uprav.php!) 

			}

			if (isset($_SESSION['email'])) { //ak sa user prihlasil
                ?>
                <!-- <div id='logout'> -->
                    
                    <p>Vitajte v systéme <strong><?php echo $_SESSION['email'];?></strong>.</p>
                    <form method="post">
                    <p>
                         <input type="submit" name="logout_but" id="logout_but" value="Odhlás ma"> <!-- logout_but - odhlasovacie tlacidlo -->
                    </p>
                    </form>
			<?php

			}  else { // ak nikto nie je prihlaseny
			?>

			<form method="post">
			 <table>
				<tr>
				 <td><label for="email">Email:</label></td>
				 <td><label for="pass">Heslo:</label></td>
				 <td><a href="register.php">Registrácia</a></td>
				</tr>
				<tr>
				 <td><input type="text" name="email" id="email"></td>
				 <td><input type="password" name="pass" id="pass"></td>
				 <td><input type="submit" name="login_but" id="login_but" value="Prihlás ma"></td>
				</tr>


			 </table>
			 </form>

			<?php
			}
			?>
			<!-- tieto 3 dalsie riadky sa musia vypisat vzdy!-->

		</div>
	</header>
	<?php
	}

function footer_func($class=''){
    echo "<footer class='" . $class . "'>";
    echo "<p>2017&copy;, Daniel Grohoľ</p>";
    echo "</footer>";
}

// vrati udaje pouzivatela ako asociativne pole, ak existuje pouzivatel $username s heslom $pass, inak vrati FALSE
function check_user($email, $pass){
	global $mysqli;
    if (!$mysqli->connect_errno) {
            $sql = "SELECT * FROM rozcestnik_users WHERE email='$email' AND pass=MD5('$pass')";  // definuj dopyt
    //	    "sql = $sql <br/>";
            if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {  // vykonaj dopyt
                $row = $result->fetch_assoc();
                $result->free();
                return $row;
            } else {
                echo '<p class="chyba">Meno alebo heslo je nespravne!</p>';// dopyt sa NEpodarilo vykonať, resp. používateľ neexistuje!
                return false;
            }
	} else {
		echo '<p class="chyba">Chyba - Nespojil som sa s databazou!</p>';// NEpodarilo sa spojiť s databázovým serverom!
		return false;
	}
}


function nazov_ok ($nazov) {  // osetri vstup aby neobsahoval nebezpecne znaky - strip_tags funkcia; trim - vyhodi medzery
	$nazov = addslashes(strip_tags(trim($nazov)));
	return strlen($nazov) >= 3 && strlen($nazov) <= 100; //meno vstupu musi mat min 3 znaky
}

/*
// Docasne nefunkcne 
function message_ok ($message) {  // osetri vstup aby neobsahoval nebezpecne znaky - strip_tags funkcia; trim - vyhodi medzery
	$message = addslashes(strip_tags(trim($nazov)));
        echo $message;// DEBUG MESSAGE!!!!!!!!!!!!!!!!
	return strlen($message) >= 3 && strlen($nazov) <= 650; //
}*/

function pridaj_pouzivatela() {
	global $mysqli;
	if (!$mysqli->connect_errno) {
		$email = $mysqli->real_escape_string($_POST['email']); // real_escape_string - osetri vstup pre SQL databazu
		$pass = $mysqli->real_escape_string($_POST['pass']);
		$name = $mysqli->real_escape_string($_POST['name']);
		$surname = $mysqli->real_escape_string($_POST['surname']);
		//$admin = isset($_POST['admin']) && ($mysqli->real_escape_string($_POST['admin']) == '1') ? 1 : 0;  // nastavenie admina - dorobit neskor!

		$sql = "INSERT rozcestnik_users SET email = '$email', pass = MD5('$pass'),
		 name = '$name', surname = '$surname', admin='0'"; // definuj dopyt

		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			                                   // dopyt sa podarilo vykonať

            $user_id = $mysqli->insert_id; //naposledy vlozeny uzivatel - jeho id

            $sql_user = "CREATE TABLE user" . $user_id . " ( cube_id TINYINT(4) NOT NULL AUTO_INCREMENT, url VARCHAR(120) NOT NULL , name VARCHAR(40) NOT NULL , title VARCHAR(30) NULL , color VARCHAR(20) NOT NULL, visible TINYINT(1) NOT NULL, category TINYINT(1) NOT NULL, PRIMARY KEY (cube_id)) ENGINE = InnoDB";

            zapis_user_table($user_id);

            if ($newtable = $mysqli->query($sql_user)) { //ak uspesne vytvorilo tabulku pre usera ($newtable je 1)
                // echo "Tabulka $newtable bola vytvorena." . "\n"; //test ci vytvori tabulku
                $sql_copy = "INSERT INTO user$user_id SELECT * FROM rozcestnik_cubes"; //dopyt - kopia defaultnej tabulky
                if ($copy_ok = $mysqli->query($sql_copy)) {
                  //  echo "Kopia hotova."; //ak sa kopia podarila
                } else  { echo '<p class="chyba">Kopirovanie z defaultnej tabulky zlyhalo. Kontaktujte administratora.</p>'; }

            } else {echo '<p class="chyba">Nepodarilo sa vytvorit tabulku uzivatela. Kontaktujte administratora.</p>'; }

	                echo '<p>Vitaj nový člen!</p>' . "\n" . '<p>Som rád, že si súčasťou tohto skvelého projektu! Teraz sa môžeš prihlásiť.</p>' . "\n";
			return true;
	 	} else {
                        // echo $sql;
			// NEpodarilo sa vykonať dopyt!
			echo '<p class="chyba">Nastala chyba pri pridávaní používateľa, kontaktujte prosím administrátora na: dany05@email.cz';

                        //printf("Connect failed: %s\n", $mysqli->connect_errno); // pre vypisanie danej chyby

                        // kontrola, či nenastala duplicita kľúča (číslo chyby 1062) - prihlasovacie meno už existuje
			if ($mysqli->errno == 1062) echo ' (zadané prihlasovacie meno už existuje)';

			echo '.</p>' . "\n";
			return false;
	        }
	} else {
		// NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
		echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
		return false;
	}
}	// koniec funkcie

/*
function add_usertable() { //vytvori tabulku pre pouzivatela

    $sql = "CREATE TABLE " . $_"";
}
 */

function zapis_user_table($user_id){
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "UPDATE rozcestnik_users SET user_table='user" . $user_id . "' WHERE user_id=$user_id";
        if (!$result = $mysqli->query($sql)){
            echo "<p id='chyba'>zapis_user_table: Dopyt sa nepodaril!</p>";
        }
    }
}

function print_cubes($category) { #category = 1 -primary, 2 - secondary, 3 -others
    $src = isset($_SESSION['user_table']) ? $_SESSION['user_table'] : "rozcestnik_cubes";
    global $mysqli;
    if (!$mysqli->connect_errno) {

        $sql = "SELECT * FROM $src WHERE visible='1' AND category=$category";
        if ($result = $mysqli->query($sql)) { //vykonaj dopyt

            while ($row = $result->fetch_assoc()){
                echo "<a target='_blank' id='" . $row['cube_id'] . "' href='" . $row['url'] . "'>" . $row['name'] ."</a>";
            }
        } else { echo '<p class="chyba">Kocky: Dopyt sa nepodaril ' .  // dopyt sa nepodaril
           // "Chyba: " . $mysqli->error;  //defaultne nezobrazujeme chyby
            ".</p>";
        }
    }

}


function add_cube(){
    if (isset($_SESSION['email'])) {
        ?>
        <div id='add_cube'>
          <form method="post">
              <fieldset>
                <legend>Nová kocka</legend>
                 <table>
                  <tr>
                   <td><label for="url">URL:</label></td>
                   <td><input type="text" name="url" id="url"></td>
                  </tr>
                  <tr>
                   <td><label for="cube_name">názov:</label></td>
                   <td><input type="text" name="cube_name" id="cube_name"></td>
                  </tr>
                  <tr>
                   <td><label for="type">úroveň:</label></td>
                   <td><?php vypis_select_cube_categories(); ?> <!-- <input type="" name="type" id="cube_type"> --> </td>
                  </tr>
                  <tr>
                   <td></td>
                   <td><input type="submit" name="add_cube" id="add_cube" value="Pridaj kocku"></td>
                  </tr>
               </table>
              </fieldset>

           </form>
        </div>

        <?php
        global $mysqli;
        if (isset($_POST['add_cube'])) { //ak bol odoslany formular add_cube
            $url = $mysqli->real_escape_string($_POST['url']);
            $cube_name = $mysqli->real_escape_string($_POST['cube_name']);
            $type = $_POST['type'];

            $sql = "INSERT INTO {$_SESSION['user_table']} SET name='$cube_name', url='$url', visible=1, category='$type'";

            if($result = $mysqli->query($sql)) {
                header("Location: uprav.php");
                exit;
            } else {
              echo "add_cube: dopyt nebol uspesny. Kontaktujte administratora.";
              //echo  "Cislo chyby:" . $mysqli->errno;
            }
      }
    }
}

function vypis_select_cube_categories(){ #pouzita v add_cube
    echo "<select name='type'>";
    for($i = 1; $i <= 3; $i++) {
        echo "<option value='$i'";
        if ($i == 1) echo ' selected';
        echo ">$i</option>\n";
    }
    echo "</select>";
}

function vypis_select_comment_categories(){ #pouzita v add_comment #vytiahne a vypise vsetky predmety z DB
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "SELECT * FROM rozcestnik_predmety";
        if ($result = $mysqli->query($sql)){
            echo "<select name='predmet'>";
            while ($row = $result->fetch_assoc()){
                echo "<option value='{$row['pid']}'>{$row['predmet']}</option>\n";
            }
            echo "</select>";
        }
    }
}

function edit_cubes() { #pre stranku Uprav.php
    global $mysqli;
    if (!$mysqli->connect_errno){
        if (isset($_POST['update'])) { #   && isset($_POST['visible'])){   #ak stlaci aktualizuj tlacidlo, tak sa spusta funkcia, kt. nastavuje v database viditelnost danej kocky 
            #print_r($_POST['visible']);
            foreach ($_POST['visible'] as $cube_id => $value){
                set_visibility( $cube_id, $value); #parameter je pole kde keys su id predmetov a hodnoty su 1 ak je nastaveny visible a 0 ak nie
            }
            #echo "var dump";
        }

        if ( isset($_POST['delete'])){ #delete - pole checkboxov na mazanie; Ide sa mazat
            #print_r($_POST['cubes']);
            foreach($_POST['delete'] as $value){
                delete_cube($value); #src je string - nazov tabulky z kt. ma mazat
            } 
        }

        if (isset($_POST['url'])){
            #print_r($_POST['url']);
            foreach($_POST['url'] as $cube_id => $value){ #treba este pouzit osetrenie pre vstup do databazy - mysql_real_escape_string
                $value = $mysqli->real_escape_string($value);
                update_cube_url($cube_id, $value);
            }
        }

        $sql = "SELECT * FROM {$_SESSION['user_table']}";
        #echo $sql;
        if ($result=$mysqli->query($sql)){

            #echo "<h2>Tvoje kocky:</h2>";
            echo "<div id='edit_cubes'>";
            echo "<form method='post'>";
            echo "<fieldset>";
            echo "<legend>Uprav kocky:</legend>";
            echo "<table id='edit_cubes_table'>";
            echo "<tr><th>názov</th><th>URL</th><th>zobraz / skry</th><th>vymaž</th></tr>"; 
            while ($row=$result->fetch_assoc()){
                $cube_id = $row['cube_id'];
                $checked = ($row['visible']) ?  "checked" : ''; #ak je kocka nastavena v DB ako visible, tak sa zaskrtne dany checkbox
                $unchecked = ($row['visible'] == 0) ? "checked" : '';
                echo "<tr><td>{$row['name']}</td><td><input type='text' name=url[$cube_id] value={$row['url']}></td><td><input type='radio' name='visible[$cube_id]' id='z' value='1' " . $checked . "><label for='z'>Z</label><input type='radio' name='visible[$cube_id]' id='s' value='0' $unchecked ><label for='s'>S</label></td><td><input type='checkbox' name='delete[]' value='". $row['cube_id'] ."'></td></tr>"; #do pola cubes[] sa ulozia id kociek (kt. su vo value)
            }
            echo "</table><br>";
            echo "<input type='submit' name='update' id='edit_cubes_button' value='OK'>";
            echo "</fieldset>";
            echo "</form>";
            echo "</div>";
        } else echo "<p class='chyba'>edit_cubes: Dopyt sa nepodaril.</p>";

    } else "<p class='chyba'>edit_cubes: Pripojenie k DB zlyhalo.</p>";

    ?>

    <?php

}

function update_cube_url($cube_id, $value){
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "UPDATE {$_SESSION['user_table']} SET url='$value' WHERE cube_id=$cube_id";
        if (!$result= $mysqli->query($sql)){
            echo "<p class='chyba'>update_cube_url: Dopyt zlyhal!</p>" . $mysqli->error;  #ak sa nepodaril dopyt
        }     
    }
}

function set_visibility( $cube_id, $value ){ #parameter je pole kde keys su id predmetov a hodnoty su 1 ak je nastaveny visible a 0 ak nie
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "UPDATE {$_SESSION['user_table']} SET visible=$value WHERE cube_id=$cube_id";
        if ($result= $mysqli->query($sql)){
        } else echo "<p class='chyba'>set_visibility: Dopyt zlyhal!</p>";
    }
}


function delete_cube($cube_id){ #pouziva sa v edit_cubes na stranke Uprav.php
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "DELETE FROM {$_SESSION['user_table']} WHERE cube_id=$cube_id";
        if ($result = $mysqli->query($sql)){
            //echo "podarilo sa mazanie";
            }
    } else echo "<p class='chyba'>nepodarilo sa mazanie!</p>";
}

function add_message($text, $predmet){
    global $mysqli;
    if (!$mysqli->connect_errno){
        $text = $mysqli->real_escape_string($text);
        $sql = "INSERT INTO rozcestnik_messages (uid, text, predmet) VALUES({$_SESSION['user_id']}, '$text', $predmet)";
        if ($result = $mysqli->query($sql)){
            //echo "funguje";
            }
    } else echo "<p class='chyba'>add_message: nepodarilo sa pridanie do tabulky!</p>";

}

function print_messages(){ #pre stranku odkazy.php
    global $mysqli;
    if (!$mysqli->connect_errno){
        
        //tu sa riesi mazanie vlastnych sprav (pomocou checkboxov)
        if (isset($_POST['delete_messages'])){ //maze spravy, ktorych chceckbox bol zaskrtnuty
            //print_r($_POST['delete']);
            foreach ($_POST['delete'] as $mid){
                delete_message($mid);
            }
        }
        //

        $sql = "SELECT * FROM rozcestnik_messages WHERE status='1' ORDER BY cas DESC";
        if ($result = $mysqli->query($sql)){
            echo "<form method='post'>";
            echo "<input type='submit' name='delete_messages' value='Zmaž označené správy' id='delete_messages_butt'>";
            while ($row = $result->fetch_assoc()){
                $subject_name = get_subject_name($row['predmet']); #nazov predmetu (napr Programovanie)
                $from = get_uid_name($row['uid']); #from je pole - obsahuje meno a priezvisko odosielatela spravy
                echo "<div class='message{$row['predmet']}'>";
                //
                if ( (isset($_SESSION['admin']) && ($_SESSION['admin'])  ) || (isset($_SESSION['user_id']) && ($row['uid'] == $_SESSION['user_id'] ) ) ) echo "<input class='message_check' type='checkbox' name=delete[] value='" . $row['mid'] . "'>"; 
                echo "<p class='message_subject'>$subject_name</p>";
                echo "<p class='message_text'>{$row['text']}</p>";
                echo "<p class='message_time'>{$row['cas']}</p>";
                echo "<p class='message_uid'>od: {$from['name']} {$from['surname']}</p>";
                echo "</div>";
            }
            echo "</form>";
        }
    }
}


function delete_message($id){
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "DELETE FROM rozcestnik_messages WHERE mid='$id'";
        if (!$result = $mysqli->query($sql)){ //ak sa nepodarilo mazanie
            echo "delete_message: Dopyt zlyhal";
        } 
    }
}

function get_subject_name($subject_id){
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "SELECT predmet FROM rozcestnik_predmety WHERE pid=$subject_id";
        if ($result = $mysqli->query($sql)){
            if ($row = $result->fetch_assoc()){
                return $row['predmet'];
            }
        } echo "<p class='chyba'>get_uid_name: Zlyhal dopyt</p>";
    }
}

function get_uid_name($uid){ #vracia pole kde indexy su 'name' a 'surname' daneho usera
    global $mysqli;
    if (!$mysqli->connect_errno){
        $sql = "SELECT name, surname FROM rozcestnik_users WHERE user_id=$uid";
        if ($result = $mysqli->query($sql)){
            if ($row = $result->fetch_assoc()){
                return $row;
            }
        } echo "<p class='chyba'>get_uid_name: Zlyhal dopyt</p>";
    }
}

function navigation($selected){ #ak kliknem na link, prida sa mu trieda 'active' #parameter je dana strnaka na kt. sa nachadzam

?>
<nav>
<?php
    $nav = array("index.php"=>"Kocky", "odkazy.php"=>"Odkazy", "uprav.php"=>"Nastavenia"); #pole
    #if (isset($_SESSION['email'])){
        foreach ($nav as $page => $name){
            echo "<a href='$page'";
            if ($selected == $page) echo " class='active'";
            echo ">$name</a>";
        }
		#<!--<a id='python_tut' href="python.html">Python tutorial</a> -->
     #}
        ?>
</nav>

<?php
}


##################### momentalne nepouzivam: #############
function test_url($url) {
$url = 'http://www.domain.com/somefile.jpg';
$file_headers = @get_headers($url);
if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
    return false;
}
else {
    return true;
}
}



/*

function db_input_control($text){
    global $mysqli;
    $text = $mysqli->real_escape_string();
}
 */
?>
