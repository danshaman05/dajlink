<?php

session_start();

include('db.php');
include('functions.php');

head_func();
navigation('odkazy.php');

    if (isset($_POST['message'])){
        
        $text = $_POST['message'];
        $predmet = $_POST['predmet']; #berie zo selectu, kt. je vo funkcii vypis_select_comment_categories
        /* // POZOR: Funkcia message_ok je docasne vypnuta! //////////////
        
        if (message_ok($text)){
            add_message($text, $predmet);
            header("Location: odkazy.php");
        } else echo "<p class='chyba'>Chybne zadaná správa! Správa musí mať minimálne 3 a maximálne 650 znakov.</p>"; */
        add_message($text, $predmet);
        header("Location: odkazy.php"); // POZOR: Header musi byt nad vsetkymi vypismi!
    }
?>
<section id='messages_section'>

<?php

print_messages();
?>
</section>
<?php 
if (isset($_SESSION['email'])) {
?>
<aside id='aside_messages'>
        <?php
    ?>
    
    <form method="post">
        <fieldset>
         <legend>Pridaj odkaz:</legend>
            <p>predmet: <?php vypis_select_comment_categories(); ?></p>
                <textarea name="message" cols="50" rows="4" id="message" maxlength="650" ></textarea>
            </p>
            <p>
                <input name="submit" type="submit" id="submit" value="Pridaj odkaz">
            </p>
        </fieldset>
    </form>

</aside>

<?php
}
footer_func();
//include('footer.html');
?>

