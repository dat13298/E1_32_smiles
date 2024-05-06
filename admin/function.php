<?php

/*
 * FUNCTION
*/
function check_login()
{
    if (!isset($_SESSION['logged'])) {
        header('Location: index.php');
    }
}

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

function getPostByID($post_id)
{
    global $conn;
    $sql_query = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data[0];
}

function getMediaByPostID($post_id)
{
    global $conn;
    $sql_query = "SELECT media.media_path, media.media_text, media.media_type 
                    FROM media JOIN itemmedia ON media.media_id = itemmedia.media_id
                    JOIN posts ON itemmedia.item_id = posts.post_id
                    WHERE posts.post_id = ? 
                    AND media.media_is_deleted = 0
                    AND itemmedia.item_is_deleted = 0 AND itemmedia.item_type = 'research'";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data[0];
}

function getCategoryByCategoryID($category_id)
{
    global $conn;
    $sql_query = "SELECT category.category_name FROM category JOIN posts ON posts.category_id = category.category_id WHERE posts.category_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data[0];
}

/*
 * HUNG
*/
function getAllPostResearch()
{
    global $conn;
    $sql_query = "SELECT * FROM posts WHERE posts.category_id = 8 OR posts.category_id = 9";
    $stmt = $conn->prepare($sql_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}

//CREATE

function getResearchCategory()
{
    global $conn;
    $sql_query = "SELECT * FROM category WHERE parent_id = 3";
    $stmt = $conn->prepare($sql_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}
function checkMediaType($targetFile)
{
    // Tạo một đối tượng FileInfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    // Lấy MIME type của file
    $uploadedFileType = finfo_file($finfo, $targetFile);
    // Đóng đối tượng FileInfo
    finfo_close($finfo);
    // Kiểm tra xem tệp có phải là ảnh hay video không
    if (strpos($uploadedFileType, 'image/') === 0) {
        return "image";
    } else if (strpos($uploadedFileType, 'video/') === 0) {
        return "video";
    } else {
        return "unknown";
    }
}

function createPost($post_title, $post_content, $category, $description, $imagePath)
{
    global $conn;
    //Start transaction
    $conn->begin_transaction();
    try {
        $sql_query_posts = "INSERT INTO `posts` (`category_id`, `post_title`, `post_content`) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql_query_posts)) {
            $stmt->bind_param("iss", $category, $post_title, $post_content);
            $stmt->execute();
            $postId = $conn->insert_id;
            $stmt->close();
        } else {
            throw new Exception("Could not prepare post insertion query: " . $conn->error);
        }

        $mediaType = checkMediaType($imagePath);
        $sql_query_media = "INSERT INTO media (media_type, media_path, media_text) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql_query_media)) {
            $stmt->bind_param("sss", $mediaType, $imagePath, $description);
            $stmt->execute();
            $mediaId = $conn->insert_id;
            $stmt->close();
        } else {
            throw new Exception("Could not prepare media insertion query: " . $conn->error);
        }
        if ($mediaId > 0) {
            $itemType = "research";
            $sql_query_itemmedia = "INSERT INTO itemmedia (item_id, media_id, item_type) VALUES (?, ?, ?)";
            if ($stmt = $conn->prepare($sql_query_itemmedia)) {
                $stmt->bind_param("iis", $postId, $mediaId, $itemType);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Could not prepare itemmedia insertion query: " . $conn->error);
            }
        }
        $conn->commit();
        echo "Post and media created successfully.";
        header('Location: index.php');
    } catch (Exception $e) {
        $conn->rollback();
        echo "ERROR: " . $e->getMessage();
    }
    $conn->close();
}

