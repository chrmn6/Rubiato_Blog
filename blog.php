<?php

class Blog
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllPosts()
    {
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get single post
    public function getById($id)
    {
        $sql = "SELECT * FROM posts WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // create post
    public function create($title, $content, $category, $image)
    {
        $sql = "INSERT INTO posts (title, content, category, image) VALUES (:title, :content, :category, :image)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category, 'image' => $image]);
    }

    //update post
    public function update($id, $title, $content, $category, $image = null)
    {

        //condition to check if the image is existing
        if ($image) {
            $sql = "UPDATE posts SET title = :title, content = :content, category = :category, image = :image WHERE id = :id";
            $params = [":id" => $id, ":title" => $title, ":content" => $content, ":category" => $category, ":image" => $image];
        } else {
            $sql = "UPDATE posts SET title = :title, content = :content, category =:category, image = :image WHERE id = :id";
            $params = [":id" => $id, ":title" => $title, ":content" => $content, ":category" => $category, ":image" => $image];
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    //delete post
    public function delete($id)
    {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

}