<?php
session_start();

include('db.php');
include('functions.php');

head_func(); // funkcia zobrazi hlavicku + login
navigation('index.php');

?>

      <section class='index'>
            <p class='index_number'>1</p>
            <div class='index' id="div1">
                <?php
              #  if (isset($_SESSION['email']) || isset($_POST['add_cube'])) {
                   //echo "user_ID:"  .  "{$_SESSION['user_id']}";
              #      print_cubes();
              #  } else {
                    // echo "nacitavam default cubes";
                   //echo "user_ID:"  .  "{$_SESSION['user_id']}";
                    print_cubes(1);
              #  }
            ?>
            </div>

            <p class='index_number'>2</p>
            <div class='index' id="div2">
                <?php
                print_cubes(2);
                ?>
            </div>

            <p class='index_number'>3</p>
            <div class='index' id="div3">
            <?php
                print_cubes(3);
            ?>
        </div>

      </section>
<?php
footer_func('index');
?> 
            
   </body>
</html>

