

-- Category Table --
DROP TABLE IF EXISTS category;
CREATE TABLE category(
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(255));
INSERT INTO category(category_name)
VALUES
("Birthday Cakes"),
("Weddign Cakes"),
("Other Ocasions");
SELECT * FROM category;

-- MenuItems table -- 
DROP TABLE IF EXISTS menu_items;
CREATE TABLE menu_items(
id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  description VARCHAR(255),
  category_id INT,
  quantity INT, 
  price INT,
  image VARCHAR(255),
  FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE);  
INSERT INTO menu_items(name, description, category_id, quantity,  price, image)
VALUES 
( "Napoleon Cake", "A classic Russian cakes, made of very thin and flaky puff pastry cake layers and a smooth, rich and luscious pastry cream in between the layers.", 1, 5,  25, "img/napolon-cake.jpg"),
( "Honey Cake", "A Russian gravity-defying layered cake with notes of honey and caramel. It is decadent, beautiful and absolutely delicious.", 1, 5, 30, "img/honey-cake.jpeg"),
( "Smetannik Cake", "A Russian cake that has multiple thin and fluffy cake layers with a tangy and sweet sour cream frosting. The cake is so tender and delicate, it just melts in your mouth.", 1, 5, 30, "img/Smetannik-Cake.jpeg"),
( "Ptichye Moloko (Bird’s milk)", "The thick soufflé covered with dark chocolate is one of Russia’s most beloved treats! This was the first cake to be patented in the Soviet Union in 1982.", 3, 5, 35, "img/cake-4.jpg"),
( "Nuts Cupcake", "The thick soufflé covered with dark chocolate is one of Russia’s most beloved treats! This was the first cake to be patented in the Soviet Union in 1982.", 3, 5, 12, "img/nuts-cupcake.jpg"),
( "Simple Murshmellou", "The thick soufflé covered with dark chocolate is one of Russia’s most beloved treats! This was the first cake to be patented in the Soviet Union in 1982.", 3, 5, 35, "img/beze.jpg"),
( "Berryes Filled Beze", "The thick soufflé covered with dark chocolate is one of Russia’s most beloved treats! This was the first cake to be patented in the Soviet Union in 1982.", 3, 5,  35, "img/beze2.jpg");
SELECT * FROM menu_items;



-- User table --
DROP TABLE IF EXISTS users;
CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,
 first_name VARCHAR(255) not null,
 last_name VARCHAR(255) not null,
 email VARCHAR(255) not null,
 phone VARCHAR(15) ,
 password VARCHAR(255) not null ,
 address1 VARCHAR(255) not null,
 address2 Varchar(255),
 city VARCHAR(255) not null,
 state VARCHAR(2) not null,
 zip int(5) not null,
 card_number VARCHAR(16)not null ,
 exp_month int(2)  not null,
 exp_year int (4) not null, 
 card_cvv INT (3) not null,
 image_name VARCHAR (255),
 image_data MEDIUMBLOB
 ); 
 SELECT * FROM users;
 
 
 -- Orders History Table--
DROP TABLE IF EXISTS orders; 
 CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending',
  `ordered_date` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
select * from orders;


 -- Orders History Table--
DROP TABLE IF EXISTS ordered_items;
CREATE TABLE ordered_items (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price` INT NOT NULL,
  `quantity` int(2) NOT NULL,
  `ordered_date` date DEFAULT NULL
  `last_updated` date DEFAULT NULL,
  `status` enum( 'Processing','Baking','Assembling','Ready') DEFAULT 'Processing',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE orders AUTO_INCREMENT = 1000;
select * from ordered_items;

-- Favorite Items Table --
DROP TABLE IF EXISTS favorites;
CREATE TABLE favorites(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id Int NOT NULL,
  item_id int NOT NULL unique,
  is_favorite bool default true
 );
SELECT * FROM favorites;

SELECT menu_items.id, menu_items.name, menu_items.description, menu_items.price, menu_items.image, favorites.is_favorite
FROM favorites
RIGHT JOIN menu_items
on favorites.`item_id` = menu_items.id and favorites.user_id = 1 WHERE favorites.user_id=1 ;

-- Contact Form Table --
DROP TABLE IF EXISTS contact;
CREATE TABLE contact(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) not null,
  email varchar (255) NOT NULL,
  message text NOT NULL
 );
SELECT * FROM contact;

