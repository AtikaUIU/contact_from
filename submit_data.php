<?php
     include 'db_connection.php'; 
     include 'function_file_uploader.php';
  //echo '<pre>'.print_r($_REQUEST, true).'</pre>';
  //echo '<pre>'.print_r($_FILES, true).'</pre>';
  $person_name = trim($_POST['user_name']);
  $person_email = trim($_POST['user_email']);
  $person_message = addslashes($_POST['user_message']);

  if($_FILES)
  {
    $user_file = $_FILES['user_file'];
    $upload_file_status = file_uploader('uploads/', $user_file);
   
    $file_status = json_decode($upload_file_status, true);
   // echo '<pre>'.print_r($file_status, true).'</pre>';
  }

  if($person_name!= '')
  {
    //(Condition) ? (Statement1) : (Statement2);
    $file_name = ($file_status['error']) ? '' : $file_status['success'];
    $data = [
      'user_name'   => $person_name,
      'user_email'  => $person_email,
      'user_message'       => $person_message,
      'user_file'     => $file_name
  ];
  insert_data('user_info', $conn, $data);
        session_start();
        $_SESSION['user_data'] = $data;
  }
  header("location: index.php");
