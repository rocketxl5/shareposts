-- https://www.javatpoint.com/mysql-foreign-key
-- Create table posts with foreign key constraint
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT,
    NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    CONSTRAINT author FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- https://stackoverflow.com/questions/1997998/insert-data-into-tables-linked-by-foreign-key
-- Insert new posts with author constraint pointing to users.id of users table
INSERT INTO
    posts (title, body, user_id)
VALUES
    (
        'Post title',
        'Post body',
        (
            SELECT
                id
            FROM
                users
            WHERE
                id = < number >
        )
    );