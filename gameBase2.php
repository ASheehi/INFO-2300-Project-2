<?php
include("includes/init.php");

// open connection to database
$db = open_sqlite_db("secure/data.sqlite");

// An array to deliver messages to the user.
$messages = array();

$ratingType = array("E", "E10+", "T", "M");

function print_record($record) {
  ?>
  <tr>
    <td><?php echo htmlspecialchars($record["game_title"]);?></td>
    <td><?php echo htmlspecialchars($record["platform"]);?></td>
    <td><?php echo htmlspecialchars($record["price"]);?></td>
    <td><?php echo htmlspecialchars($record["rating"]);?></td>
    <td><?php echo htmlspecialchars($record["genre"]);?></td>
    <td><?php echo htmlspecialchars($record["player"]);?></td>
  </tr>
  <?php
}

// Search Form

const SEARCH_FIELDS = [
    "game_title" => "By Title",
    "platform" => "By Platform",
    "price" => "By Price",
    "rating" => "By Rating",
    "genre" => "By Genre",
    "player" => "By # of Players"
];

if ( isset($_GET['search']) && isset($_GET['category']) ) {
  $do_search = TRUE;

  $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);

  // check if the category exists in the SEARCH_FIELDS array
  if (in_array($category, array_keys(SEARCH_FIELDS))) {
    $search_field = $category;
  } else {
    array_push($messages, "Invalid category for search.");
    $do_search = FALSE;
  }

  // Get the search terms
  $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
  $search = trim($search);
} else {
  // No search provided, so set the product to query to NULL
  $do_search = FALSE;
  $category = NULL;
  $search = NULL;
}

// Insert Form

// Get the list of games from the database.
$games = exec_sql_query($db, "SELECT DISTINCT game_title FROM games", NULL)->fetchAll(PDO::FETCH_COLUMN);

if ( isset($_POST["submit_insert"]) ) {
  $valid_game = TRUE;

  $game_title = filter_input(INPUT_POST, 'game_title', FILTER_SANITIZE_STRING);
  //$platform = filter_input(INPUT_POST, 'platform', FILTER_SANITIZE_STRING);
  if (isset($_POST['switch'])) {$switch = $_POST['switch'];}
  if (isset($_POST['xbone'])) {$xbone = $_POST['xbone'];}
  if (isset($_POST['ps'])) {$ps = $_POST['ps'];}
  $plat = '';
  if ($switch){
      $plat = $plat . "Switch, ";
  }
  if ($xbone){
      $plat = $plat . "Xbox One, ";
  }
  if ($ps){
      $plat = $plat . "PS4, ";
  }
  if (substr($plat, (strlen($plat)-2), strlen($plat)) == ", ") {
      $plat = substr($plat, 0, (strlen($plat)-2));
  }
  $platform = $plat;
  $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
  $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_STRING);
  $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_STRING);
  $player = filter_input(INPUT_POST, 'player', FILTER_SANITIZE_STRING);

  // Game must be new to the database
  if ( in_array($game_title, $games) ) {
    $valid_game = FALSE;
  }

  if ($valid_game) {
    // TODO: query for inserting a game into DB
    $sql = "INSERT INTO games (game_title, platform, price, rating, genre, player)
            VALUES (:game_title, :platform, :price, :rating, :genre, :player);";
    $params = array(
        ':game_title' => ($game_title),
        ':platform' => ($platform),
        ':price' => ($price),
        ':rating' => ($rating),
        ':genre' => ($genre),
        ':player' => ($player)
    );

    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      array_push($messages, "Your game has been recorded. Thank you!");
    } else {
      array_push($messages, "Failed to add game.");
    }
  } else {
    array_push($messages, "Failed to add game. Game already exists in the GameBase.");
  }
}
?>
<!DOCTYPE html>
<html>

<?php include('includes/head.php'); ?>

<body>
  <?php include("includes/header.php"); ?>

  <div id="content-wrap">
    <h1>Welcome to the GameBase!</h1>

    <p>This is what we've got in stock:</p>

    <?php
    // Write out any messages to the user.
    foreach ($messages as $message) {
      echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
    }
    ?>

    <form id="searchForm" action="gameBase2.php" method="get">
      <select name="category">
        <option value="" selected disabled>Search By</option>
        <?php
        foreach(SEARCH_FIELDS as $field_name => $label){
          ?>
          <option value="<?php echo $field_name;?>"><?php echo $label;?></option>
          <?php
        }
        ?>
      </select>
      <input type="text" name="search"/>
      <button type="submit">Search</button>
    </form>

    <?php
    if ($do_search) {
      // We have a specific game to query!
      ?>
      <h2>Search Results</h2>
      <?php

      // Be careful to filter $search_field above. If you're not careful, you can seriously break your database.
      // TODO: wildcard search using LIKE.
      $sql = "SELECT * FROM games WHERE $search_field LIKE '%' || :search || '%'";
      $params = array(
        ':search' => $search
      );
    } else {
      // No game to query, so return everything!
      ?>
      <h2>All Games</h2>
      <?php

      $sql = "SELECT * FROM games";
      $params = array();
    }

    // Get the games to display
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      // The query was successful, get the records.
      $records = $result->fetchAll();

      if ( count($records) > 0 ) {
        ?>
        <table>
          <tr>
            <th>Game Title</th>
            <th>Platform</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Genre</th>
            <th>Player</th>
          </tr>

          <?php
          foreach($records as $record) {
            print_record($record);
          }
          ?>
        </table>
        <?php
      } else {
        // No results found
        echo "<p>No matching games found.</p>";
      }
    }
    ?>

    <div id="addPage">

    <h1>_____________________________________________________________________________________</h1>
    <h2 style="text-align: center; float: center;">Add a Game</h2>
    <p><strong>(Manager Access ONLY)</strong></p>

  <form id="addGame" action="gameBase2.php" method="post" style="text-align: center; float: center;">
    <fieldset>
    <ul>
      <li>
        <label>Game Title:</label>
        <input type="text" name="game_title"/>
      </li>
      <li>
        <label>Platform:</label>
        <input type="checkbox" name="switch" value="Switch" />Switch
        <input type="checkbox" name="xbone" value="Xbox One"/>Xbox One
        <input type="checkbox" name="ps" value="PS4"/>PS4
      </li>
      <li>
        <label>Price: $</label>
        <input type="text" name="price"/>
      </li>
      <li>
        <label>Rating:</label>
        <select name="rating">
          <option value="" selected disabled>Choose Rating</option>
          <?php
          foreach($ratingType as $rat) {
            echo "<option value=\"" . htmlspecialchars($rat) . "\">" . htmlspecialchars($rat) . "</option>";
          }
          ?>
        </select>
      </li>
      <li>
        <label>Genre:</label>
        <input type="text" name="genre"/>
      </li>
      <li>
        <label>Players (single-player and/or multi-player):</label>
        <input type="text" name="player"/>
      </li>
      <li>
        <button name="submit_insert" type="submit">Add Game</button>
      </li>
    </ul>
    </fieldset>
  </form>

  </div>

  </div>

  <?php include("includes/footer.php"); ?>
</body>

</html>
