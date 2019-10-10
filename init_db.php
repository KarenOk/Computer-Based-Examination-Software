<?php

include_once "process/logout.php";

$servername = "localhost";
$username = "pmauser";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB
$sql = "CREATE DATABASE CBE";
if ($GLOBALS['conn']->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $GLOBALS['conn']->error;
}

include_once "helpers/init.php";

// Create Tables
$table1 = "CREATE TABLE User (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(8) NOT NULL UNIQUE,
    user_type VARCHAR(8) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($GLOBALS['conn']->query($table1) === TRUE) {
        echo "Table User created successfully";
    } else {
        echo "Error creating table: " . $GLOBALS['conn']->error;
    }
    
    // sql to create table
    $table2 = "CREATE TABLE start_exam (
    Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course VARCHAR(8) NOT NULL,
    category VARCHAR(50),
    exam_tag VARCHAR(50),
    exam_duration INT(6),
    question_limit INT(6)	 
    )";
    
    if ($conn->query($table2) === TRUE) {
        echo "Table start_exam created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
    
    // sql to create table
    $table3 = "CREATE TABLE eeg_501 (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    exam_tag VARCHAR(50),
    question VARCHAR(100) NOT NULL,
    optionA VARCHAR(100),
    optionB VARCHAR(100),
    optionC VARCHAR(100),
    optionD VARCHAR(100),
    optionE VARCHAR(100),
    correct_ans VARCHAR(100)	 
    )";
    
    if ($conn->query($table3) === TRUE) {
        echo "Table eeg_501 created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    


    // Populate Tables
    
    // Admin
    $table1data = "INSERT INTO User (username, password, user_type) VALUES ('Admin', 'haha', 'admin')";
    
    if ($conn->query($table1data) === TRUE) {
        echo "New record created successfully t1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    // Examiner
    $table1data = "INSERT INTO User (username, password, user_type) VALUES ('Examiner', 'haha', 'examiner')";
    
    if ($conn->query($table1data) === TRUE) {
        echo "New record created successfully t1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Student
    $table1data = "INSERT INTO User (username, password, user_type) VALUES ('Student', 'haha', 'student')";
    
    if ($conn->query($table1data) === TRUE) {
        echo "New record created successfully t1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $table2data = "INSERT INTO start_exam (course, category, exam_tag, exam_duration, question_limit)
    VALUES ('eeg', '501', 'Part A', 2 , 10)";
    
    if ($conn->query($table2data) === TRUE) {
        echo "New record created successfully t2";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    $q1 = "INSERT INTO eeg_501 (question, exam_tag, optionA, optionB, optionC, optionD, optionE, correct_ans)
    VALUES (
    'What is Kirchoff\'s Voltage Law?', 
    'Part A',
    'The sum of all voltages is zero.',
    'It states that the total current around a closed loop must be zero.', 
    'It states that the total voltage around a closed loop must be zero.', 
    'A and C above',
    'None of the above',
    'It states that the total voltage around a closed loop must be zero.'
    ), (
    'What is Kirchoff\'s Current Law?', 
    'Part A',
    'The sum of all currents is zero.',
    'It states that the total current around a closed loop must be zero.', 
    'It states that the total voltage around a closed loop must be zero.', 
    'A and B above',
    'None of the above',
    'It states that the total current around a closed loop must be zero.'
    )";
    
    if ($conn->query($q1) === TRUE) {
        echo "New record created successfully t3";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    

$GLOBALS['con']->close();
?>