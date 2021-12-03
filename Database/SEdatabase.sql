CREATE DATABASE SE;
USE SE;

DROP TABLE Accounts;
DROP TABLE Personal;
DROP TABLE History;
DROP TABLE Reservation;
DROP TABLE Company;

create table Accounts(
   username VARCHAR(100),
   encryptedpassword VARCHAR(100),
   PRIMARY KEY ( username )
);

create table Personal(
   username VARCHAR(100),
   firstname VARCHAR(100),
   lastname VARCHAR(100),
   email VARCHAR(100),
   phone VARCHAR(100),
   mailing VARCHAR(100),
   billing VARCHAR(100),
   favorite VARCHAR(100),
   checkrouthing INT,
   checkaccount INT,
   cardnumber VARCHAR(100),
   cardmonth VARCHAR(100),
   cardyear VARCHAR(100),
   csc INT,
   onfile BOOLEAN,
   points INT,
   PRIMARY KEY ( username )
);

create table History(
   id INT,
   lastname VARCHAR(100),
   phone VARCHAR(100),
   email VARCHAR(100),
   whichday VARCHAR(100),
   whichtime VARCHAR(100),
   tablestaken VARCHAR(100),
   PRIMARY KEY ( id )
);

create table Company(
   daytype VARCHAR(100),
   hightraffic BOOLEAN,
   fee INT,
   PRIMARY KEY ( daytype )
);

create table Reservation(
   id INT,
   tablenumber INT,
   selectday VARCHAR(100),
   selecttime VARCHAR(100),
   seating INT,
   taken BOOLEAN,
   PRIMARY KEY ( id )
);

INSERT INTO Accounts(username, encryptedpassword)
VALUES('person123', '4VcqfMk/L9o=');

INSERT INTO Personal(username, firstname, lastname, email, phone, mailing, billing, favorite, checkrouthing, checkaccount, cardnumber, cardmonth, cardyear, csc, onfile, points)
VALUES('person123', 'bob', 'joe', 'bob@cheapboi.com', '888-888-8888', '123 street', '123 street', 'check', 88888888, 88888888, "NONE", 'NONE', 'NONE', -1, FALSE, 0);

INSERT INTO History(id, lastname, phone, email, whichday, whichtime, tablestaken)
VALUES(0, 'joe', '888-888-8888', 'bob@cheapboi.com','testday', 'testtime', 'none');

INSERT INTO Company(daytype, hightraffic, fee)
VALUES
('monday', FALSE, 0),
('tuesday', FALSE, 0),
('wednesday', FALSE, 0),
('thursday', FALSE, 0),
('friday', TRUE, 10),
('saturday', TRUE, 10),
('sunday', TRUE, 10);

INSERT INTO Reservation(id, tablenumber, selectday, selecttime, seating, taken)
VALUES
(1, 1, 'monday', "7:00 PM", 2, FALSE),
(2, 1, 'monday', "8:00 PM", 2, FALSE),
(3, 1, 'monday', "9:00 PM", 2, FALSE),

(4, 2, 'monday', "7:00 PM", 2, FALSE),
(5, 2, 'monday', "8:00 PM", 2, FALSE),
(6, 2, 'monday', "9:00 PM", 2, FALSE),

(7, 3, 'monday', "7:00 PM", 2, FALSE),
(8, 3, 'monday', "8:00 PM", 2, FALSE),
(9, 3, 'monday', "9:00 PM", 2, FALSE),

(10, 4, 'monday', "7:00 PM", 2, FALSE),
(11, 4, 'monday', "8:00 PM", 2, FALSE),
(12, 4, 'monday', "9:00 PM", 2, FALSE),

(13, 5, 'monday', "7:00 PM", 4, FALSE),
(14, 5, 'monday', "8:00 PM", 4, FALSE),
(15, 5, 'monday', "9:00 PM", 4, FALSE),

(16, 6, 'monday', "7:00 PM", 4, FALSE),
(17, 6, 'monday', "8:00 PM", 4, FALSE),
(18, 6, 'monday', "9:00 PM", 4, FALSE),

(19, 7, 'monday', "7:00 PM", 6, FALSE),
(20, 7, 'monday', "8:00 PM", 6, FALSE),
(21, 7, 'monday', "9:00 PM", 6, FALSE),

(22, 8, 'monday', "7:00 PM", 6, FALSE),
(23, 8, 'monday', "8:00 PM", 6, FALSE),
(24, 8, 'monday', "9:00 PM", 6, FALSE),

