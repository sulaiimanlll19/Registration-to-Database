<?php

    $email = $_POST['email']; // The attribute NAME in the HTML code should same with POST method
    $username = $_POST['username']; // The attribute NAME in the HTML code should same with POST method
    $password = $_POST['password']; // The attribute NAME in the HTML code should same with POST method

    // Checking if fields of regiatrtion are empty or not
    if( !empty($email) || !empty($username) || !empty($password) ){

        // Create connection
        $conn = new mysqli('localhost','root','','game'); // default attributes --> 'game' is my database name

        // Checking connection
        if(mysqli_connect_error()){
            die('Connect error ( '. mysqli_connect_errno().' )'. mysqli_connect_error());
        }else{

            $SELECT = "SELECT email From users Where email = ? Limit 1"; // Limiting the email registration to ONE to not repeating
            $INSERT = "INSERT Into users (email, username, password) values(?, ?, ?)"; // Inserting values into my 'users' table -- each '?' represent a variable

            // prepare steatement
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if( $rnum == 0 ){ // Checking if email already registered or not
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $email, $username, $password);
                $stmt->execute();
                echo 'New record Successfully...';
            }else{ // if yes then send this message
                echo 'This email Already registered!!!';
            }
            $stmt->close(); // Close database
            $conn->close(); // Close connection
        }


    }else{ // if field empty send this meesage
        echo 'All fields are required!';
        die();
    }

?>