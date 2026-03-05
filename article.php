<?php include 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Increment view count
if($id > 0) {
    mysqli_query($conn, "UPDATE news SET views = views + 1 WHERE id = $id");
}

$a_query = mysqli_query($conn, "SELECT n.*, c.name as category_name FROM news n LEFT JOIN categories c ON n.category_id = c.id WHERE n.id = $id");
$a = $a_query ? mysqli_fetch_assoc($a_query) : null;
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $a ? $a['title'] : 'Article' ?></title>
<link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>
<?php include 'header.php'; ?>

<?php if($a){ ?>
<div class="article-container fade-up">
<div class="article-header">
    <span class="card-category"><?= $a['category_name'] ?></span>
    <h1><?= $a['title'] ?></h1>
    <div class="article-meta">Published on <?= date('F j, Y', strtotime($a['created_at'])) ?> • <?= $a['views'] ?> views</div>
</div>
<img class="article-image" src="<?= $a['image_url'] ?>">
<div class="article-body">
    <p><?= nl2br($a['content']) ?></p>
</div>


<div class="related-stories-container">
    <h3>Related News</h3>
    <?php
    $r=mysqli_query($conn,"SELECT * FROM news WHERE category_id=".$a['category_id']." AND id!=$id LIMIT 3");
    if($r){
        while($rel=mysqli_fetch_assoc($r)){
        echo "<a class='related-link' href='article.php?id=".$rel['id']."'>".$rel['title']."</a>";
        }
    }
    ?>
</div>

</div>
<?php } else { ?>
    <h1>Article not found</h1>
<?php } ?>

<?php include 'footer.php'; ?>
</body>
</html>

