/*Account*/
CREATE TABLE account(
	accountID   CHAR(5) PRIMARY KEY,
	name        VARCHAR(20),
	age         INT(2),
	email       VARCHAR(50),
	password    VARCHAR(12),
	accountType VARCHAR(10)
  );

INSERT INTO  account 
VALUES  ("A1111" , "Ernest" , "19","admin1","admin1","admin"),
		("A2222" , "Khai Jun", "19", "admin2","admin2","admin"),
        ("00000" , "Keat Yee", "19", "00000","00000","superuser");


/*Foodbank*/
CREATE TABLE foodbank (
    foodBankNo INT PRIMARY KEY AUTO_INCREMENT,
    location VARCHAR(20),
    contactNum VARCHAR(20),
	address VARCHAR(100),
	openHour TIME,
	closeHour TIME
  );

INSERT INTO foodbank (location, contactNum, address, openHour, closeHour)
VALUES  ("Selangor" , "03-8736 0111", "No.15 Jalan BA 2/1 Kawasan Perindustrian, Bukit Angkat, 43000 Kajang, Selangor", '09:00:00', '12:00:00'),
		("Wilayah Persekutuan" , "012-329 3256","47-1, Jalan Tiga, Chan Sow Lin, 55200 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur", '09:00:00', '12:00:00'),
		("Johor" , "03-9226 5500", "Level 16, Menara Landmark,No. 12, Jalan Ngee Heng, 80000 Johor Bahru, Johor, Malaysia", '09:00:00', '12:00:00'),
		("Kedah" , "017-338 8462", " 62, Jalan Zamrud 3, Taman Pelangi, 05150 Alor Setar, Kedah, Malaysia", '09:00:00', '12:00:00'),
		("Melaka" , "010-234 5677", "3, Lorong Seri Wangsa 9/1, Kampung Tengah, 75350 Melaka, Malaysia", '09:00:00', '12:00:00'),
		("Pulau Pinang" , "012-235 7777", "No 11, Jalan Bukit Kempas 4/1 Taman Bukit Kempas , Jhr 81200",'09:00:00', '12:00:00' );

/*Fooditem*/
CREATE TABLE foodItem (
    foodItemID CHAR(5) PRIMARY KEY,
    name VARCHAR(20),
    description VARCHAR(50)
  );

INSERT INTO foodItem (foodItemID, name, description) 
VALUES  ('FI001', 'bread', 'A staple food made from flour.'),
		('FI002', 'rice', 'A grain that is a staple food in many cultures.'),
		('FI003', 'canned food', 'Food items that are preserved in cans.'),
		('FI004', 'cooking oil', 'Oil used for cooking and frying.'),
		('FI005', 'cereal', 'A breakfast food typically made from grains.');

/*Food Donation*/
CREATE TABLE foodDonation (
    foodDonationID INT PRIMARY KEY AUTO_INCREMENT,
    `date` DATE,
    `time` TIME,
    contactNum VARCHAR(20),
    address VARCHAR(50),
    city VARCHAR(30),
    postcode VARCHAR(10),
    state VARCHAR(20),
    status VARCHAR(20),
    foodBankNo INT,
    accountID CHAR(8),
    FOREIGN KEY (foodBankNo) REFERENCES foodbank(foodBankNo),
    FOREIGN KEY (accountID) REFERENCES account(accountID)
  );

/*Food Donation Item*/
CREATE TABLE foodDonationItem (
    foodDonationID INT,
    foodItemID CHAR(5),
    quantity INT,
    PRIMARY KEY (foodDonationID, foodItemID),
    FOREIGN KEY (foodDonationID) REFERENCES foodDonation(foodDonationID),
    FOREIGN KEY (foodItemID) REFERENCES foodItem(foodItemID)
  );

/*Foodbank Inventory*/
CREATE TABLE foodBankInventory (
    foodBankNo INT,
    foodItemID CHAR(5),
    quantity INT,
    PRIMARY KEY (foodBankNo, foodItemID),
    FOREIGN KEY (foodBankNo) REFERENCES foodbank(foodBankNo),
    FOREIGN KEY (foodItemID) REFERENCES foodItem(foodItemID)
  );
