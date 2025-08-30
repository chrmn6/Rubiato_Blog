<?php

require __DIR__ . '/../database.php';
require __DIR__ . '/../blog.php';

$db = (new Database())->connect();
$blog = new Blog($db);

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    //handle images
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']);
        $target = __DIR__ . "/../uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    if ($blog->create($title, $content, $category, $image)) {
        header("Location: index.php");
    } else {
        echo "Failed to create post.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="create-container">
        <h2>Create Post</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Title</label><br>
            <input type="text" name="title" required><br><br>
            <label>Content</label><br>
            <textarea name="content" rows="5" cols="30" required></textarea><br><br>
            <label>Category</label><br>
            <input type="text" name="category" required><br><br>
            <label>Image</label><br>
            <input type="file" name="image"><br><br>
            <input type="submit" name="submit" value="Create Post">
        </form>
        <a href="index.php">Back to blog</a>
    </div>
</body>

</html>