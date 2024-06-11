<?php
include("config.php");
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $sqluhendus->prepare("DELETE FROM kohvikud WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $stmt = $sqluhendus->prepare("DELETE FROM hinnangud WHERE kohvikud_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    header('Location: admin.php');
    exit;
}

$result = $sqluhendus->query("SELECT * FROM kohvikud");
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Avaleht</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logi valja</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
<h1>tere tulemast admin leht</h1>
    <a href="lisamine.php" class="btn">lisa uus kohvikd</a>
<?php
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'restaurant_name';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM kohvikud 
        WHERE restaurant_name LIKE '%$search%' 
        ORDER BY $sort_column $sort_order 
        LIMIT $limit OFFSET $offset";
$result = $sqluhendus->query($sql);

$total_sql = "SELECT COUNT(*) FROM kohvikud WHERE restaurant_name LIKE '%$search%'";
$total_result = $sqluhendus->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);
?>
<hr>
<form method="GET">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">otsi</button>
</form>


    
    <table class="table">
        
            <tr>
                <th>kohviku nimi</th>
                <th>asukoht</th>
                <th>keskmine hinnang</th>
                <th>hinnangute arv</th>
                <th>admini management?</th>
            </tr>
        
        
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['asukoht']); ?></td>
                    <td><?php echo htmlspecialchars($row['average_rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['rating']); ?></td>
                    <td>
                        <a href="muutmine.php?id=<?php echo $row['id']; ?>" class="btn">muuda</a>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn " onclick="return confirm('kindel et soovid kustutadaö?');">kustuta koht</a>
                        <a href="kustutamine.php?id=<?php echo $row['id']; ?>" class="btn ">vaata hinnanguid</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        
    </table>
</div>
<script src="path/to/your/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$sqluhendus->close();
?>
