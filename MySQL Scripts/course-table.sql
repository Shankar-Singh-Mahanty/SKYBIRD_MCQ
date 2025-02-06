-- Table Creation

CREATE TABLE course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Insert initial data into units table
INSERT INTO course (name) VALUES 
('CA'),
('CMA');