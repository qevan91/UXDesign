<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home1</title>
    <link rel="stylesheet" href="src/css/index.css">
    <script src="src/js/index.js" defer></script>
</head>
<body>
<div class="search-container">
    <a href="index.php"><img src="src/img/Cart_Logo.png" alt="Cart Logo" width="100" height="100"></a>
    <label for="search-input"></label>
    <input type="text" id="search-input" placeholder="Rechercher un produit...">
    <button id="search-btn">Rechercher</button>
</div>

<div id="search-results">
    <ul>
        <?php
        require 'pdo.php';
        $pdo = getPdo();

        $maxProductPerPage = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $maxProductPerPage;

        $sql = "SELECT * FROM product LIMIT $maxProductPerPage OFFSET $offset";
        $product = $pdo->query($sql);

        $totalProducts = $pdo->query("SELECT COUNT(*) FROM product")->fetchColumn();
        $totalPages = ceil($totalProducts / $maxProductPerPage);

        foreach ($product as $value): ?>
            <li>
                <div class="lazy-load-container">
                    <img src="<?= $value['image_url']; ?>" class="lazy-image" alt="Image de <?= $value['name']; ?>" height="100">
                    <p class="lazy-text"><?= $value['name']; ?></p>
                    <p class="lazy-text">Prix: <?= $value['price']; ?> €</p>
                    <p class="lazy-text"><?= $value['description']; ?></p>
                    <button class="lazy-text">Ajoutez au panier</button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="pagination">
    <?php
    $maxPagesToShow = 5;
    $startPage = max(1, $page - floor($maxPagesToShow / 2));
    $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

    if ($endPage - $startPage < $maxPagesToShow - 1) {
        $startPage = max(1, $endPage - $maxPagesToShow + 1);
    }

    if ($page > 1): ?>
        <a href="?page=<?= $page - 1; ?>">Précédente</a>
    <?php endif; ?>

    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
        <a href="?page=<?= $i; ?>" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1; ?>">Suivante</a>
    <?php endif; ?>
</div>
</body>
</html>
