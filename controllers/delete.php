<?php

require __DIR__ . '/../database.php';
require __DIR__ . '/../blog.php';

$db = (new Database())->connect();
$blog = new Blog($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //get posts to delete it's image
    $post = $blog->getById($id);
    if ($post && $blog->delete($id)) {
        if (!empty($post['image']) && file_exists(__DIR__ . "/../uploads/" . $post['image'])) {
            unlink(__DIR__ . "/../uploads/" . $post['image']);
        }
        echo "Post deleted successfully.";
        header("Location: index.php");
    } else {
        echo "Failed to delete post.";
    }
}

echo "<br><a href='index.php'>Back to Blog</a>";