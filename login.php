<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $parool = $_POST['parool'];

    if ($username === 'admin' && $parool === 'admin') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'admin';
        header('Location: admin.php');
        exit;
    } else {
        $error = "Vale kasutajanimi või parool!";
    }
}
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
          <a class="nav-link " href="logout.php">logout</a>
        </li>

      </ul>
    </div>
  </div>
</nav>


<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>logi sisse</title>
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>logi sisse</h1>
    <?php if (isset($error)): ?>
        <div class="alert"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">kasutajanimi</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="parool" class="form-label">parool</label>
            <input type="password" class="form-control" id="parool" name="parool" required>
        </div>
        <button type="submit" class="btn btn-outline-info">logii sisse</button>
    </form>
</div>
<script src="path/to/your/js/bootstrap.bundle.min.js"></script>
</body>
</html>
