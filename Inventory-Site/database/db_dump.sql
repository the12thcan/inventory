PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "migrations" ("id" integer not null primary key autoincrement, "migration" varchar not null, "batch" integer not null);
INSERT INTO migrations VALUES(1,'2014_10_12_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO migrations VALUES(3,'2019_08_19_000000_create_failed_jobs_table',1);
CREATE TABLE IF NOT EXISTS "password_resets" ("email" varchar not null, "token" varchar not null, "created_at" datetime null);
CREATE TABLE IF NOT EXISTS "failed_jobs" ("id" integer not null primary key autoincrement, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime default CURRENT_TIMESTAMP not null);
CREATE TABLE IF NOT EXISTS "users"
(
	id integer not null
		primary key autoincrement,
	name varchar not null,
	email varchar not null,
	email_verified_at datetime,
	password varchar not null,
	remember_token varchar,
	created_at datetime,
	updated_at datetime,
	phone_num varchar(20),
	current_member BOOLEAN,
	position_id int
		constraint fk_position_id
			references Member_Position
);
CREATE TABLE IF NOT EXISTS "Order_Transaction"
(
	member_id INTEGER
		references users,
	item_id INTEGER
		references Item,
	item_quantity_change,
	transaction_date DATETIME,
	comment TEXT,
	id INTEGER not null
		constraint Order_Transaction_pk
			primary key autoincrement
);
INSERT INTO Order_Transaction VALUES(1,1,10,'2019-09-22 18:36:05','Second test transaction',1);
INSERT INTO Order_Transaction VALUES(1,1,-5,'2019-09-22 18:36:26','Third test transaction',2);
INSERT INTO Order_Transaction VALUES(1,1,10,'2019-09-22 18:37:09','Fourth test transaction',3);
CREATE TABLE IF NOT EXISTS "Member_Position"
(
	id INTEGER
		primary key autoincrement,
	position varchar(255),
	privilege INTEGER,
	description text,
	created_at datetime not null,
	updated_at datetime not null,
	email_address varchar(255) not null
);
INSERT INTO Member_Position VALUES(1,'Development Director',0,'Works on grant writing, meeting with people who are interested in large monetary donations, setting up profit shares, going to Aggie Moms Club meetings, Sully donations, and help work towards making sure the 12th Can is financially secure','2019-09-22','2019-09-22','12thcan.development@gmail.com');
INSERT INTO Member_Position VALUES(2,'Public Relations Director',0,'Works on communication and marketing for the 12th Can through various methods such as distributing mass emails, promoting on social media, and designing promotional materials.','2019-09-22','2019-09-22','12thcan.publicrelations@gmail.com');
INSERT INTO Member_Position VALUES(3,'Finance Director',0,'Keeps a ledger, reconciles SOFC and Foundation accounts, SGA allocations, dues, Sully statue money, seeks out donations, and promotes the financial security and future of the 12 Can.','2019-09-22 18:03:40','2019-09-22 18:03:40','12thcan.finance@gmail.com');
INSERT INTO Member_Position VALUES(4,'Donations Director',0,'In charge of coordinating all food donations. Schedules the drop off times and asks patrons to fill out a form to keep basic personal info (email addresses and phone numbers). Also records the quantities of food donations so that the 12th Can can keep a running inventory.','2019-09-22 18:03:40','2019-09-22 18:03:40','12thcan.donation@gmail.com');
INSERT INTO Member_Position VALUES(5,'Facilities Director',1,'In charge of buying food to make sure the pantry is stocked. Also in charge of sorting through all food that comes into the pantry ensure food safety. Also directs other members on how to operate the pantry and restock during pantry openings.','2019-09-22 18:11:09','2019-09-22 18:11:09','12thcan.facilities@gmail.com ');
INSERT INTO Member_Position VALUES(6,'Assistant Director',1,'In charge of all internal affairs of the 12th Can, including, but not limited to, managing and supporting all the executive directors and members as well as maintaining relationships with other on-campus entities.','2019-09-22 18:11:09','2019-09-22 18:11:09','12thcan.ad@gmail.com');
INSERT INTO Member_Position VALUES(7,'Big Boss',3,'Has full admin rights to the website for troubleshooting and development purposes.','2019-09-22 18:19:12','2019-09-22 18:19:12','jgwesterfield@gmail.com');
INSERT INTO Member_Position VALUES(8,'Executive Director',2,'Lord of the 12th Can. A resource for everyone on the team and helps make sure everything done is working towards the goals set for the 12th Can','2019-09-22 23:53:38','2019-09-22 23:53:38','12thcan.director@gmail.com');
INSERT INTO Member_Position VALUES(9,'Membership Director',2,'Manages all communications with student volunteers including running the meetings and scheduling volunteer shifts. Also runs the social aspect of the 12th Can by organizing other nonprofits to come speak to the 12th Can and hosting outside social events for 12th Can members.','2019-09-22 23:55:49','2019-09-22 23:55:49','12thcan.membership@gmail.com');
CREATE TABLE IF NOT EXISTS "Item"
(
	id Integer not null
		primary key autoincrement,
	name varchar(255) not null,
	quantity Integer not null,
	capacity Integer,
	updated_at datetime not null,
	created_at datetime not null,
	removed boolean not null,
	is_food boolean not null,
	refrigerated boolean not null,
	low_threshold int not null
);
INSERT INTO Item VALUES(1,'yeet',0,200,'2019-09-22 18:30:54','2019-09-22 18:30:54',0,1,0,40);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('migrations',3);
INSERT INTO sqlite_sequence VALUES('users',0);
INSERT INTO sqlite_sequence VALUES('Order_Transaction',3);
INSERT INTO sqlite_sequence VALUES('Member_Position',9);
INSERT INTO sqlite_sequence VALUES('Item',1);
CREATE INDEX "password_resets_email_index" on "password_resets" ("email");
CREATE UNIQUE INDEX users_email_unique
	on users (email);
CREATE UNIQUE INDEX Order_Transaction_id_uindex
	on Order_Transaction (id);
CREATE UNIQUE INDEX Member_Position_email_address_uindex
	on Member_Position (email_address);
COMMIT;
