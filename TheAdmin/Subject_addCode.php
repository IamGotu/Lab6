<?php
session_start();
include('../database/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSubject'], $_POST['student_id'], $_POST['subjects'])) {
        $student_id = $_POST['student_id'];
        echo "Student ID: $student_id"; // Debugging line
        $subjects = $_POST['subjects'];

        // Convert subject array to comma-separated string
        $enrolled_subjects = implode(', ', $subjects);

        // Update subjects field in student_list table
        $update_query = "UPDATE students SET subjects = ? WHERE student_id = ?";
        
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $update_query);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "si", $enrolled_subjects, $student_id);
        
        // Execute the statement
        $update_result = mysqli_stmt_execute($stmt);

        // Check if the update was successful
        if ($update_result) {
            $_SESSION['auth_status'] = "Subjects added successfully";
        } else {
            $_SESSION['auth_status'] = "Error updating subjects: " . mysqli_error($conn);
        }

        header('Location: ../TheAdmin/Subjects_enroll.php');
        exit();
    } else {
        $_SESSION['auth_status'] = "No subjects selected";
        header('Location: ../TheAdmin/Subjects_enroll.php');
        exit();
    }
}
?>