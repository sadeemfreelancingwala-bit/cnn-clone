<?php
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


$success = "";
$error = "";

if ($_POST) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_description']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $category_id = (int)$_POST['category_id'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    $query = "INSERT INTO news (title, short_description, content, image_url, category_id, is_featured) 
              VALUES ('$title', '$short_desc', '$content', '$image_url', $category_id, $is_featured)";
    
    if (mysqli_query($conn, $query)) {
        $success = "News article published successfully!";
    } else {
        $error = "Error publishing news: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add News - CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=2.5">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="auth-container fade-up">
        <form class="auth-form" method="post" style="max-width: 800px;">
            <h2 class="section-title" style="border-bottom: none; text-align: left; padding-left: 0;">Publish a New Story</h2>
            
            <?php if($success): ?>
                <div style="background: rgba(0, 255, 0, 0.1); color: #00ff00; padding: 15px; border-radius: 6px; margin-bottom: 2rem;">
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if($error): ?>
                <div style="background: rgba(255, 0, 0, 0.1); color: #ff0000; padding: 15px; border-radius: 6px; margin-bottom: 2rem;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #ccc;">Headline</label>
                    <input name="title" placeholder="Enter article headline..." required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #ccc;">Category</label>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        <?php
                        $cats = mysqli_query($conn, "SELECT * FROM categories");
                        while($c = mysqli_fetch_assoc($cats)) {
                            echo "<option value='".$c['id']."'>".$c['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #ccc;">Short Summary</label>
            <input name="short_description" placeholder="A brief hook for the card..." required>
            
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #ccc;">Article Body</label>
            <textarea name="content" placeholder="Write the full news story here..." rows="8" required></textarea>
            
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #ccc;">Image URL</label>
            <input name="image_url" placeholder="Paste image link (Unsplash, etc.)..." required>
            
            <div style="display: flex; items-center; gap: 10px; margin-bottom: 2rem;">
                <input type="checkbox" name="is_featured" id="is_featured" style="width: 20px; margin: 0;">
                <label for="is_featured" style="cursor: pointer; color: #ccc; font-weight: bold;">Feature this story on homepage</label>
            </div>

            <button type="submit">Publish Article</button>
        </form>
    </div>

</body>
</html>
