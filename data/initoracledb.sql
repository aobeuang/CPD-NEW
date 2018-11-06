Drop table acl_categories;
Drop table acl_actions;
Drop table acl;
Drop table auth_sessions;
Drop table ci_sessions;
Drop table denied_access;
Drop table ips_on_hold;
Drop table login_errors;
Drop table username_or_email_on_hold;
Drop table users;

CREATE TABLE "acl_categories" (
  "category_id" INTEGER  NOT NULL,
  "category_code" VARCHAR2(100) NOT NULL,
  "category_desc" VARCHAR2(100) NOT NULL,
  PRIMARY KEY ("category_id"),
  CONSTRAINT uc_category_code UNIQUE ("category_code"),
  CONSTRAINT uc_category_desc UNIQUE ("category_desc")
);
CREATE SEQUENCE acl_categories_sequence;


CREATE TABLE "acl_actions" (
  "action_id" INTEGER  NOT NULL,
  "action_code" VARCHAR2(100) NOT NULL,
  "action_desc" VARCHAR2(100) NOT NULL,
  "category_id" INTEGER NOT NULL,
  PRIMARY KEY ("action_id"),
  CONSTRAINT acl_actions_ibfk_1 FOREIGN KEY ("category_id") REFERENCES "acl_categories" ("category_id") ON DELETE CASCADE
);
CREATE SEQUENCE acl_actions_sequence;




CREATE TABLE "acl" (
  "ai" INTEGER NOT NULL,
  "action_id" INTEGER NOT NULL,
  "user_id" INTEGER DEFAULT NULL,
  PRIMARY KEY ("ai"),
  CONSTRAINT acl_ibfk_1 FOREIGN KEY ("action_id") REFERENCES "acl_actions" ("action_id") ON DELETE CASCADE
);
CREATE SEQUENCE acl_sequence;



CREATE TABLE "auth_sessions" (
  "id" VARCHAR2(40) NOT NULL,
  "user_id" INTEGER  NOT NULL,
  "login_time" TIMESTAMP DEFAULT SYSDATE,
  "modified_at" TIMESTAMP DEFAULT SYSDATE,
  "ip_address" VARCHAR2(45) NOT NULL,
  "user_agent" VARCHAR2(60) DEFAULT NULL,
  PRIMARY KEY ("id")
);

CREATE OR REPLACE TRIGGER auth_sessions_on_insert
  BEFORE INSERT OR UPDATE
   ON "auth_sessions"
   REFERENCING OLD AS old_row NEW AS new_row
   FOR EACH ROW
BEGIN
  SELECT sysdate
  INTO :new_row."modified_at"
  FROM DUAL;  
END;


