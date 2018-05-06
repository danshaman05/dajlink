<?php
session_start();

include('db.php');
include('functions.php');

head_func(); // funkcia zobrazi hlavicku + login
navigation('index.php');

?>

      <section class='index'>
        <!-- refresh button:
         <input type="button" value="Refresh Page" onClick="window.location.reload()"> 
        --> 
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
                <!--
                <a href="https://moodle.uniba.sk/moodle/inf11/course/index.php?categoryid=132" style="color: grey; border-color: grey;">Moodle</a>
                <a id="list" href="http://capek.ii.fmph.uniba.sk/list">L.I.S.T</a>
-->
            </div>

            <p class='index_number'>3</p>
            <div class='index' id="div3">
            <?php
                print_cubes(3);
            ?>
<!--
                <a id="projekt" href="http://www.sccg.sk/~lucan/" title="Ročníkový projekt 1">Ročníkový projekt 1</a>
                <a id="sachovnica" href="php/sachovnica.php">PHP sachovnica</a>

                <a id="codebunk" href="https://codebunk.com/b/268127069/">Codebunk</a>
                <a id="repl" href="https://repl.it/" title="Tu mozes kodit v C-cku a Pythone online">Repl.it</a>
                <a id="tutor" href="http://www.pythontutor.com/live.html#mode=edit" title="PythonTutor.com">Python Tutor Live</a>
		<a id="votr" href="https://votr.uniba.sk/" title="lepsi AIS">Votr</a>
		<a id="moja-uniba" href="https://moja.uniba.sk/">moja.uniba.sk</a>
-->    
        </div>

      </section>
<?php
footer_func('index');
?> 
            
   </body>
</html>

