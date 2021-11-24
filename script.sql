create database literie3000;

CREATE TABLE IF NOT EXISTS brands(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL 
)   
CREATE TABLE IF NOT EXISTS sizes(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    type VARCHAR(50) NOT NULL
   
)
create table if not exists matelas(
    id INT PRIMARY KEY  AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL, 
    id_brands INT,
    id_sizes int,
    prix DECIMAL (5,2) NOT NULL,
    prix_discount DECIMAL(5,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_brands) references brands(id),
    FOREIGN KEY (id_sizes) references sizes (id)
    
)





INSERT INTO  brands (name)  VALUES ("epeda"),("dreamway"),("bultex"), ("DorsoLine"), ("MemoryLine");

INSERT INTO sizes (type)
VALUES
("90x190"),
("140x190"),
("160x190"),
("180x190"),
("200x190")

INSERT INTO matelas(name,  id_brands, id_sizes, prix, prix_discount, image ) 
values 
("Poupoune", "1","1", "759", "529", "https://www.lelit.fr/wp-content/uploads/2021/05/matelas-SAVOY.png"),
("Grange","2","1", "809", "709.00", "https://www.outletsofadirect.fr/11181-large_default/matelas-privilege-en-mousse-%C3%A0-m%C3%A9moire-de-forme-haut-de-gamme-30-cm-naturalex.jpg"),
("Ratatouille","3","2","759", "529","https://img.grouponcdn.com/deal/xFVvkJMxK4yo6ps7ppEsN3LcGec/xF-960x576/v1/t600x362.jpg"),
("Directeur", "1","3", "1019", "509.00", "https://www.lematelas365.com/modules/ps_imageslider/images/b99606b84fc3ed11f46c8a0831154caf8a675092_04df189495b745d5b0f9ad9545c9279b4f93fd74_MATELAS-new-hp.jpg")