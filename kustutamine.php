<?php
include("config.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['delete'])) {
    $comment_id = (int)$_GET['delete'];
    $sql_delete_comment = "DELETE FROM hinnangud WHERE id = $comment_id";
    if ($sqluhendus->query($sql_delete_comment) === TRUE) {
        $restaurant_id = (int)$_GET['id'];
        header("Location: kustutamine.php?id=$restaurant_id");
        exit;
    } else {
        echo "viga kustutamisel: " . $sqluhendus->error;
    }
}

$restaurant_id = (int)$_GET['id'];
$sql_get_restaurant = "SELECT * FROM kohvikud WHERE id = $restaurant_id";
$result_restaurant = $sqluhendus->query($sql_get_restaurant);
$restaurant = $result_restaurant->fetch_assoc();

$sql_get_ratings = "SELECT * FROM hinnangud WHERE kohvikud_id = $restaurant_id";
$result_ratings = $sqluhendus->query($sql_get_ratings);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Hinnangud - <?php echo htmlspecialchars($restaurant['restaurant_name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Avaleht</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">logi välja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">tagasi admini</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h1>hinnangud - <?php echo htmlspecialchars($restaurant['restaurant_name']); ?></h1>
    <table class="table">
        
                <th>nimi</th>
                <th>hinne</th>
                <th>kommentaar</th>
                <th>kustuta</th>
       
            <?php while ($row = $result_ratings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nimi']); ?></td>
                    <td><?php echo htmlspecialchars($row['hinne']); ?></td>
                    <td><?php echo htmlspecialchars($row['kommentaar']); ?></td>
                    <td>
                        <a href="kustutamine.php?id=<?php echo $restaurant_id; ?>&delete=<?php echo $row['id']; ?>" class="btn btn-sm" onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                    
                
            <?php endwhile; ?>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$sqluhendus->close();
?>
