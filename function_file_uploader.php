<?php

function file_uploader($upload_dir, $file_details)
{
    $target_file = $upload_dir . basename($file_details["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $file_status =array();

    // Check if file already exists
    if (file_exists($target_file)) {
        $file_status['error'] = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file_details["size"] > 500000) {
        $file_status['error'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $file_status['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk != 0) {
        if (move_uploaded_file($file_details["tmp_name"], $target_file)) {
            $file_status['success'] = $file_details["name"];
        } else {
            $file_status['error'] = "Sorry, there was an error uploading your file.";
        }
       return json_encode($file_status);
       // echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        return json_encode($file_status);
    }
}

function insert_data($table_name, $db_connection, $insert_data) {
    $column = array_keys($insert_data);
    $values = array_values($insert_data);

    //$sql = "INSERT INTO MyGuests (firstname, lastname, email)VALUES ('John', 'Doe', 'john@example.com')";
    $sql = "INSERT INTO $table_name (".implode(', ', $column).") VALUES ('".implode("', '", $values)."') ";

    if ($db_connection->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $db_connection->error;
    }
    
    $db_connection->close();
}
?>