(25, 9, 'monday', "7:00 PM", 8, FALSE),
(26, 9, 'monday', "8:00 PM", 8, FALSE),
(27, 9, 'monday', "9:00 PM", 8, FALSE),

(28, 10, 'monday', "7:00 PM", 8, FALSE),
(29, 10, 'monday', "8:00 PM", 8, FALSE),
(30, 10, 'monday', "9:00 PM", 8, FALSE),

(31, 1, 'tuesday', "7:00 PM", 2, FALSE),
(32, 1, 'tuesday', "8:00 PM", 2, FALSE),
(33, 1, 'tuesday', "9:00 PM", 2, FALSE),

(34, 2, 'tuesday', "7:00 PM", 2, FALSE),
(35, 2, 'tuesday', "8:00 PM", 2, FALSE),
(36, 2, 'tuesday', "9:00 PM", 2, FALSE),

(37, 3, 'tuesday', "7:00 PM", 2, FALSE),
(38, 3, 'tuesday', "8:00 PM", 2, FALSE),
(39, 3, 'tuesday', "9:00 PM", 2, FALSE),

(40, 4, 'tuesday', "7:00 PM", 2, FALSE),
(41, 4, 'tuesday', "8:00 PM", 2, FALSE),
(42, 4, 'tuesday', "9:00 PM", 2, FALSE),

(43, 5, 'tuesday', "7:00 PM", 4, FALSE),
(44, 5, 'tuesday', "8:00 PM", 4, FALSE),
(45, 5, 'tuesday', "9:00 PM", 4, FALSE),

(46, 6, 'tuesday', "7:00 PM", 4, FALSE),
(47, 6, 'tuesday', "8:00 PM", 4, FALSE),
(48, 6, 'tuesday', "9:00 PM", 4, FALSE),

(49, 7, 'tuesday', "7:00 PM", 6, FALSE),
(50, 7, 'tuesday', "8:00 PM", 6, FALSE),
(51, 7, 'tuesday', "9:00 PM", 6, FALSE),

(52, 8, 'tuesday', "7:00 PM", 6, FALSE),
(53, 8, 'tuesday', "8:00 PM", 6, FALSE),
(54, 8, 'tuesday', "9:00 PM", 6, FALSE),

(55, 9, 'tuesday', "7:00 PM", 8, FALSE),
(56, 9, 'tuesday', "8:00 PM", 8, FALSE),
(57, 9, 'tuesday', "9:00 PM", 8, FALSE),

(58, 10, 'tuesday', "7:00 PM", 8, FALSE),
(59, 10, 'tuesday', "8:00 PM", 8, FALSE),
(60, 10, 'tuesday', "9:00 PM", 8, FALSE),

(61, 1, 'wednesday', "7:00 PM", 2, FALSE),
(62, 1, 'wednesday', "8:00 PM", 2, FALSE),
(63, 1, 'wednesday', "9:00 PM", 2, FALSE),

(64, 2, 'wednesday', "7:00 PM", 2, FALSE),
(65, 2, 'wednesday', "8:00 PM", 2, FALSE),
(66, 2, 'wednesday', "9:00 PM", 2, FALSE),

(67, 3, 'wednesday', "7:00 PM", 2, FALSE),
(68, 3, 'wednesday', "8:00 PM", 2, FALSE),
(69, 3, 'wednesday', "9:00 PM", 2, FALSE),

(70, 4, 'wednesday', "7:00 PM", 2, FALSE),
(71, 4, 'wednesday', "8:00 PM", 2, FALSE),
(72, 4, 'wednesday', "9:00 PM", 2, FALSE),

(73, 5, 'wednesday', "7:00 PM", 4, FALSE),
(74, 5, 'wednesday', "8:00 PM", 4, FALSE),
(75, 5, 'wednesday', "9:00 PM", 4, FALSE),

(76, 6, 'wednesday', "7:00 PM", 4, FALSE),
(77, 6, 'wednesday', "8:00 PM", 4, FALSE),
(78, 6, 'wednesday', "9:00 PM", 4, FALSE),

(79, 7, 'wednesday', "7:00 PM", 6, FALSE),
(80, 7, 'wednesday', "8:00 PM", 6, FALSE),
(81, 7, 'wednesday', "9:00 PM", 6, FALSE),

(82, 8, 'wednesday', "7:00 PM", 6, FALSE),
(83, 8, 'wednesday', "8:00 PM", 6, FALSE),
(84, 8, 'wednesday', "9:00 PM", 6, FALSE),

