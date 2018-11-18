CREATE TABLE Strength (
AttackType_name  CHAR(8), 
DefendType_name  CHAR(8), 
Effectiveness    CHAR(18),
PRIMARY KEY (AttackType_name, DefendType_name),
FOREIGN KEY (AttackType_name)
  REFERENCES pType(name)
  ON DELETE CASCADE,
FOREIGN KEY (DefendType_name)
  REFERENCES pType(name)
  ON DELETE CASCADE);
