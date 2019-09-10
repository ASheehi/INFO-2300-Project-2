<header>
    <?php
        function makeNav ($pageArr){
          $current_file = basename($_SERVER['PHP_SELF']);
          foreach ($pageArr as $page){
            if ($page[0] == $current_file){
              echo("<li class = active><a href=\"" . $page[0] . "\">" . $page[1] . "</a></li>");
            }
            else
              echo("<li><a href=\"" . $page[0] . "\">" . $page[1] . "</a></li>");
          }
        }
    ?>

    <div id = "title">

        <div id ="logo">
            <!-- Source: (original work) Anthony Sheehi -->
            <img src ="images/logo.PNG" alt="logo" width="600" height="160">
        </div>
        <div id = "info">
            <h2>(123) 456-7890</h2>
            <h2>123 Main St, Ithaca, NY 14853</h2>
        </div>
    </div>
    <nav id = "menu">
        <ul>
        <?php
            $pages = [array("index.php", "Home"), array("gameBase2.php", "Game Database"), array("about.php", "About")];
            makeNav($pages);
        ?>
        </ul>
    </nav>
</header>
