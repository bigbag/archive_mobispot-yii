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
