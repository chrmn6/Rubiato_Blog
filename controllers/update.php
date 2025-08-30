<?php

require __DIR__ . '/../database.php';
require __DIR__ . '/../blog.php';

$db = (new Database())->connect();
$blog = new Blog($db);

if (!isset($_GET['id'])) {
    echo "No post ID provided.";
    exit;
}

$post = $blog->getById($_GET['id']);

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $image = null;

    //handle images
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']);
        $target = __DIR__ . "/../uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    if ($blog->update($post['id'], $title, $content, $category, $image)) {
        echo "Post updated successfully.";
        header("Location: index.php");
    } else {
        echo "Failed to update post.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="edit-container">
        <h2>Edit Post</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Title</label><br>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>
            <label>Content</label><br>
            <textarea name="content" rows="5" cols="30" required><?php echo htmlspecialchars($post['content']); ?>"
                </textarea><br><br>
            <label>Category</label><br>
            <input type="text" name="category" value="<?php echo htmlspecialchars($post['category']); ?>"
                required><br><br>
            <?php if ($post['image']): ?>
                <img src="../uploads/<?php echo $post['image']; ?>" alt="Post Image" style="max-width: 200px;"><br><br>
            <?php endif; ?>
            <label>Image</label><br>
            <input type="file" name="image"><br><br>
            <input type="submit" name="submit" value="Update Post">
        </form>
        <a href="index.php">Back to blog</a>
    </div>
</body>

</html>