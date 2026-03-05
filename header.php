<header class="nav-header">
  <div class="header-top">
    <div class="logo">
      <a href="index.php"><h1>CNN</h1></a>
    </div>
    
    <div class="search-bar">
      <form action="search.php" method="GET">
        <input type="text" name="q" placeholder="Search news...">
        <button type="submit">🔍</button>
      </form>
    </div>

    <div class="auth-links">
      <a href="#" class="ai-link">🤖 AI Assistant</a>
      <?php if(isset($_SESSION['user'])): ?>
        <a href="add_news.php" class="btn-add">+ Add News</a>
        <div class="user-profile">
          <span>Hi, <?= $_SESSION['user'] ?></span>
          <a href="logout.php">Logout</a>
        </div>
      <?php else: ?>
        <a href="login.php" class="btn-login">Login</a>
        <a href="signup.php" class="btn-signup">Signup</a>
      <?php endif; ?>
    </div>
  </div>
  
  <nav class="category-nav">
    <a href="index.php">Home</a>
    <?php
    if(isset($conn)) {
        $cats=mysqli_query($conn,"SELECT * FROM categories");
        if($cats){
            while($c=mysqli_fetch_assoc($cats)){
                echo "<a href='category.php?id=".$c['id']."'>".$c['name']."</a>";
            }
        }
    }
    ?>
  </nav>
</header>

