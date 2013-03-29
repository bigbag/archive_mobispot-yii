DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
    id serial not null,
	name varchar(128) not null,
    code varchar(128) not null,
	photo varchar(2048) null,
	description varchar(2048) null,
	color varchar(2048) null,
	size varchar(2048) not null
)  DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer`(
	id serial not null,
	first_name varchar(128) null,
	last_name varchar(128) null,
	email varchar(128) not null,
	target_first_name varchar(128) null,
	target_last_name varchar(128) null,
	address varchar(1024) not null,
	city varchar(128) null,
	zip varchar(16) null,
	phone varchar(32) null,
	country varchar(128) null	
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `store_order`;
CREATE TABLE IF NOT EXISTS `store_order`(
	id serial not null,
	id_customer bigint unsigned not null,
	delivery varchar(1024) null,
	payment varchar(1024) null,
	status integer not null,
	foreign key (id_customer) references customer (id)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `order_list`;
CREATE TABLE IF NOT EXISTS `order_list`(
	id serial not null,
	id_order integer not null,
	id_product bigint unsigned not null,
	quantity integer not null,
	color varchar(1024) not null,
	size_name varchar(1024) not null,
	price integer not null,
	foreign key (id_product) references product (id)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `delivery`;
CREATE TABLE IF NOT EXISTS `delivery`(
	id serial not null,
	name varchar(128) not null,
	period varchar(256) null,
	price int not null
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment`(
	id serial not null,
	name varchar(128) not null
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

insert into delivery (name, period, price) values('DHL', '2 business days (no tracking)', 20);
insert into delivery (name, period, price) values('Air mail', '8-12 business days (no tracking)', 12);
insert into delivery (name, period, price) values('EMS', '20 business days (no tracking)', 5);

insert into payment (name) values('Paypal');
insert into payment (name) values('Credit Card');
insert into payment (name) values('Yandex Money');





