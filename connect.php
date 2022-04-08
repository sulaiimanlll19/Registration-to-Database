<?php

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if( !empty($email) || !empty($username) || !empty($password) ){

        // Create connection
        $conn = new mysqli('localhost','root','','game');

        if(mysqli_connect_error()){
            die('Connect error ( '. mysqli_connect_errno().' )'. mysqli_connect_error());
        }else{

            $SELECT = "SELECT email From users Where email = ? Limit 1";
            $INSERT = "INSERT Into users (email, username, password) values(?, ?, ?)";

            // prepare steatement
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if( $rnum == 0 ){
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $email, $username, $password);
                $stmt->execute();
                echo 'New record Successfully...';
            }else{
                echo 'This email Already registered!!!';
            }
            $stmt->close();
            $conn->close();
        }


    }else{
        echo 'All fields are required!';
        die();
    }




    // Working Code but WITHOUT checking if registered or not


    // $email = $_POST['email'];
    // $username = $_POST['username'];
    // $password = $_POST['password'];

    // // Database connection
    // $conn = new mysqli('localhost','root','','game');
    // if($conn->connect_error){

    //     die('Connection Failed : '.$conn->connect_error);
    // }else{

    //     $stmt = $conn->prepare("insert into users(email, username, password) values(?, ?, ?)");
    //     $stmt->bind_param("sss", $email, $username, $password);
    //     $stmt->execute();
    //     echo "Registration Successfully...";
    //     $stmt->close();
    //     $conn->close();
    // }

?>