(85, 9, 'wednesday', "7:00 PM", 8, FALSE),
(86, 9, 'wednesday', "8:00 PM", 8, FALSE),
(87, 9, 'wednesday', "9:00 PM", 8, FALSE),

(88, 10, 'wednesday', "7:00 PM", 8, FALSE),
(89, 10, 'wednesday', "8:00 PM", 8, FALSE),
(90, 10, 'wednesday', "9:00 PM", 8, FALSE),

(91, 1, 'thursday', "7:00 PM", 2, FALSE),
(92, 1, 'thursday', "8:00 PM", 2, FALSE),
(93, 1, 'thursday', "9:00 PM", 2, FALSE),

(94, 2, 'thursday', "7:00 PM", 2, FALSE),
(95, 2, 'thursday', "8:00 PM", 2, FALSE),
(96, 2, 'thursday', "9:00 PM", 2, FALSE),

(97, 3, 'thursday', "7:00 PM", 2, FALSE),
(98, 3, 'thursday', "8:00 PM", 2, FALSE),
(99, 3, 'thursday', "9:00 PM", 2, FALSE),

(100, 4, 'thursday', "7:00 PM", 2, FALSE),
(101, 4, 'thursday', "8:00 PM", 2, FALSE),
(102, 4, 'thursday', "9:00 PM", 2, FALSE),

(103, 5, 'thursday', "7:00 PM", 4, FALSE),
(104, 5, 'thursday', "8:00 PM", 4, FALSE),
(105, 5, 'thursday', "9:00 PM", 4, FALSE),

(106, 6, 'thursday', "7:00 PM", 4, FALSE),
(107, 6, 'thursday', "8:00 PM", 4, FALSE),
(108, 6, 'thursday', "9:00 PM", 4, FALSE),

(109, 7, 'thursday', "7:00 PM", 6, FALSE),
(110, 7, 'thursday', "8:00 PM", 6, FALSE),
(111, 7, 'thursday', "9:00 PM", 6, FALSE),

(112, 8, 'thursday', "7:00 PM", 6, FALSE),
(113, 8, 'thursday', "8:00 PM", 6, FALSE),
(114, 8, 'thursday', "9:00 PM", 6, FALSE),

(115, 9, 'thursday', "7:00 PM", 8, FALSE),
(116, 9, 'thursday', "8:00 PM", 8, FALSE),
(117, 9, 'thursday', "9:00 PM", 8, FALSE),

(118, 10, 'thursday', "7:00 PM", 8, FALSE),
(119, 10, 'thursday', "8:00 PM", 8, FALSE),
(120, 10, 'thursday', "9:00 PM", 8, FALSE),

(121, 1, 'friday', "7:00 PM", 2, FALSE),
(122, 1, 'friday', "8:00 PM", 2, FALSE),
(123, 1, 'friday', "9:00 PM", 2, FALSE),

(124, 2, 'friday', "7:00 PM", 2, FALSE),
(125, 2, 'friday', "8:00 PM", 2, FALSE),
(126, 2, 'friday', "9:00 PM", 2, FALSE),

(127, 3, 'friday', "7:00 PM", 2, FALSE),
(128, 3, 'friday', "8:00 PM", 2, FALSE),
(129, 3, 'friday', "9:00 PM", 2, FALSE),

(130, 4, 'friday', "7:00 PM", 2, FALSE),
(131, 4, 'friday', "8:00 PM", 2, FALSE),
(132, 4, 'friday', "9:00 PM", 2, FALSE),

(133, 5, 'friday', "7:00 PM", 4, FALSE),
(134, 5, 'friday', "8:00 PM", 4, FALSE),
(135, 5, 'friday', "9:00 PM", 4, FALSE),

(136, 6, 'friday', "7:00 PM", 4, FALSE),
(137, 6, 'friday', "8:00 PM", 4, FALSE),
(138, 6, 'friday', "9:00 PM", 4, FALSE),

(139, 7, 'friday', "7:00 PM", 6, FALSE),
(140, 7, 'friday', "8:00 PM", 6, FALSE),
(141, 7, 'friday', "9:00 PM", 6, FALSE),

(142, 8, 'friday', "7:00 PM", 6, FALSE),
(143, 8, 'friday', "8:00 PM", 6, FALSE),
(144, 8, 'friday', "9:00 PM", 6, FALSE),

(145, 9, 'friday', "7:00 PM", 8, FALSE),
(146, 9, 'friday', "8:00 PM", 8, FALSE),
(147, 9, 'friday', "9:00 PM", 8, FALSE),