CREATE TABLE "ci_sessions" (
  "id" VARCHAR2(40) NOT NULL,
  "ip_address" VARCHAR2(45) NOT NULL,
  "timestamp" INTEGER NOT NULL,
  "data" VARCHAR2(4000) NOT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "denied_access" (
  "ai" INTEGER NOT NULL,
  "ip_address" VARCHAR2(45) NOT NULL,
  "time" TIMESTAMP NOT NULL,
  "reason_code" SMALLINT DEFAULT 0,
  PRIMARY KEY ("ai")
);
CREATE SEQUENCE denied_access_sequence;


CREATE TABLE "ips_on_hold" (
  "ai" INTEGER  NOT NULL,
  "ip_address" VARCHAR2(45) NOT NULL,
  "time" TIMESTAMP DEFAULT SYSDATE,
  PRIMARY KEY ("ai")
);
CREATE SEQUENCE ips_on_hold_sequence;


CREATE TABLE "login_errors" (
  "ai" INTEGER NOT NULL,
  "username_or_email" VARCHAR2(255),
  "ip_address" VARCHAR2(45) NOT NULL,
  "time" TIMESTAMP DEFAULT SYSDATE,
  PRIMARY KEY ("ai")
);
CREATE SEQUENCE login_errors_sequence;


CREATE TABLE "username_or_email_on_hold" (
  "ai" INTEGER NOT NULL,
  "username_or_email" VARCHAR2(255) NOT NULL,
  "time" TIMESTAMP DEFAULT SYSDATE,
  PRIMARY KEY ("ai")
);
CREATE SEQUENCE useremail_onhold_sequence;


CREATE TABLE "groups"(
    "group_id" INTEGER NOT NULL,
    "name" VARCHAR2(255) NOT NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE,
    "created_by"  INTEGER DEFAULT NULL,
    "modified_by"  INTEGER DEFAULT NULL,    
    "deleted" SMALLINT DEFAULT 0,
	PRIMARY KEY ("group_id")
);
CREATE SEQUENCE groups_sequence;


CREATE TABLE "users" (
  "user_id" INTEGER NOT NULL,
  "username" VARCHAR2(12) DEFAULT NULL,
  "name" VARCHAR2(255) NOT NULL,
  "auth_level" NUMBER(3)  NOT NULL,
  "banned" SMALLINT DEFAULT 0,
  "passwd" VARCHAR2(60) NOT NULL,
  "passwd_recovery_code" VARCHAR2(60) DEFAULT NULL,
  "passwd_recovery_date" TIMESTAMP DEFAULT NULL,
  "passwd_modified_at" TIMESTAMP DEFAULT NULL,
  "last_login" DATE DEFAULT NULL,
  "created_at" TIMESTAMP DEFAULT SYSDATE,
  "modified_at" TIMESTAMP DEFAULT SYSDATE,
   "created_by"  INTEGER DEFAULT NULL,
   "modified_by"  INTEGER DEFAULT NULL,      
  "email" VARCHAR2(64) DEFAULT NULL,
  "province" VARCHAR2(128) DEFAULT NULL,
  PRIMARY KEY ("user_id"),
  CONSTRAINT uc_username UNIQUE ("username"),  
  CONSTRAINT uc_email UNIQUE ("email")
);
CREATE SEQUENCE users_sequence;


CREATE TABLE "properties" (
  "properties_id" INTEGER NOT NULL,
  "name" VARCHAR2(255) NOT NULL,
  "propvalue" VARCHAR2(255) NOT NULL,
  "created_at" TIMESTAMP DEFAULT SYSDATE,
  "modified_at" TIMESTAMP DEFAULT SYSDATE,
   "created_by"  INTEGER DEFAULT NULL,
   "modified_by"  INTEGER DEFAULT NULL,     
  PRIMARY KEY ("properties_id"),
  CONSTRAINT uc_property_name UNIQUE ("name")
);
CREATE SEQUENCE properties_sequence;


CREATE TABLE "user_group"(
    "user_group_id" INTEGER DEFAULT NULL,
    "user_id" INTEGER NOT NULL,
    "group_id" INTEGER NOT NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE,
    "created_by"  INTEGER DEFAULT NULL,
    "modified_by"  INTEGER DEFAULT NULL,  
    "priority" INTEGER DEFAULT NULL,     
    "deleted" SMALLINT DEFAULT 0,  
    PRIMARY KEY ("user_group_id"),
);
CREATE SEQUENCE user_group_sequence;


CREATE TABLE "announcements"(
    "announcement_id" INTEGER NOT NULL,
    "message" VARCHAR2(255) NOT NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE,
    "created_by"  INTEGER DEFAULT NULL,
    "modified_by"  INTEGER DEFAULT NULL,       
    PRIMARY KEY ("announcement_id")
);
CREATE SEQUENCE announcements_sequence;


CREATE TABLE "logs"(
    "log_id" INTEGER NOT NULL,
    "name" VARCHAR2(128) DEFAULT NULL,
    "status" VARCHAR2(16) DEFAULT NULL,
    "description" VARCHAR2(4000) DEFAULT NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,  
    PRIMARY KEY ("log_id")
);
CREATE SEQUENCE logs_sequence;

CREATE TABLE "sql_commands"(
    "command_id" INTEGER NOT NULL,
    "group_name" VARCHAR2(64) DEFAULT NULL,
    "name" VARCHAR2(200) DEFAULT NULL,
    "description" VARCHAR2(512) DEFAULT NULL,
    "sql" VARCHAR2(2000) NOT NULL,
    "command_type" VARCHAR2(16) DEFAULT NULL,
    "command_order" INTEGER DEFAULT NULL,
    "last_fail" TIMESTAMP DEFAULT NULL,
    "last_success" TIMESTAMP DEFAULT NULL,
    "last_execution" TIMESTAMP DEFAULT NULL,  
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NOT NULL,
    "modified_by" INTEGER NOT NULL,    
    "disabled" SMALLINT DEFAULT 0, 
    
    PRIMARY KEY ("command_id")
);
CREATE SEQUENCE sql_commands_sequence;


CREATE TABLE "SURVEY_2018"(
    "citizen_id" VARCHAR2(64) NOT NULL,
    "coop_member_id" INTEGER NULL,  
    "citizen_firstname" VARCHAR2(256) NOT NULL,
    "citizen_lastname" VARCHAR2(256) NOT NULL,    
    "citizen_birthdate" DATE NULL,
    "citizen_address1" VARCHAR2(256)  NULL,    
    "citizen_address2" VARCHAR2(256)  NULL,  
    "citizen_city" VARCHAR2(256)  NULL,  
    "citizen_zipcode" VARCHAR2(5)  NULL, 
    "citizen_already_in_f1" NUMBER(1) DEFAULT 0,  
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NOT NULL,
    "modified_by" INTEGER NOT NULL,
    "COOP_ID" INTEGER NULL,  
);


CREATE TABLE "SURVEY_2017_1"(
    "citizen_id" VARCHAR2(64) NOT NULL,
    "coop_member_id" INTEGER NOT NULL,  
    "citizen_firstname" VARCHAR2(256) NOT NULL,
    "citizen_lastname" VARCHAR2(256) NOT NULL,    
    "citizen_birthdate" DATE NULL,
    "citizen_address1" VARCHAR2(256) NULL,    
    "citizen_address2" VARCHAR2(256) NULL,  
    "citizen_city" VARCHAR2(256)  NULL,  
    "citizen_zipcode" VARCHAR2(5)  NULL, 
    "citizen_already_in_f1" NUMBER(1) DEFAULT 0,       
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NOT NULL,
    "modified_by" INTEGER NOT NULL,     
    PRIMARY KEY ("citizen_id")
);


CREATE TABLE "DISTRICT"(
    "AMPHUR_ID" INTEGER NOT NULL,
    "AMPHUR_CODE" VARCHAR2(4) NOT NULL,  
    "AMPHUR_NAME" VARCHAR2(256) NOT NULL,
    "BK_FLG" VARCHAR2(256)  NULL,    
    "PROV_PROVINCE_ID" INTEGER NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER  NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("AMPHUR_ID")
);

CREATE TABLE "PROVINCE"(
    "PROVINCE_ID" INTEGER NOT NULL,
    "PROVINCE_CODE" VARCHAR2(4) NOT NULL,  
    "PROVINCE_NAME" VARCHAR2(256) NOT NULL,
    "PROVINCE_ENAME" VARCHAR2(256) NOT NULL,    
    "MAP_INDX" INTEGER NULL,
    "REGION_REGION_ID" INTEGER NULL,
    "DPIS_PROV_CODE" INTEGER NULL,
    "INSPECTING_REGION" INTEGER NULL,
    "AREA_CODE" INTEGER NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER  NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("PROVINCE_ID")
);

CREATE TABLE "TAMBON"(
    "TAMBON_ID" INTEGER NOT NULL,
    "TAMBON_CODE" VARCHAR2(4) NOT NULL,  
    "TAMBON_NAME" VARCHAR2(256) NOT NULL,  
    "CANCEL_FLG" INTEGER NULL,
    "AMPHUR_AMPHUR_ID" INTEGER NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("TAMBON_ID")
);

CREATE TABLE "TYPE_ANIMAL"(
	"ID_NO" INTEGER NOT NULL,
    "ID_AN" VARCHAR2(6) NOT NULL,
    "AN_TYPE" VARCHAR2(128) NOT NULL,  
    "AN_NAME" VARCHAR2(128) NOT NULL,  
    "SHOW_F" VARCHAR2(1) NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("ID_NO")
);

CREATE TABLE "TYPE_INFRA_USE"(
	"ID_NO" INTEGER NOT NULL,
    "ID_TYPE" VARCHAR2(6) NOT NULL,
    "INFRA_TYPE" VARCHAR2(128) NOT NULL,  
    "TYPEDET" VARCHAR2(128) NOT NULL,  
    "SHOW_F" VARCHAR2(1) NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("ID_NO")
);

CREATE TABLE "TYPE_LOAN"(
	"ID_NO" INTEGER NOT NULL,
    "ID_LONE" VARCHAR2(6) NOT NULL,
    "LOAN_NAME" VARCHAR2(128) NOT NULL,  
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("ID_NO")
);


CREATE TABLE "TYPE_PLANT"(
	"ID_NO" INTEGER NOT NULL,
    "ID_PLANT" VARCHAR2(6) NOT NULL,
    "PLANT_TYPE" VARCHAR2(128) NOT NULL, 
    "PLANT_NAME" VARCHAR2(128) NOT NULL, 
    "SHOW_F" VARCHAR2(1) NULL,
    "created_at" TIMESTAMP DEFAULT SYSDATE,
    "modified_at" TIMESTAMP DEFAULT SYSDATE, 
    "created_by" INTEGER NULL,
    "modified_by" INTEGER  NULL,      
    PRIMARY KEY ("ID_NO")
);


CREATE TABLE "MAHADTHAI"(
    "citizen_id" VARCHAR2(14) NOT NULL,
    "citizen_prefix" VARCHAR2(64)  NULL,
    "citizen_firstname" VARCHAR2(128) NOT NULL,
    "citizen_lastname" VARCHAR2(128) NOT NULL,    
    "citizen_birthdate" DATE NULL,
    "citizen_address_no" VARCHAR2(64)  NULL,    
    "citizen_address_moo" VARCHAR2(64)  NULL, 
    "citizen_address_trog" VARCHAR2(64)  NULL,  
    "citizen_address_soi" VARCHAR2(64)  NULL, 
    "citizen_address_street" VARCHAR2(64)  NULL,  
    "citizen_tambon" VARCHAR2(64)  NULL, 
    "citizen_district" VARCHAR2(64)  NULL,           
    "citizen_province" VARCHAR2(64)  NULL,  
    "citizen_status" VARCHAR2(2)  NULL,
    "citizen_flag" VARCHAR2(2)  NULL,
    PRIMARY KEY ("citizen_id")
);


CREATE TABLE "MAHADTHAIIMP"(
    "citizen_1" VARCHAR2(128)  NULL,
    "citizen_2" VARCHAR2(128)  NULL,
    "citizen_3" VARCHAR2(128)  NULL,
    "citizen_4" VARCHAR2(128)  NULL,
    "citizen_5" VARCHAR2(128)  NULL,
    "citizen_6" VARCHAR2(128)  NULL,
    "citizen_7" VARCHAR2(128)  NULL,
    "citizen_8" VARCHAR2(128)  NULL,
    "citizen_9" VARCHAR2(128)  NULL,
    "citizen_10" VARCHAR2(128)  NULL,
    "citizen_11" VARCHAR2(128)  NULL,
    "citizen_12" VARCHAR2(128)  NULL,
    "citizen_13" VARCHAR2(128)  NULL,
    "citizen_14" VARCHAR2(128)  NULL,
    "citizen_15" VARCHAR2(128)  NULL,
    "citizen_16" VARCHAR2(128)  NULL,
    "citizen_17" VARCHAR2(128)  NULL,
    "citizen_18" VARCHAR2(128)  NULL,
    "citizen_19" VARCHAR2(128)  NULL,
    "citizen_20" VARCHAR2(128)  NULL,
    "citizen_21" VARCHAR2(128)  NULL,
    "citizen_22" VARCHAR2(128)  NULL,
    "citizen_23" VARCHAR2(128)  NULL,    
    "citizen_24" VARCHAR2(128)  NULL,
    "citizen_25" VARCHAR2(128)  NULL,    
    "citizen_26" VARCHAR2(128)  NULL,
    "citizen_27" VARCHAR2(128)  NULL,    
    "citizen_28" VARCHAR2(128)  NULL
);

LOAD DATA
INFILE 'xx.txt'
  INTO TABLE MAHADTHAIIMP
  FIELDS TERMINATED BY '|'
  (
"citizen_1",
"citizen_2",
"citizen_3",
"citizen_4",
"citizen_5",
"citizen_6",
"citizen_7",
"citizen_8",
"citizen_9",
"citizen_10",
"citizen_11",
"citizen_12",
"citizen_13",
"citizen_14",
"citizen_15",
"citizen_16",
"citizen_17",
"citizen_18",
"citizen_19",
"citizen_20",
"citizen_21",
"citizen_22",
"citizen_23",
"citizen_24",
"citizen_25",
"citizen_26",
"citizen_27",
"citizen_28"
  );

  
  
CREATE TABLE "COOP_INFO"(
    "COOP_ID" INTEGER ,
    "COOP_NAME_TH" VARCHAR2(128)  NULL,
    "LOC_ADDR" VARCHAR2(128)  NULL,
    "TAMBON_ID" INTEGER  NULL,
    "TAMBON_NAME" VARCHAR2(128)  NULL,
    "AMPHUR_ID" INTEGER  NULL,
    "AMPHUR_NAME" VARCHAR2(128)  NULL,
    "PROVINCE_ID" INTEGER  NULL,
    "PROVINCE_NAME" VARCHAR2(128)  NULL,
    "TEL_NO" VARCHAR2(40)  NULL,
    "ZIP_CODE" VARCHAR2(8)  NULL,
    "FAX_NO" VARCHAR2(32)  NULL,
    "REGISTRY_DATE" DATE  NULL,
    "REGISTRY_NO" VARCHAR2(20)  NULL,
    "COOP_TYPE" VARCHAR2(64)  NULL,
    "COOP_TYPE_NAME" VARCHAR2(64)  NULL,
    "INIT_MEMBER" INTEGER  NULL,
    "ACCT_MONTH_END" VARCHAR2(2)  NULL,
    "INIT_VALUE" INTEGER  NULL,
    "COOP_STATUS" SMALLINT  NULL,
    "COOP_STATUS_DATE" DATE  NULL,
    "STATUS_NAME" VARCHAR2(128)  NULL,
    "CHARTER_DATE" DATE  NULL,    
    "CHARTER_NO" VARCHAR2(32)  NULL,
    "COOP_STRUC_GROUP_ID" INTEGER  NULL,    
    "COOP_SCOPE" VARCHAR2(2000)  NULL,
    "GROUP_NAME_TH" VARCHAR2(128)  NULL,    
    "ORG_NAME" VARCHAR2(128)  NULL,
    "ORG_ORG_ID" INTEGER  NULL,    
    "CAD_ID" INTEGER  NULL,    
    "ORG_ID" INTEGER  NULL,    
    "REGISTRY_NO_2" INTEGER NULL
);



LOAD DATA
INFILE 'coop.txt'
  INTO TABLE COOP_INFO 
  FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
  (
    COOP_ID,
	COOP_NAME_TH,
	LOC_ADDR,
	TAMBON_ID,
	TAMBON_NAME,
	AMPHUR_ID,
	AMPHUR_NAME,
	PROVINCE_ID,
	PROVINCE_NAME,
	TEL_NO,
	ZIP_CODE,
	FAX_NO,
	REGISTRY_DATE DATE "DD/MM/YYYY",
	REGISTRY_NO,
	COOP_TYPE,
	COOP_TYPE_NAME,
	INIT_MEMBER,
	ACCT_MONTH_END,
	INIT_VALUE,
	COOP_STATUS,
	COOP_STATUS_DATE DATE "DD/MM/YYYY",
	STATUS_NAME,
	CHARTER_DATE DATE "DD/MM/YYYY",
	CHARTER_NO,
	COOP_STRUC_GROUP_ID,
	COOP_SCOPE,
	GROUP_NAME_TH,
	ORG_NAME,
	ORG_ORG_ID,
	CAD_ID,
	ORG_ID,
	REGISTRY_NO_2
);



CREATE TABLE "TA_MEMBER"(
    "D_ID" INTEGER ,
    "D_YEAR" VARCHAR2(100)  NULL,
    "D_PIN" VARCHAR2(128)  NULL,
    "D_MDATE" VARCHAR2(100) NULL,
    "D_NSTOCK" VARCHAR2(64)  NULL,
    "D_VSTOCK" VARCHAR2(64)  NULL,
    "D_TYPE" VARCHAR2(100)  NULL,
    "D_COOP" INTEGER  NULL,
    "D_GROUP" VARCHAR2(100)  NULL,
    "D_PNAME" VARCHAR2(255)  NULL,
    "D_SNAME" VARCHAR2(255)  NULL,
    "D_PREFIX" VARCHAR2(255)  NULL,
    "D_NATION" VARCHAR2(100)
);

LOAD DATA
INFILE 'tamember.txt'
  INTO TABLE TA_MEMBER 
  FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
  (
    "D_ID",
    "D_YEAR",
    "D_PIN",
    "D_MDATE" DATE "DD/MM/YYYY"
    "D_NSTOCK",
    "D_VSTOCK",
    "D_TYPE",
    "D_COOP",
    "D_GROUP",
    "D_PNAME",
    "D_SNAME",
    "D_PREFIX",
    "D_NATION"
);


CREATE TABLE "khet"(
	Col001 VARCHAR2(256)  NULL,
	Col002 VARCHAR2(256)  NULL,
	Col003 VARCHAR2(256)  NULL,
	Col004 VARCHAR2(256)  NULL,
	Col005 VARCHAR2(256)  NULL,
	Col006 VARCHAR2(256)  NULL,
	Col007 VARCHAR2(256)  NULL,
	Col008 VARCHAR2(256)  NULL,
	Col009 VARCHAR2(256)  NULL,
	Col010 VARCHAR2(256)  NULL,
	Col011 VARCHAR2(256)  NULL,
	Col012 VARCHAR2(256)  NULL,
	Col013 VARCHAR2(256)  NULL,
	Col014 VARCHAR2(256)  NULL,
	Col015 VARCHAR2(256)  NULL,
	Col016 VARCHAR2(256)  NULL
);

LOAD DATA
INFILE 'khet.txt'
  INTO TABLE KHET 
  FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
  (
	Col001,
	Col002,
	Col003,
	Col004,
	Col005,
	Col006,
	Col007,
	Col008,
	Col009,
	Col010,
	Col011,
	Col012,
	Col013,
	Col014,
	Col015,
	Col016
);



CREATE TABLE "khet_inspect"(
	"seq" INTEGER NOT NULL,
	"khet_id" INTEGER NULL,
	"khet_desc" VARCHAR2(256)  NULL,
	"khet_id_sort" INTEGER  NULL,
	"khet_group" INTEGER  NULL,
	"province_id" INTEGER NULL,
	"province_name" VARCHAR2(256)  NULL,
	"province_name_sort" VARCHAR2(256)  NULL,
	"phak_id" INTEGER NULL,
	"phak" VARCHAR2(256)  NULL,
	"org_org_id" VARCHAR2(10)  NULL,
	"org_name" VARCHAR2(256)  NULL,
	"in_cityhall" VARCHAR2(8)  NULL,
	"member_all" INTEGER NULL,
	"member_key" INTEGER NULL,
	"input_date" DATE NULL
)

LOAD DATA
INFILE 'khet_inspect.txt'
  INTO TABLE khet_inspect 
  FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
  (
	"seq",
	"khet_id",
	"khet_desc",
	"khet_id_sort",
	"khet_group",
	"province_id",
	"province_name",
	"province_name_sort",
	"phak_id",
	"phak",
	"org_org_id",
	"org_name",
	"in_cityhall",
	"member_all",
	"member_key",
	"input_date"  DATE "DD/MM/YYYY"
);



CREATE TABLE "FARMERONE"(
    "citizen_id" INTEGER NULL,
    "coop_member_id" INTEGER NOT NULL,  
    "citizen_firstname" VARCHAR2(256) NOT NULL,
    "citizen_lastname" VARCHAR2(256) NOT NULL,    
    "citizen_birthdate" DATE NULL,
    "citizen_address1" VARCHAR2(256)  NULL,    
    "citizen_address2" VARCHAR2(256)  NULL,  
    "citizen_city" VARCHAR2(256)  NULL,  
    "citizen_zipcode" VARCHAR2(5)  NULL
);


INSERT INTO "users" ("user_id", "username", "name", "auth_level", "passwd", "email") VALUES (1,'admin','admin','9','$2y$11$psq44shDhvaqTzDUWLgUYegMJGin04d2c7bgQl2l9wCr9Wau8XtqS','premw@hotmail.com')