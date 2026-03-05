<?php include 'db.php'; 
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Results - CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="search-container">
        <h1 class="page-title">Search Results for: "<?= htmlspecialchars($q) ?>"</h1>
        
        <div class="main-grid fade-up">
            <?php
            if ($q != '') {
                $query = "SELECT * FROM news WHERE title LIKE '%$q%' OR content LIKE '%$q%' ORDER BY created_at DESC";
                $res = mysqli_query($conn, $query);
                if($res && mysqli_num_rows($res) > 0){
                    while($n = mysqli_fetch_assoc($res)){
                    ?>
                    <div class="news-card" onclick="location.href='article.php?id=<?= $n['id'] ?>'">
                        <img src="<?= $n['image_url'] ?>" alt="<?= $n['title'] ?>">
                        <div class="card-content">
                            <span class="card-category">News</span>
                            <h3><?= $n['title'] ?></h3>
                            <p><?= $n['short_description'] ?></p>
                            <span class="read-link">Read Article →</span>
                        </div>
                    </div>
                    <?php 
                    }
                } else {
                    echo "<p>No results found for your search.</p>";
                }
            } else {
                echo "<p>Please enter a search term.</p>";
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>

