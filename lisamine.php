<?php
include("config.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lisamine</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"
    >
</head>
<body>
    <div class="container">
        <h1>kohviku lisamine</h1>
        <hr>
        <a href="admin.php">tagasi admini lejele</a>
        <br>
        <br>
        <form method="post">
            <label for="nimi">kohviku nimi:</label>
            <input type="text" name="nimi" id="nimi" required><br>

            <label for="asukoht">kohviku asukoht:</label>
            <input type="text" name="asukoht" id="asukoht" required><br>
            </select><br>         

            <input type="submit" class="btn btn-primary my-2" value="Salvesta">
        </form>
        <?php
        if(!empty($_POST['nimi']) && !empty($_POST['asukoht'])){
            $nimi = $_POST['nimi'];
            $asukoht = $_POST['asukoht'];

            $sqllisa = "INSERT INTO kohvikud (restaurant_name, asukoht) VALUES ('$nimi', '$asukoht')";
            $sqluhendus->query($sqllisa);
            echo "kohvik on lisatud.";
            header("Location: admin.php");
            exit;
            }
        
        ?>
            }
        }
        ?>



        <?php
        $sqluhendus->close();
        ?>   
    </div>

        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>