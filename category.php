<?php include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cat_query = mysqli_query($conn,"SELECT * FROM categories WHERE id=$id");
$cat = $cat_query ? mysqli_fetch_assoc($cat_query) : null;
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $cat ? $cat['name'] : 'Category' ?> - CNN Clone</title>
<link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>
<?php include 'header.php'; ?>

<div class="content-wrapper">
    <div class="main-content">
        <h1 class="page-title" style="padding-left: 0;"><?= $cat ? $cat['name'] : 'Category Not Found' ?> News</h1>
        
        <div class="main-grid fade-up">
        <?php
        if ($cat) {
            $q=mysqli_query($conn,"SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id WHERE n.category_id=$id ORDER BY n.created_at DESC");
            if($q && mysqli_num_rows($q) > 0){
                while($n=mysqli_fetch_assoc($q)){
                ?>
                <div class="news-card" onclick="location.href='article.php?id=<?= $n['id'] ?>'">
                <img src="<?= $n['image_url'] ?>">
                <div class="card-content">
                  <span class="card-category"><?= $n['category_name'] ?></span>
                  <h3><?= $n['title'] ?></h3>
                  <p><?= $n['short_description'] ?></p>
                  <span class="read-link">Read Article →</span>
                </div>
                </div>
                <?php 
                } 
            } else {
                echo "<p>No news articles found in this category.</p>";
            }
        }
        ?>
        </div>
    </div>

    <aside class="trending-sidebar">
        <h2 class="section-title">Trending in <?= $cat ? $cat['name'] : 'News' ?></h2>
        <?php
        $trend_cat = $cat ? "WHERE category_id=$id" : "";
        $trend=mysqli_query($conn,"SELECT * FROM news $trend_cat ORDER BY views DESC LIMIT 5");
        if($trend){
            $rank = 1;
            while($t=mysqli_fetch_assoc($trend)){
            ?>
            <div class="trending-item" onclick="location.href='article.php?id=<?= $t['id'] ?>'">
                <span class="trend-rank"><?= $rank++ ?></span>
                <div class="trend-info">
                    <h4><?= $t['title'] ?></h4>
                    <span class="trend-meta"><?= $t['views'] ?> views</span>
                </div>
            </div>
            <?php
            }
        }
        ?>
    </aside>
</div>

<?php include 'footer.php'; ?>
</body>
</html>


