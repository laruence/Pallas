CREATE TABLE recruit_cmt
( 
	cmt_id int(255) NOT null auto_increment primary key,
	cmt_newsid int not null,
	cmt_name char(50) NOT null,
	cmt_sex int,
	cmt_mark int,
	cmt_qq int,
	cmt_email char(50),
	cmt_msn  char(50),
	cmt_homepage char(100),
	cmt_date datetime,
	cmt_ip   char(50) default '0',
	cmt_content text
);

create table recruit_news
(
	news_id int(255) not null auto_increment primary key,
	news_cat int not null,
	news_spec int default'0' ,
	news_title char(250) not null,
	news_date datetime not null,
	news_click int(255) not null default '0',
	news_author char(50) default'ØýÃû',
	news_typein char(30) default'null',
	news_from  char(255),
	news_addr  char(255),
	news_ip   char(50) default '0',
	news_text longtext not null,
	news_abstract text not null,
	news_keywords char(100) default'null',
	news_cmt int default'0',
	news_picnews int default '0',
	news_pictrues char(255) default'null',
	news_picurl char(255)  default'null',
	news_del int default '0',
	news_placard int default'0',
	news_type int default'0',
	news_type1 char(20) default 'null',
	news_type2 char(20) default 'null'
);

CREATE TABLE recruit_vote(
	v_id int(100) not null auto_increment primary key,
	v_title char(100),
	v_content char(100),
	v_voted int(255),
	v_fromtime datetime not null,
	v_totime  datetime not null,
	v_author char(50),
	v_type   int not null
);

CREATE TABLE recruit_cat
(
	cat_id int(100) not null,
	cat_title char(100) not null,
	cat_content char(200),
	cat_link int default '0',
	cat_url char(100) default 'null',
	cat_parent int default '0',
	cat_order int auto_increment not null primary key,
	cat_name  char(100) not null,
	cat_attr char(255) default '',
	cat_static int default '1'
);


CREATE TABLE recruit_adminers
(
	ad_id int(100) not null auto_increment primary key,
	ad_name char(100) not null,
	ad_pswd char(200),
	ad_email char(100),
	ad_lastip char(50) default '0',
	ad_lasttime datetime not null,
	ad_lock int default'0',
	ad_grad int default'0',
	ad_scrt char(50) not null,
	ad_logintimes int default'0',
	ad_nowip char(50) default'0.0.0.0',
	ad_nowtime datetime not null
);



CREATE TABLE recruit_gbook
( gb_id int(255) NOT null auto_increment primary key,
	gb_name char(50) NOT null,
	gb_sex int,
	gb_qq int,
	gb_email char(50),
	gb_title  char(100) not null,
	gb_msn  char(50),
	gb_add  char(100),
	gb_homepage char(100),
	gb_date datetime,
	gb_ip   char(50) default '0',
	gb_tel  char(20),
	gb_pass int default'0',
	gb_reply int(255) default'0',
	gb_ans  int default'0',
	gb_face char(10),
	gb_content text 
);

CREATE TABLE recruit_members
(
	mb_id int(255) NOT null auto_increment primary key,
	mb_password char(50) NOT null,
	mb_name char(50) NOT null,
	mb_gender tinyint(1) default 0,
	mb_qq     int,
	mb_email  char(50),
	mb_msn    char(50),
	mb_birth  date not null,
	mb_scrt char(50) not null,
	mb_pass tinyint(1) default 0,
	mb_redate datetime  default 0,
	mb_grade  int  default 0,
	mb_lock   tinyint(1) default 0,
	mb_question char(50) ,
	mb_answer  char(50) ,
	mb_lastip char(50) default '0.0.0.0',
	mb_mark   int default 0,
	mb_lasttime datetime not null,
	mb_logons   int    default 0
);

