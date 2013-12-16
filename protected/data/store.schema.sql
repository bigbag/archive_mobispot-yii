DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
    id serial not null,
    name varchar(128) not null,
    code varchar(128) not null,
    photo varchar(2048) null,
    description varchar(2048) null,
    color varchar(2048) null,
    size varchar(2048) not null,
    surface varchar(2048) null
    
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
    delivery bigint unsigned null,
    delivery_data text null,
    payment bigint unsigned null,
    payment_data text null,
    status integer not null,
    promo_id bigint unsigned null,
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
    price float not null,
    surface varchar(1024) null
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
    id bigint unsigned not null,
    name varchar(128) not null,
    MeanType int null,
    EMoneyType int null,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;


DROP TABLE IF EXISTS `promo_code`;
CREATE TABLE IF NOT EXISTS `promo_code`(
    id bigint unsigned not null,
    code varchar(128) not null,
    products text not null,
    discount int not null,
    expires bigint unsigned not null,
    is_multifold boolean null,
    used boolean null,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;


insert into delivery (name, period, price) values('DHL', '2 business days (no tracking)', 20);
insert into delivery (name, period, price) values('Air mail', '8-12 business days (no tracking)', 12);
insert into delivery (name, period, price) values('EMS', '20 business days (no tracking)', 5);

insert into payment (name, MeanType) values('VISA', 1);
insert into payment (name, MeanType) values('MasterCard', 2);
insert into payment (name, MeanType) values('Diners Club', 3);
insert into payment (name, MeanType) values('JCB', 4);

insert into payment (name, EMoneyType) values('Яндекс.Деньги', 1);
insert into payment (name, EMoneyType) values('RBK Money', 2);
insert into payment (name, EMoneyType) values('MoneyMail', 3);
insert into payment (name, EMoneyType) values('WebCreds', 4);
insert into payment (name, EMoneyType) values('EasyPay', 5);
insert into payment (name, EMoneyType) values('Platezh.ru', 6);
insert into payment (name, EMoneyType) values('Деньги@Mail.Ru', 7);