//UPDATE
function updatePost($post_id, $category_id, $post_title, $post_content, $media_path, $media_text)
{
    global $conn;
    $conn->begin_transaction();

    try {
        $update_post_query = "UPDATE posts SET category_id = ?, post_title = ?, post_content = ? WHERE post_id = ? AND (posts.category_id = 8 OR posts.category_id = 9)";
        $stmt = $conn->prepare($update_post_query);
        $stmt->bind_param("issi", $category_id, $post_title, $post_content, $post_id);
        $stmt->execute();
        $stmt->close();
// Check if there is a new media to upload
        if (!empty($media_path)) {
            $media_type = checkMediaType($media_path);

            // Check if the post already has a media associated
            // Assuming `itemmedia` table links posts to media
            $check_media_query = "SELECT media_id FROM itemmedia WHERE item_id = ? AND item_type = 'research'";
            $stmt = $conn->prepare($check_media_query);
            $stmt->bind_param('i', $post_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                // If there is already a media, update it
                $row = $result->fetch_assoc();
                $existing_media_id = $row['media_id'];

                $update_media_query = "UPDATE media SET media_path = ?, media_type = ?, media_text = ? WHERE media_id = ?";
                $stmt = $conn->prepare($update_media_query);
                $stmt->bind_param('sssi', $media_path, $media_type, $media_text, $existing_media_id);
                $stmt->execute();
                $stmt->close();
            } else {
                // If there is no existing media, insert new one
                $insert_media_query = "INSERT INTO media (media_path, media_type, media_text) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insert_media_query);
                $stmt->bind_param('sss', $media_path, $media_type, $media_text);
                $stmt->execute();
                $new_media_id = $conn->insert_id;
                $stmt->close();

                // Link new media to the post
                $insert_itemmedia_query = "INSERT INTO itemmedia (post_id, media_id) VALUES (?, ?)";
                $stmt = $conn->prepare($insert_itemmedia_query);
                $stmt->bind_param('ii', $post_id, $new_media_id);
                $stmt->execute();
                $stmt->close();
            }
        }
//        If it doesn't have any errors, commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // Có lỗi xảy ra, rollback transaction
        $conn->rollback();
        // Xử lý lỗi tại đây
        error_log($e->getMessage());
        return false;
    }
    return true;
}

//DELETE
function deleteResearch($post_id)
{
    global $conn;
    $sql_query = "UPDATE posts SET post_is_deleted = 1 WHERE post_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
}

function restoreResearch($post_id)
{
    global $conn;
    $sql_query = "UPDATE posts SET post_is_deleted = 0 WHERE post_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
}

/*
 * KHANH
*/

//------------------Professional Education------------------------


