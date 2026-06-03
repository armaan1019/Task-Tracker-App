This app uses html, css, js, and php to allow users to track their tasks.

We also utilize MySQL to store users and tasks. 

To create the DB open phpmyadmin and:

1) Run: CREATE DATABASE task_tracker;
2) Go into the database task_tracker
3) Run: CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
