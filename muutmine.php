<?php
include("config.php");
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$restaurant_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$restaurant = ['restaurant_name' => '', 'asukoht' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_name = $_POST['restaurant_name'];
    $asukoht = $_POST['asukoht'];

    if ($restaurant_id) {
        $sqluuendus = "UPDATE kohvikud SET restaurant_name = '$restaurant_name', asukoht = '$asukoht' WHERE id = $restaurant_id";
        $sqluhendus->query($sqluuendus);
    } else {
        $sql_insert = "INSERT INTO kohvikud (restaurant_name, asukoht) VALUES ('$restaurant_name', '$asukoht')";
        $sqluhendus->query($sql_insert);
    }
    header('Location: admin.php');
    exit;
}

if ($restaurant_id) {
    $sqlvali = "SELECT * FROM kohvikud WHERE id = $restaurant_id";
    $result = $sqluhendus->query($sqlvali);
    $restaurant = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <form method="POST">
        <div class="mb-3">
            <label for="restaurant_name" class="form-label">Nimi</label>
            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value=
            "<?php echo htmlspecialchars($restaurant['restaurant_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="asukoht" class="form-label">Asukoht</label>
            <input type="text" class="form-control" id="asukoht" name="asukoht" value=
            "<?php echo htmlspecialchars($restaurant['asukoht']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $restaurant_id ? 'Salvesta' : 'Lisa'; ?></button>
        <a href="admin.php" class="btn btn-secondary">Tagasi</a>
    </form>
</div>
<script src="path/to/your/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$sqluhendus->close();
?>
