CREATE TABLE IF NOT EXISTS tentativeintrusion (
  id int NOT NULL auto_increment,
  horodatage datetime NOT NULL,
  login char(50) NOT NULL,
  pays varchar(50) NOT NULL,
  navigateur varchar(50) NOT NULL,
  os varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;