<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>CNN Clone</title>
<link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>

<?php include 'header.php'; ?>

<div class="breaking-news">
    <span class="breaking-label">Breaking News</span>
    <div class="ticker-wrapper">
        <div class="ticker">
            <?php
            $breaking = mysqli_query($conn, "SELECT title FROM news ORDER BY created_at DESC LIMIT 5");
            if($breaking) {
                while($b = mysqli_fetch_assoc($breaking)) {
                    echo "<span>" . $b['title'] . " &nbsp; • &nbsp; </span>";
                }
            }
            ?>
        </div>
    </div>
</div>


<section class="featured-section">
<div class="featured-bg" style="background-image: url('https://images.unsplash.com/photo-1585829365295-ab7cd400c167?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
<div class="featured-overlay"></div>
<div class="featured-content">
<?php
$f=mysqli_query($conn,"SELECT * FROM news WHERE is_featured=1 LIMIT 1");
if($f && mysqli_num_rows($f) > 0){
  $feat=mysqli_fetch_assoc($f);
?>
<span class="featured-tag">Featured Story</span>
<h2><?= $feat['title'] ?></h2>
<p><?= $feat['short_description'] ?></p>
<a class="btn-read" href="article.php?id=<?= $feat['id'] ?>">Read Full Story</a>
<?php } else { ?>
<p>No featured news available.</p>
<?php } ?>
</div>
</section>

<div class="content-wrapper">
    <div class="main-content">
        <h2 class="section-title">Latest News</h2>
        <div class="main-grid">
        <?php
        $q=mysqli_query($conn,"SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id ORDER BY n.created_at DESC");
        if($q){
            while($n=mysqli_fetch_assoc($q)){
            ?>
            <div class="news-card" onclick="location.href='article.php?id=<?= $n['id'] ?>'">
            <img src="<?= $n['image_url'] ?>" alt="<?= $n['title'] ?>">
            <div class="card-content">
              <span class="card-category"><?= $n['category_name'] ?></span>
              <h3><?= $n['title'] ?></h3>
              <p><?= $n['short_description'] ?></p>
              <span class="read-link">Read Article →</span>
            </div>
            </div>
            <?php 
            }
        }
        ?>
        </div>
    </div>

    <aside class="trending-sidebar">
        <h2 class="section-title">Trending Now</h2>
        <?php
        $trend=mysqli_query($conn,"SELECT * FROM news ORDER BY views DESC LIMIT 5");
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
<script src="script.js"></script>
</body>
</html>
