<?php
include 'supp_db.php';

// Databasanslutning
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Hämta produkter från subproducts
$stmt = $pdo->prepare('SELECT * FROM subproducts');
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .product-image {
            max-width: 100px;
            max-height: 100px;
        }
        .text-preview {
            max-height: 100px; /* Approx 6 lines */
            overflow: hidden;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Products</h1>
        <table>
            <tr>
                <th>Rubrik</th>
                <th>Text</th>
                <th>Pris</th>
                <th>Kategori ID</th>
                <th>Bild</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['rubrik']); ?></td>
                    <td>
                        <div class="text-preview" onclick="toggleText(this)">
                            <?php echo nl2br(htmlspecialchars($product['text'])); ?>
                        </div>
                    </td>
                    <td><?php echo htmlspecialchars($product['pris']); ?></td>
                    <td><?php echo htmlspecialchars($product['category_id']); ?></td>
                    <td>
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="product-image">
                        <?php else: ?>
                            Ingen bild tillgänglig
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function toggleText(element) {
            if (element.style.maxHeight) {
                element.style.maxHeight = null;
                element.style.overflow = 'hidden';
            } else {
                element.style.maxHeight = 'none';
                element.style.overflow = 'visible';
            }
        }
    </script>
</body>
</html>