(148, 10, 'friday', "7:00 PM", 8, FALSE),
(149, 10, 'friday', "8:00 PM", 8, FALSE),
(150, 10, 'friday', "9:00 PM", 8, FALSE),

(151, 1, 'saturday', "7:00 PM", 2, FALSE),
(152, 1, 'saturday', "8:00 PM", 2, FALSE),
(153, 1, 'saturday', "9:00 PM", 2, FALSE),

(154, 2, 'saturday', "7:00 PM", 2, FALSE),
(155, 2, 'saturday', "8:00 PM", 2, FALSE),
(156, 2, 'saturday', "9:00 PM", 2, FALSE),

(157, 3, 'saturday', "7:00 PM", 2, FALSE),
(158, 3, 'saturday', "8:00 PM", 2, FALSE),
(159, 3, 'saturday', "9:00 PM", 2, FALSE),

(160, 4, 'saturday', "7:00 PM", 2, FALSE),
(161, 4, 'saturday', "8:00 PM", 2, FALSE),
(162, 4, 'saturday', "9:00 PM", 2, FALSE),

(163, 5, 'saturday', "7:00 PM", 4, FALSE),
(164, 5, 'saturday', "8:00 PM", 4, FALSE),
(165, 5, 'saturday', "9:00 PM", 4, FALSE),

(166, 6, 'saturday', "7:00 PM", 4, FALSE),
(167, 6, 'saturday', "8:00 PM", 4, FALSE),
(168, 6, 'saturday', "9:00 PM", 4, FALSE),

(169, 7, 'saturday', "7:00 PM", 6, FALSE),
(170, 7, 'saturday', "8:00 PM", 6, FALSE),
(171, 7, 'saturday', "9:00 PM", 6, FALSE),

(172, 8, 'saturday', "7:00 PM", 6, FALSE),
(173, 8, 'saturday', "8:00 PM", 6, FALSE),
(174, 8, 'saturday', "9:00 PM", 6, FALSE),

(175, 9, 'saturday', "7:00 PM", 8, FALSE),
(176, 9, 'saturday', "8:00 PM", 8, FALSE),
(177, 9, 'saturday', "9:00 PM", 8, FALSE),

(178, 10, 'saturday', "7:00 PM", 8, FALSE),
(179, 10, 'saturday', "8:00 PM", 8, FALSE),
(180, 10, 'saturday', "9:00 PM", 8, FALSE),

(181, 1, 'sunday', "7:00 PM", 2, FALSE),
(182, 1, 'sunday', "8:00 PM", 2, FALSE),
(183, 1, 'sunday', "9:00 PM", 2, FALSE),

(184, 2, 'sunday', "7:00 PM", 2, FALSE),
(185, 2, 'sunday', "8:00 PM", 2, FALSE),
(186, 2, 'sunday', "9:00 PM", 2, FALSE),

(187, 3, 'sunday', "7:00 PM", 2, FALSE),
(188, 3, 'sunday', "8:00 PM", 2, FALSE),
(189, 3, 'sunday', "9:00 PM", 2, FALSE),

(190, 4, 'sunday', "7:00 PM", 2, FALSE),
(191, 4, 'sunday', "8:00 PM", 2, FALSE),
(192, 4, 'sunday', "9:00 PM", 2, FALSE),

(193, 5, 'sunday', "7:00 PM", 4, FALSE),
(194, 5, 'sunday', "8:00 PM", 4, FALSE),
(195, 5, 'sunday', "9:00 PM", 4, FALSE),

(196, 6, 'sunday', "7:00 PM", 4, FALSE),
(197, 6, 'sunday', "8:00 PM", 4, FALSE),
(198, 6, 'sunday', "9:00 PM", 4, FALSE),

(199, 7, 'sunday', "7:00 PM", 6, FALSE),
(200, 7, 'sunday', "8:00 PM", 6, FALSE),
(201, 7, 'sunday', "9:00 PM", 6, FALSE),

(202, 8, 'sunday', "7:00 PM", 6, FALSE),
(203, 8, 'sunday', "8:00 PM", 6, FALSE),
(204, 8, 'sunday', "9:00 PM", 6, FALSE),

(205, 9, 'sunday', "7:00 PM", 8, FALSE),
(206, 9, 'sunday', "8:00 PM", 8, FALSE),
(207, 9, 'sunday', "9:00 PM", 8, FALSE),

(208, 10, 'sunday', "7:00 PM", 8, FALSE),
(209, 10, 'sunday', "8:00 PM", 8, FALSE),
(210, 10, 'sunday', "9:00 PM", 8, FALSE);


