CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('pending', 'failed', 'done'),
    type ENUM('image_resize, send_email'),
    options VARCHAR(1000),
    created_at TIMESTAMP NOT NULL DEFAULT 0,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
