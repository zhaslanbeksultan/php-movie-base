<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul>
        <li><a href="index.php" class="<?= $current === 'index.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="catalog.php" class="<?= $current === 'catalog.php' ? 'active' : '' ?>">Catalog</a></li>
        <li><a href="admin.php" class="<?= $current === 'admin.php' ? 'active' : '' ?>">Admin</a></li>
    </ul>
</nav>