function getProfessionalAllPosts()
{
    global $conn;
    init_connection();
    $sql = "SELECT * FROM posts 
        JOIN itemmedia ON posts.post_id = itemmedia.item_id 
        JOIN media ON itemmedia.media_id = media.media_id 
        JOIN category ON posts.category_id = category.category_id 
        WHERE itemmedia.item_type = 'posts' && (category.category_id = 6 OR category.category_id = 7)";
    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function deleteProfessionalPosts($PostId)
{
    global $conn;
    init_connection();

    $sql = "UPDATE posts
    JOIN itemmedia ON posts.post_id = itemmedia.item_id
    JOIN media ON itemmedia.media_id = media.media_id
    SET post_is_deleted = 1, item_is_deleted = 1, media_is_deleted = 1
    WHERE itemmedia.item_type = 'posts' && post_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('d', $PostId);
    $stmt->execute();
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

function addProfessionalPosts($title, $content, $category)
{
    global $conn;
    init_connection();
    $sql = "INSERT INTO posts(post_title,post_content,category_id) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $category);
    if ($stmt->execute()) {
        return $conn->insert_id; // Return the ID of the inserted media
    } else {
        return false; // Insert failed
    }
}

function getProfessionalCategory()
{
    global $conn;
    init_connection();
    $sql_query = "SELECT * FROM category WHERE parent_id = 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}


function validatePost($title, $content, $file, $mediaTitle)
{
    $errors = []; // Initialize an array to hold any error messages.

    // Validate title: check if it's not empty.
    if (empty($title)) {
        $errors['title'] = "Title is required.";
    }

    // Validate content: check if it's not empty.
    if (empty($content)) {
        $errors['content'] = "Content is required.";
    }
    if (empty($mediaTitle)) {
        $errors['mediaTitle'] = "Media Title is required.";
    }
    if ($file) {
        // Check for PHP upload errors
        if ($file['error'] != UPLOAD_ERR_OK) {
            $errors['file'] = "Cannot store the or upload the file.";
        } else {
            // Validate file size (for example, max 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($file['size'] > $maxSize) {
                $errors['file'] = "The file is too large. Maximum size is 5MB.";
            }
        }
    }

    // Further file validation can be added here (e.g., file size, type)

    return $errors; // Return the array of errors.
}


function addFileMedia($mediaType, $mediaPath, $mediaText)
{
    global $conn;
    init_connection();
    $sql = "INSERT INTO media (media_type, media_path, media_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $mediaType, $mediaPath, $mediaText);
    if ($stmt->execute()) {
        return $conn->insert_id; // Return the ID of the inserted media
    } else {
        return false; // Insert failed
    }

}

function addPairToItemMedia($postId, $mediaId, $itemType)
{
    global $conn;
    init_connection();
    $sql = "INSERT INTO itemmedia (item_id, media_id, item_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dds", $postId, $mediaId, $itemType);
    $stmt->execute();
}


function editProfessionalPosts($PostId, $category, $title, $content, $uploadedFile, $uploadedFileName, $mediaText, $folderName)
{
    global $conn;
    init_connection();

    // Update the post's title and content
    $sql = "UPDATE posts SET category_id=? ,post_title = ?, post_content = ? WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issd', $category, $title, $content, $PostId);
    $stmt->execute();

    // If a new file is uploaded
    if ($uploadedFile && $uploadedFileName) {
        // Validate the file first without moving
        $mediaType = mime_content_type($uploadedFile); // Get MIME type of the new file
        $fileValidationResult = validateFile($uploadedFile, $uploadedFileName, $folderName);

        if ($fileValidationResult === false) {
            return false;
        }

        // Proceed to update the database with the new file path and MIME type
        // Since $fileValidationResult is the new path, you don't need to call mime_content_type again
        // Update the media record with new file information

        $updatesql = "UPDATE media JOIN itemmedia ON media.media_id = itemmedia.media_id 
            SET media_path = ? , media_type = ?, media_text=? 
            WHERE item_id = ? AND item_type = 'posts'";

        $updateMediaStmt = $conn->prepare($updatesql);

        $updateMediaStmt->bind_param('sssd', $fileValidationResult, $mediaType, $mediaText, $PostId); // Ensure you use $PostId which is correctly scoped
        $updateMediaStmt->execute();
    }

    return true;
}


function restoreProfessional($id)
{
    global $conn;
    $sql = "UPDATE posts
            JOIN itemmedia ON posts.post_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET post_is_deleted = 0, item_is_deleted = 0, media_is_deleted = 0
            WHERE itemmedia.item_type = 'posts' AND post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

//-----------Patient Education---------------------


function deletePatientPosts($PostId)
{
    global $conn;
    init_connection();

    $stmt = $conn->prepare("UPDATE posts
    JOIN itemmedia ON posts.post_id = itemmedia.item_id
    JOIN media ON itemmedia.media_id = media.media_id
    SET post_is_deleted = 1, item_is_deleted = 1, media_is_deleted = 1
    WHERE itemmedia.item_type = 'posts' && post_id = ?"
    );

    $stmt->bind_param('d', $PostId);
    $stmt->execute();
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

function getPatientAllPosts()
{
    global $conn;
    init_connection();

    $sql = "SELECT * FROM posts 
    JOIN itemmedia ON posts.post_id = itemmedia.item_id 
    JOIN media ON itemmedia.media_id = media.media_id 
    JOIN category ON posts.category_id = category.category_id 
    WHERE itemmedia.item_type = 'posts' && category.category_id = 2; 
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function addPatientPosts($title, $content, $category)
{
    global $conn;
    init_connection();
    $sql = "INSERT INTO posts(post_title,post_content,category_id) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $category);
    if ($stmt->execute()) {
        return $conn->insert_id; // Return the ID of the inserted media
    } else {
        return false; // Insert failed
    }
}

function editPatientPosts($PostId, $title, $content, $uploadedFile, $uploadedFileName, $mediaText, $folderName)
{
    global $conn;
    init_connection();

    // Update the post's title and content
    $sql = "UPDATE posts SET post_title = ?, post_content = ? WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssd', $title, $content, $PostId);
    $stmt->execute();

    // If a new file is uploaded
    if ($uploadedFile && $uploadedFileName) {
        // Validate the file first without moving
        $mediaType = mime_content_type($uploadedFile); // Get MIME type of the new file
        $fileValidationResult = validateFile($uploadedFile, $uploadedFileName, $folderName);

        if ($fileValidationResult === false) {
            return false;
        }

        // Proceed to update the database with the new file path and MIME type
        // Since $fileValidationResult is the new path, you don't need to call mime_content_type again
        // Update the media record with new file information
        $updatesql = "UPDATE media JOIN itemmedia ON media.media_id = itemmedia.media_id 
            SET media_path = ? , media_type = ?, media_text=? 
            WHERE item_id = ? AND item_type = 'posts' ";

        $updateMediaStmt = $conn->prepare($updatesql);

        $updateMediaStmt->bind_param('sssd', $fileValidationResult, $mediaType, $mediaText, $PostId); // Ensure you use $PostId which is correctly scoped
        $updateMediaStmt->execute();
    }

    return true;
}

function restorePatient($id)
{
    global $conn;
    $sql = "UPDATE posts
            JOIN itemmedia ON posts.post_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET post_is_deleted = 0, item_is_deleted = 0, media_is_deleted = 0
            WHERE itemmedia.item_type = 'posts' AND post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}



// ------------------------------- Admin Dashboard ----------------------------------- //

function getAllUser()
{
    global $conn;
    init_connection();
    $sql = "SELECT * FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function deleteUser($UserId)
{
    global $conn;
    init_connection();
    $sql = "UPDATE user SET is_deleted = 1  , status = 0 WHERE user_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('d', $UserId);
    $stmt->execute();
}

function getUser($UserId)
{
    global $conn;
    init_connection();
    $sql = "SELECT * FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('i', $UserId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_all(MYSQLI_ASSOC);

    return $user ? $user[0] : [];
}

function addUser($username, $password_hash, $phone, $email, $status)
{
    global $conn;
    init_connection();

    if (emailExists($email)) {
        return false;
    }

    $sql = "INSERT INTO user(username,password_hash,phone,email,status) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $username, $password_hash, $phone, $email, $status);
    $stmt->execute();
}

function validateUser($username, $password_hash, $phone, $email)
{
    $errors = []; // Initialize an array to hold any error messages.

    // Validate title: check if it's not empty.
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    // Validate content: check if it's not empty.
    if (empty($password_hash)) {
        $errors['password_hash'] = "Password is required.";
    }

    if (empty($phone)) {
        $errors['phone'] = "Phone Number is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    }
    // Further file validation can be added here (e.g., file size, type)

    return $errors; // Return the array of errors.
}

function successLogin($email, $password)
{
    global $conn;
    init_connection();

    // Prepare SQL statement to prevent SQL injection
    $sql = "SELECT user_id FROM user WHERE email = ? AND password_hash = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $email, $password); // 'ss' specifies that both parameters are strings

    // Execute the statement
    $stmt->execute();

    // Get the result set from the prepared statement
    $result = $stmt->get_result();

    // Fetch the user data
    if ($user = $result->fetch_assoc()) {
        return $user['user_id']; // Return user ID if credentials are correct
    } else {
        return false; // Return false if login fails
    }
}

function validateUserForm($email, $password)
{
    $errors = [];

    // Validate content: check if it's not empty.
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    }
    // Further file validation can be added here (e.g., file size, type)

    return $errors; // Return the array of errors.
}

function restoreUser($id)
{
    global $conn;
    init_connection();
    $sql = "UPDATE user SET is_deleted = 0  , status = 1 WHERE user_id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('d', $id);
    $stmt->execute();
}

function editUser($username, $password_hash, $phone, $email, $userId)
{
    global $conn;
    init_connection();
    $sql = "UPDATE user SET username=?, password_hash=?, phone=?, email=? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisd", $username, $password_hash, $phone, $email, $userId);
    $stmt->execute();
}

function emailExists($email)
{
    global $conn;
    init_connection();
    $sql = "SELECT 1 FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}


/*
 * DAT
*/
/*
 * CLINIC
*/
// VALIDATE FORM
function validateFormClinic($name, $description, $phoneNumber, $address, $file, $id): array
{
    $errorMessages = [];
    if (empty($name)) {
        $errorMessages['name'] = 'Name is required.';
    }

    if (empty($description)) {
        $errorMessages['description'] = 'Description is required.';
    }

    if (empty($phoneNumber)) {
        $errorMessages['phoneNumber'] = 'Phonenumber is required.';
    }

    if (!is_numeric($phoneNumber)) {
        $errorMessages['phoneNumberIsNumber'] = 'Phonenumber must be number.';
    }
    if (strlen($phoneNumber) < 10 || strlen($phoneNumber) > 12) {
        $errorMessages['phoneNumberLength'] = 'Phone number must be between 10 and 14 characters.';
    }

    if (empty($address)) {
        $errorMessages['address'] = 'Address is required.';
    }
    if (!$id) {
        if (empty($file)) {
            $errorMessages['file'] = 'Upload failed or validation failed.';
        }
    }
    return $errorMessages;
}

// VALIDATE FILE
function validateFile($uploadedFile, $uploadedFileName)
{
    $fInfo = finfo_open(FILEINFO_MIME_TYPE);
    $uploadedFileType = finfo_file($fInfo, $uploadedFile);
    finfo_close($fInfo);
    if (strpos($uploadedFileType, 'image/') === 0) {
        $uploadDir = '../../img/';
        return extracted($uploadDir, $uploadedFileName, $uploadedFile);
    } else if (strpos($uploadedFileType, 'video/') === 0){
        $uploadDir = '../../vid/';
        return extracted($uploadDir, $uploadedFileName, $uploadedFile);
    } else {
        return false;
    }
}
function extracted(string $uploadDir, $uploadedFileName, $uploadedFile)
{
    $targetFile = $uploadDir . $uploadedFileName;
    if (file_exists($targetFile)) {
        $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        $uniqueFileName = uniqid() . '_' . time() . '.' . $extension;
        $targetFile = $uploadDir . $uniqueFileName;
    }
    if (move_uploaded_file($uploadedFile, $targetFile)) {
        return $targetFile;
    } else {
        return false;
    }
}

//CREATE
function addClinic($name, $address, $phonenumber, $description, $imagePath)
{
    global $conn;
    $conn->begin_transaction();
    // $isDeleted = '0';
    try {
        $sql_clinic = "INSERT INTO `clinic` (`clinic_name`, `clinic_address`, `clinic_phone_number`, `clinic_description`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_clinic);
        $stmt->bind_param("ssss", $name, $address, $phonenumber, $description);
        $stmt->execute();
        $clinic_id = $conn->insert_id;

        $sql_media = "INSERT INTO `media` (media_type, media_path) VALUES ('image', '$imagePath')";
        $conn->query($sql_media);
        $media_id = $conn->insert_id;

        $sql_itemMedia = "INSERT INTO `itemmedia` (item_id, media_id, item_type) VALUES ($clinic_id, $media_id, 'clinic')";
        $conn->query($sql_itemMedia);
        $conn->commit();
        header("location: index.php");
        echo "Chèn dữ liệu thành công!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }
}

// READ
function getAllClinic()
{
    global $conn;
    $sql = "SELECT *
            FROM clinic
            JOIN itemmedia ON clinic.clinic_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            WHERE itemmedia.item_type = 'clinic'";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}

// UPDATE
function getClinic($id)
{
    global $conn;
    $sql = "SELECT *
            FROM clinic
            JOIN itemmedia ON clinic.clinic_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            WHERE itemmedia.item_type = 'clinic' AND clinic.clinic_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all(MYSQLI_ASSOC);
    return $row ? $row[0] : [];
}

function updateClinic($name, $address, $phonenumber, $description, $imagePath, $id)
{
    global $conn;
    $sql = "UPDATE clinic
            JOIN itemmedia ON clinic.clinic_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET clinic_name = ?, clinic_address = ?, clinic_phone_number = ?, clinic_description = ?, media_path = ?
            WHERE itemmedia.item_type = 'clinic' AND clinic_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssd", $name, $address, $phonenumber, $description, $imagePath, $id);
    $stmt->execute();
    header("location:index.php");
}

// DELETE
function deleteClinic($id)
{
    global $conn;
    $sql = "UPDATE clinic
            JOIN itemmedia ON clinic.clinic_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET clinic_is_deleted = 1, item_is_deleted = 1, media_is_deleted = 1
            WHERE itemmedia.item_type = 'clinic' AND clinic_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

function restoreClinic($id)
{
    global $conn;
    $sql = "UPDATE clinic
            JOIN itemmedia ON clinic.clinic_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET clinic_is_deleted = 0, item_is_deleted = 0, media_is_deleted = 0
            WHERE itemmedia.item_type = 'clinic' AND clinic_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

/*
 * PRODUCT
*/

function validateFormProduct($name, $categoryProduct, $description, $price, $uploadedFileName, $id)
{
    $errorMessages = [];
    if (empty($name)) {
        $errorMessages['name'] = 'Name is required.';
    }
    if ($categoryProduct == 0) {
        $errorMessages['selected'] = 'Please select category.';
    }

    if (empty($description)) {
        $errorMessages['description'] = 'Description is required.';
    }

    if (empty($price)) {
        $errorMessages['price'] = 'Price is required.';
    }
    if (!is_numeric($price)) {
        $errorMessages['priceIsNumber'] = 'Price must be number.';
    }
    if (!$id) {
        if (empty($uploadedFileName)) {
            $errorMessages['file'] = 'File is required.';
        }
    }
    return $errorMessages;
}

// CREAT
function addProduct($name, $categoryProduct, $description, $price, $imagePath)
{
    global $conn;
    $conn->begin_transaction();
    // $isDeleted = '0';
    try {
        $sql_product = "INSERT INTO `products` (`product_name`, `category_id`, `product_description`, `product_price`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_product);
        $stmt->bind_param("sisd", $name, $categoryProduct, $description, $price);
        $stmt->execute();
        $product_id = $conn->insert_id;

        $sql_media = "INSERT INTO `media` (media_type, media_path) VALUES ('image', '$imagePath')";
        $conn->query($sql_media);
        $media_id = $conn->insert_id;

        $sql_itemMedia = "INSERT INTO `itemmedia` (item_id, media_id, item_type) VALUES ($product_id, $media_id, 'product')";
        $conn->query($sql_itemMedia);
        $conn->commit();
        header("location: index.php");
        echo "Chèn dữ liệu thành công!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }
}

// READ
function getAllProduct()
{
    global $conn;
    $sql = "SELECT *
            FROM category
            JOIN products ON category.category_id = products.category_id
            JOIN itemmedia ON products.product_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            WHERE category.parent_id = 4 AND itemmedia.item_type = 'product'";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}

function getAllCategoryProduct()
{
    global $conn;
    $sql = "SELECT * FROM category WHERE category.parent_id = 4 AND category.category_is_deleted = 0";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}

function getProduct($id)
{
    global $conn;
    $sql = "SELECT * 
            FROM products 
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

// UPDATE
function updateProduct($name, $categoryProduct, $description, $price, $imagePath, $id)
{
    global $conn;
    try {
        $sql = "UPDATE products
            JOIN itemmedia ON products.product_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET product_name = ?, category_id = ?, product_description = ?, product_price = ?, media_path = ?
            WHERE product_id = ? AND item_type = 'product'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdsdsd", $name, $categoryProduct, $description, $price, $imagePath, $id);
        $stmt->execute();
        header("location:index.php");
    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }
    // header("location:index.php");
}

// DELETE
function deleteProduct($id)
{
    global $conn;
    $sql = "UPDATE products
            JOIN itemmedia ON products.product_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET product_is_deleted = 1, item_is_deleted = 1, media_is_deleted = 1
            WHERE product_id = ? AND item_type = 'product'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
}

function restoreProduct($id)
{
    global $conn;
    $sql = "UPDATE products
            JOIN itemmedia ON products.product_id = itemmedia.item_id
            JOIN media ON itemmedia.media_id = media.media_id
            SET product_is_deleted = 0, item_is_deleted = 0, media_is_deleted = 0
            WHERE product_id = ? AND item_type = 'product'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
}

/*
 * CONTACT US
*/
function getAllContact()
{
    global $conn;
    $sql = "SELECT * FROM contactus ORDER BY contactus.contact_created_at";
    $query = $conn->query($sql);
    return $query->fetch_All(MYSQLI_ASSOC);
}

function deleteContact($id)
{
    global $conn;
    $sql = "UPDATE contactus
            SET contact_is_deleted = 1
            WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
}

function restoreContact($id)
{
    global $conn;
    $sql = "UPDATE contactus
            SET contact_is_deleted = 0
            WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $id);
    $stmt->execute();
}