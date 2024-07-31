INSERT INTO severity(id,condition) 
VALUES(1,'light'),
      (2,'moderate'),
      (3,'urgent');

INSERT INTO patient(name,code)
VALUES('Jack','abc'),
      ('Peter','efg'),
      ('Claude','sus'),
      ('Charlotte','yes'),
      ('Mary','bno');

INSERT INTO queue(patientid,severityid,start) 
VALUES(1,2,current_timestamp),
      (2,2,current_timestamp),
      (3,3,current_timestamp),
      (4,1,current_timestamp);

INSERT INTO employee(username,password) 
VALUES('admin','admin');