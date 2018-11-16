CREATE TABLE Evolutions (
PreEvolution_name 		CHAR(10), 
PostEvolution_name 		CHAR(10),
PRIMARY KEY (PreEvolution_name, PostEvolution_name),
FOREIGN KEY (PreEvolution_name)
  REFERENCES Species(name)
  ON DELETE CASCADE,
FOREIGN KEY (PostEvolution_name)
  REFERENCES Species(name)
  ON DELETE CASCADE)
