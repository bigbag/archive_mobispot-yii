DROP TABLE IF EXISTS `user_soc`;
CREATE TABLE IF NOT EXISTS `user_soc`(
	id serial not null,
	type bigint unsigned not null,
	user_id bigint null,
	soc_id varchar(256) null,
	user_token varchar(1024) null,
	token_expires bigint null,
	data varchar(2048) null,
	is_tech boolean null
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `wallet`;
CREATE TABLE IF NOT EXISTS `wallet`(
	id serial not null,
	id_user bigint unsigned not null,
	balance integer
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history`(
	id serial not null,
	id_wallet bigint unsigned not null,
	oper_date datetime not null,
	oper_type int not null,
	summ integer not null,
	description varchar(256) null,
	status int not null,
	foreign key (id_wallet) references wallet (id)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `user_soc`;
CREATE TABLE IF NOT EXISTS `user_soc`(
	id bigint unsigned not null AUTO_INCREMENT,
	type bigint unsigned not null, 
	user_id bigint unsigned null,
	data text null,
	PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `soc_token`;
CREATE TABLE IF NOT EXISTS `soc_token`(
	id bigint unsigned not null AUTO_INCREMENT,
	type bigint unsigned not null, 
	user_id bigint unsigned null,
	soc_id varchar(512) null,
	user_token varchar(512) null, 
	token_secret varchar(512) null, 
	token_expires bigint unsigned null, 
	is_tech boolean null,
	PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;