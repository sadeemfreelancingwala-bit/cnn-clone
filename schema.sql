CREATE TABLE IF NOT EXISTS users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100) UNIQUE,
 password VARCHAR(255),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(50),
 slug VARCHAR(50)
);

INSERT IGNORE INTO categories (name,slug) VALUES
('World','world'),
('Sports','sports'),
('Technology','technology'),
('Entertainment','entertainment');

CREATE TABLE IF NOT EXISTS news (
 id INT AUTO_INCREMENT PRIMARY KEY,
 title TEXT,
 short_description TEXT,
 content TEXT,
 image_url TEXT,
 category_id INT,
 is_featured TINYINT(1),
 views INT DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
