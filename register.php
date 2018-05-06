<!-- register.php - registracny formular -->
<?php
session_start();
include('db.php');
include('functions.php');
head_func();
include('nav.html');
navigation('');
 ?>

 <section>

   <?php

   $zobraz_form = true;

   if (isset($_POST['register_but']) && //ak bolo stlacene tlac. "Zaregistruj ma"
       isset($_POST['email']) && nazov_ok($_POST['email']) &&
       isset($_POST['pass']) && nazov_ok($_POST['pass']) &&
       isset($_POST['pass2']) && nazov_ok($_POST['pass2']) &&

   	$_POST['pass2'] == $_POST['pass'] &&
       // rovnaju su "nove heslo" a "nove heslo (znovu)" ???

       isset($_POST['name']) && nazov_ok($_POST['name']) &&


       isset($_POST['surname']) && nazov_ok($_POST['surname'])
       //&& isset($_POST['admin']) && in_array($_POST['admin'], array('1', '0')) // vymenovanie admina - DOROBIT neskor!
     ){


   // pridanie používateľa
   	if (pridaj_pouzivatela()) $zobraz_form = false;
   } else {
   	if (isset ($_POST['register_but'])) {
   		echo '<p class="chyba">Nezadali ste všetky údaje, resp. nemajú správny formát!</p>';
   		if ($_POST['pass'] != $_POST['pass2'])
   			echo '<p class="chyba">Nezadali ste 2x rovnaké nové heslo!</p>';
   	}
   }

   if ($zobraz_form) {
   ?>
   	<p style="color: gray;">Všetky údaje sú povinné</p>
    <form method="post">
    <fieldset>
        <legend>Vyplňte vaše údaje</legend>
        <table id='register_table'>
   		<tr><td>Prihlasovacie meno:</td>
        <td><input name="email" type="text" size="30" maxlength="35" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>"></td></tr>
   		<tr><td>Heslo (3-30 znakov):</td>
   		<td><input name="pass" type="password" size="30" maxlength="30" id="pass"></td><tr>
   		<tr><td>Heslo (znovu):</td>
        <td><input name="pass2" type="password" size="30" maxlength="30" id="pass2"></td></tr>
   		<tr><td>Meno:</td>
   		<td><input type="text" name="name" id="name" size="20" value="<?php if (isset($_POST['name'])) echo $_POST['name'] ?>"></td></tr>
   		
   		<tr><td>Priezvisko:</td>
   		<td><input type="text" name="surname" id="surname" size="30" value="<?php if (isset($_POST['surname'])) echo $_POST['surname'] ?>"></td></tr>
        </table>
        <p>
   			<input type="submit" name="register_but" id="register_but" value="Zaregistruj ma">
        </p>
    </fieldset>
   	</form>
   <?php
 } else {
   // Tu by sa mohlo zobrazit nejake rozhranie pre administraciu stranky (pre mna)
   // ci je prihlaseny nejaky pouzivatel (typu administrator)
   //	echo '<p><strong>K tejto stránke nemáte prístup.</strong></p>';
 }



   ?>


</section>
