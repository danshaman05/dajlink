<?php
#tato stranka sa zobrazuje len administratorovi

session_start();

include('db.php');
include('functions.php');
head_func();
navigation('uprav.php');
?>
<section>
<?php

if (isset($_SESSION['email'])){
echo "<h3>Nastavenia</h3>";

#tu bude sprava default_cubes - pridavanie, odstranovanie, zmena nazvu, URL
#tiez tu bude sprava userovej tabulky
#vypise sa tabulka s kockami
#v kazdom riadku bude 1 kocka, - nazov, url, (farba), kategoria (ktory div)

if ($_SESSION['admin']){ #ak je admin 1
    echo "<p class='chyba'>Vitaj ADMIN! <br>Upravujes defaultnu tabulku rozcestnik_cubes!</p>"; #nie je to chyba, ale len chcem aby bol vypis cervenou
} else {
    echo "<p class='oznam'>Nižšie si môžeš vytvoriť a spravovať vlastné kocky, ktoré sa ti zobrazia iba pri prihlásení (ak sa neprihlásiš, budeš vidieť kocky určené pre študenta odboru AIN na FMFI UK.</p>";
}
?>
<?php
add_cube();
edit_cubes(); #vypise v tabulke kocky 
?>
</section>
<aside id='uprav-navod'>
 <h3>Návod</h3>
    <div id='edit-info-new_cube'> 
        <fieldset>
        <legend>Nová kocka</legend>
        Slúži na pridanie novej kocky.
        </fieldset>
    </div>
    <div id='edit-info-edit_cubes'> 
        <fieldset>
        <legend>Uprav kocky</legend>
        V tejto tabulke mozes upravovat svoje kocky.
        <ol>
            <li><span>Zobraz / Skry</span> - zobrazí / skryje kocku. </li>
            <li><span>Vymaž</span> - zmaže kocku natrvalo.</li>
        </ol>
        </fieldset>
    </div>
</aside>
<?php
} else {
    echo "<p>K tejto stránke majú prístup iba registrovaní používatelia.</p>";
}
echo "</section>";
include('aside.php');
footer_func('index');
//include('footer.html');
?>
