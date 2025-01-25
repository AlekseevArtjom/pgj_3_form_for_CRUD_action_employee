CREATE DATABASE test1
    WITH
    OWNER = test1
    ENCODING = 'UTF8'
    LC_COLLATE = 'Russian_Russia.1251'
    LC_CTYPE = 'Russian_Russia.1251'
    TABLESPACE = test_laravel
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;

GRANT TEMPORARY, CONNECT ON DATABASE test1 TO PUBLIC;
GRANT ALL ON DATABASE test1 TO test1;



CREATE SCHEMA IF NOT EXISTS employee
    AUTHORIZATION test1;
GRANT ALL ON SCHEMA employee TO test1;



CREATE TABLE IF NOT EXISTS employee.main_table
(
    id bigserial,
    family_name character varying(150),
    name character varying(150),
    second_name character varying(150) ,
    birth_date date,
    sex character varying(10),
    CONSTRAINT main_table_pkey PRIMARY KEY (id)
        USING INDEX TABLESPACE test_laravel
)

TABLESPACE test_laravel;

ALTER TABLE IF EXISTS employee.main_table
    OWNER to test1;
	



CREATE TABLE IF NOT EXISTS employee.old_work_places
(
    id bigserial,
    work_start date,
    work_end date,
    company_name character varying(150),
    emp_id bigint,
    CONSTRAINT old_work_places_pkey PRIMARY KEY (id)
        USING INDEX TABLESPACE test_laravel,
    CONSTRAINT fk_old_work_plases_emp_id FOREIGN KEY (emp_id)
        REFERENCES employee.main_table (id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
)

TABLESPACE test_laravel;

ALTER TABLE IF EXISTS employee.old_work_places
    OWNER to test1;