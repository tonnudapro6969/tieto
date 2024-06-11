<?php
include("config.php");
session_start();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lisamine</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    
    <style>
        .star [type="radio"]{
            appearance: none;
        }

        .star label:has(~ :checked){
            color: orange;
        }
    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">avaleht</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">logddi sisse</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="admin.php">admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="logout.php">logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">

        <?php

        $kohvikud_id = (int)$_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nimi = $sqluhendus->real_escape_string($_POST['nimi']);
            $rating = (int)$_POST['rating'];
            $kommentaar = $sqluhendus->real_escape_string($_POST['kommentaar']);

            $sql_insert = "INSERT INTO hinnangud (kohvikud_id, nimi, hinne, kommentaar) VALUES ($kohvikud_id, '$nimi', $rating, '$kommentaar')";
            if ($sqluhendus->query($sql_insert) === TRUE) {
                $sqlupdate = "UPDATE kohvikud SET average_rating = (SELECT AVG(hinne) FROM hinnangud WHERE kohvikud_id = $kohvikud_id), rating = rating + 1 WHERE id = $kohvikud_id";
                $sqluhendus->query($sqlupdate);
            } else {
                echo "viga";
            }
        }

        $restaurantfail = "SELECT * FROM kohvikud WHERE id = $kohvikud_id";
        $restaurantfail = $sqluhendus->query($restaurantfail);
        $restaurant = $restaurantfail->fetch_assoc();

        $ratingfail = "SELECT * FROM hinnangud WHERE kohvikud_id = $kohvikud_id";
        $ratingsaab = $sqluhendus->query($ratingfail);

        ?>

        <h1><?php echo htmlspecialchars($restaurant['restaurant_name']); ?></h1>
        <p>asukoht: <?php echo htmlspecialchars($restaurant['asukoht']); ?></p>
        <p>keskmine hinnang: <?php echo htmlspecialchars($restaurant['average_rating']); ?></p>
        <p>hinnangute arv: <?php echo htmlspecialchars($restaurant['rating']); ?></p>

        <form method="post">
            <label for="nimi">Nimi:</label>
            <input type="text" name="nimi" id="nimi" required><br>
            
            <label for="kommentaar">Kommentaar:</label>
            <textarea name="kommentaar" id="kommentaar" rows="4" required></textarea><br>

            <p class="star">Hinnang (1-10):<br>
    <label for="rating1"><i class="fa fa-star"></i>1</label>
    <input type="radio" name="rating" id="rating1" value="1" required>
    <label for="rating2"><i class="fa fa-star"></i>2</label>
    <input type="radio" name="rating" id="rating2" value="2">
    <label for="rating3"><i class="fa fa-star"></i>3</label>
    <input type="radio" name="rating" id="rating3" value="3">
    <label for="rating4"><i class="fa fa-star"></i>4</label>
    <input type="radio" name="rating" id="rating4" value="4">
    <label for="rating5"><i class="fa fa-star"></i>5</label>
    <input type="radio" name="rating" id="rating5" value="5">
    <label for="rating6"><i class="fa fa-star"></i>6</label>
    <input type="radio" name="rating" id="rating6" value="6">
    <label for="rating7"><i class="fa fa-star"></i>7</label>
    <input type="radio" name="rating" id="rating7" value="7">
    <label for="rating8"><i class="fa fa-star"></i>8</label>
    <input type="radio" name="rating" id="rating8" value="8">
    <label for="rating9"><i class="fa fa-star"></i>9</label>
    <input type="radio" name="rating" id="rating9" value="9">
    <label for="rating10"><i class="fa fa-star"></i>10</label>
    <input type="radio" name="rating" id="rating10" value="10">
</p>

                <button type="submit" class="btn btn-primary">salvesta& saada</button>

          

            <p>_______________________________________________________________________________________________________________________________</p>

            <h2>hinnangud kohviku kohta</h2>
            <hr>
            <ul>
                <?php while ($row = $ratingsaab->fetch_assoc()): ?>
                    <li>
                        nimi: <?php echo htmlspecialchars($row['nimi']); ?><br>
                        hinne: <?php echo htmlspecialchars($row['hinne']); ?><br>
                        kommentaar: <?php echo htmlspecialchars($row['kommentaar']); ?><br>
                        <br><br>
                    </li>
                <?php endwhile; ?>
            </ul>
        </form>

        <?php
        $sqluhendus->close();
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
