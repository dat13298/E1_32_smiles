<?php
function init_connection()
{
    global $conn;
    if (!$conn) {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $dbname = '32_smiles';

        $conn = new mysqli($host, $user, $pass, $dbname);
    }
}




// DAT
function getProductToDisplay()
{
    global $conn;
    $sql = "SELECT *
            FROM category
            JOIN products ON category.category_id = products.category_id
            JOIN itemmedia ON products.product_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            WHERE category.parent_id = 4 AND itemmedia.item_type = 'product' AND product_is_deleted = 0";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}
function getCategoryProduct(){
    global $conn;
    $sql = "SELECT * FROM category WHERE parent_id = 4";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}
function getProductOther($id){
    global $conn;
    $sql = "SELECT *
            FROM category
            JOIN products ON category.category_id = products.category_id
            JOIN itemmedia ON products.product_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            WHERE item_type = 'product' AND product_is_deleted = 0 AND product_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getProduct($id){
    global $conn;
    $sql = "SELECT * 
            FROM products
            JOIN category ON category.category_id = products.category_id
            JOIN itemmedia ON itemmedia.item_id = products.product_id 
            JOIN media ON itemmedia.media_id = media.media_id 
            WHERE products.product_id = ? AND item_type = 'product'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all(MYSQLI_ASSOC);
    return $row ? $row[0] : [];
}

function getAllClinicToDisplay()
{
    global $conn;
    $sql = "SELECT *
            FROM clinic
            JOIN itemmedia ON clinic.clinic_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            WHERE clinic_is_deleted = 0 AND itemmedia.item_type = 'clinic'";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}
function validateFormContact($name, $title, $email, $phone, $message)
{
    $isValid = true;
    if (empty($name)) {
        $isValid = false;
    }
    if (empty($title)) {
        $isValid = false;
    }
    if (empty($email)) {
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
    }
    if (!empty($phone) && !preg_match('/^\d{10,}$/', $phone)) {
        $isValid = false;
    }
    if (empty($message)) {
        $isValid = false;
    }
    return $isValid;
}
function addContactUs($name, $title, $email, $phone, $message){
    try {
        global $conn;
        $sql_query = "INSERT INTO contactus (contact_name, contact_title, contact_message, contact_phone, contact_email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("sssss", $name, $title, $message, $phone, $email);
        $stmt->execute();
        $conn->commit();
    } catch (PDOException $e) {
        // Có lỗi xảy ra, rollback transaction
        $conn->rollback();
        // Xử lý lỗi tại đây
        error_log($e->getMessage());
        return false;
    }
    return true;
}

function getAllPostResearch()
{
    global $conn;
    $sql_query = "SELECT * FROM posts  WHERE post_is_deleted = 0";
    $stmt = $conn->prepare($sql_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}

function getMediaByPostID($post_id)
{
    global $conn;
    $sql_query = "SELECT media.media_path, media.media_type, media.media_text FROM media 
                    JOIN itemmedia ON media.media_id = itemmedia.media_id
                    JOIN posts ON itemmedia.item_id = posts.post_id
                    WHERE posts.post_id = ? AND media.media_is_deleted = 0
                    AND itemmedia.item_is_deleted = 0 AND itemmedia.item_type = 'research'";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data[0];
}

function getPostByID($post_id){
    global $conn;
    $sql_query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data[0];
}

function convertImagePath($dbPath) {
    $newPath = str_replace('../../', '../', $dbPath);
    return $newPath;
}

// Khanh


//--- Patient ---//
function getPatientAllPosts()
{
    global $conn;
    init_connection();

    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id 
    WHERE itemmedia.item_type = 'posts' && category.category_id = 2 && posts.post_is_deleted = 0; 
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function getPatientPosts($PostId)
{
    global $conn;
    init_connection();

    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id 
    WHERE itemmedia.item_type = 'posts' && category.category_id = 2 
    && posts.post_is_deleted = 0 
    && posts.post_id = ?;
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('d', $PostId);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);

    return $posts ? $posts[0] : [];
}


//--- Professional ---//

function getAllProfessionalPosts(){
    global $conn;
    init_connection();
    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id  
    WHERE itemmedia.item_type = 'posts' && (category.category_id = 6 OR category.category_id = 7) && posts.post_is_deleted = 0 ; 
    ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function getStudentResources()
{
    global $conn;
    init_connection();
    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id 
    WHERE itemmedia.item_type = 'posts'  && posts.post_is_deleted=0 
    && category.category_id = 6 ; 
    ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}


function getProfessionalPosts($PostId)
{
    global $conn;
    init_connection();

    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id 
    WHERE itemmedia.item_type = 'posts' && posts.post_id = ?;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('d', $PostId);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);

    return $posts ? $posts[0] : [];
}

function getFacultyResources()
{
    global $conn;
    init_connection();
    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id 
    WHERE itemmedia.item_type = 'posts'  && posts.post_is_deleted=0 
    && category.category_id = 7; 
    ";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}