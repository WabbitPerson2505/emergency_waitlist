DROP TABLE IF EXISTS queue;

DROP TABLE IF EXISTS patient;

DROP TABLE IF EXISTS severity;

DROP TABLE IF EXISTS employee;

DROP SEQUENCE IF EXISTS actions_id_patient;

DROP SEQUENCE IF EXISTS actions_id_queue;

DROP SEQUENCE IF EXISTS actions_id_employee;

CREATE SEQUENCE actions_id_employee
  START WITH 1
  INCREMENT BY 1
  NO MINVALUE
  NO MAXVALUE
  CACHE 1;

CREATE SEQUENCE actions_id_patient
  START WITH 1
  INCREMENT BY 1
  NO MINVALUE
  NO MAXVALUE
  CACHE 1;

CREATE SEQUENCE actions_id_queue
  START WITH 1
  INCREMENT BY 1
  NO MINVALUE
  NO MAXVALUE
  CACHE 1;

CREATE TABLE severity(
  id integer primary key,
  condition varchar(20)
);

CREATE TABLE patient(
  id integer primary key DEFAULT nextval('actions_id_patient'::regclass),
  name varchar(40),
  code varchar(3)
);

CREATE TABLE queue(
  id integer DEFAULT nextval('actions_id_queue'::regclass),
  patientid int,
  severityid int,
  start timestamp,
  PRIMARY KEY (id, patientid, severityid),
  FOREIGN KEY (patientid) REFERENCES patient,
  FOREIGN KEY (severityid) REFERENCES severity
);

CREATE TABLE employee(
  id integer primary key DEFAULT nextval('actions_id_employee'::regclass),
  username varchar(40),
  password varchar(32)
);