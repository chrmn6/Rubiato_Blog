<?php

require __DIR__ . '/../database.php';
require __DIR__ . '/../blog.php';

$db = (new Database())->connect();
$blog = new Blog($db);

$posts = $blog->getAllPosts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <h2>Posts</h2><br>
        <a href="create.php">Create New Post</a><br><br>

        <?php foreach ($posts as $post): ?>
            <div class="post">
                <div class="post-image">
                    <?php if ($post['image']): ?>
                        <img src="../uploads/<?php echo $post['image']; ?>" alt="Blog Image" style="max-width:200px;">
                    <?php endif; ?>
                </div>
                <div class="post-header">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <h4><?php echo htmlspecialchars($post['category']); ?></h4>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                </div>
                <div class="post-actions">
                    <a href="update.php?id=<?php echo $post['id']; ?>">Edit</a>
                    <a href="delete.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</body>

</html>