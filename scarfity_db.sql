CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price INT,
    image VARCHAR(100),
    type VARCHAR(50)
);

INSERT INTO products (name, price, image, type) VALUES
('Layali Veil', 200, 'printed1.jpeg', 'printed'),
('Safa Wear', 200, 'printed2.jpeg', 'printed'),
('Riwaq Hijab', 250, 'printed3.jpeg', 'printed'),
('Areej Veil', 240, 'printed4.jpeg','printed'),
('Hijab Luxe', 230, 'printed5.jpeg', 'printed'),
('Floral Print', 270, 'printed6.jpeg', 'printed'),
('Velvet Hijab', 280, 'printed7.jpeg', 'printed'),
('Lumi Veil', 240, 'printed8.jpeg', 'printed'),
('Aura Veil', 230, 'printed9.jpeg', 'prined'),
('Pure Modest', 270, 'printed10.jpeg', 'printed'),
('Elegant Veil', 240, 'printed11.jpeg', 'printed'),
('Daily Veil', 200, 'printed12.jpeg', 'printed'),
('simple print hijab', 250, 'printed13.jpeg', 'printed'),
('flower hijab', 180, 'printed14.jpeg', 'printed'),
('Chic Print Hijab', 220, 'printed15.jpeg', 'printed'),
('FERN Classic', 130, 'basic1.jpeg', 'plain'),
('burgundy classic', 170, 'basic2.jpeg', 'plain'),
('brown classic', 140, 'basic3.jpeg', 'plain'),
('night blue Classic', 130, 'basic4.jpeg', 'plain'),
('black classic', 170, 'basic5.jpeg', 'plain'),
('mint Classic', 130, 'basic6.jpeg', 'plain'),
('coffee classic', 170, 'basic7.jpeg', 'plain'),
('chiffon classic', 140, 'basic8.jpeg', 'plain'),
('baby pink Classic', 130, 'basic19.jpeg', 'plain'),
('baby blue classic', 170, 'basic10.jpeg', 'plain'),
(' night blue Classic', 130, 'basic11.jpeg', 'plain'),
('chili classic', 170, 'basic12.jpeg', 'plain'),
('white classic', 140, 'basic13.jpeg', 'plain'),
('yellow Classic', 130, 'basic14.jpeg', 'plain'),
('lilac classic', 170, 'basic15.jpeg', 'plain');


CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL, 
    second_name VARCHAR(100),
    phone VARCHAR(20) NOT NULL,
    phone2 VARCHAR(20),
    address TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    governorate VARCHAR(100) NOT NULL DEFAULT AFTER address,
    notes TEXT,
    payment_method VARCHAR(20) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    total_quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_name VARCHAR(255),
    price DECIMAL(10,2),
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);