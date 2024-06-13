<?php
include("config.php");
session_start();
?>

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

<form method="GET">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn btn-outline-info">Otsi</button>
</form>

<table class="table">
        
            <th><a href="?sort=restaurant_name&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>">restorandi nimi</a></th>
            <th><a href="?sort=location&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>">asukoht</a></th>
            <th><a href="?sort=average_rating&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>">keskmine hinnang</a></th>
            <th><a href="?sort=rating_count&order=<?php echo $sort_order == 'ASC' ? 'desc' : 'asc'; ?>">hinnangute arv</a></th>
        
    
    
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr onclick="location.href='hinnang2.php?id=<?php echo $row['id']; ?>'">
            <td><?php echo htmlspecialchars($row['restaurant_name']); ?></td>
            <td><?php echo htmlspecialchars($row['asukoht']); ?></td>
            <td><?php echo htmlspecialchars($row['average_rating']); ?></td>
            <td><?php echo htmlspecialchars($row['rating']); ?></td>
        
        <?php endwhile; ?>
    
</table>

<div>
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sort_column; ?>&order=<?php echo $sort_order; ?>&search=<?php echo htmlspecialchars($search); ?>">&lt; eelmine</a>
    <?php endif; ?>
    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sort_column; ?>&order=<?php echo $sort_order; ?>&search=<?php echo htmlspecialchars($search); ?>">jargmine &gt;</a>
    <?php endif; ?>
</div>

<?php
$sqluhendus->close();
?>
