import csv
import re

f = open(r"type-pokemon.csv", errors='ignore', mode='r')
fout = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\specie-type.csv", 'w', encoding='utf-8', newline='')

rows = csv.reader(f)
write_rows = []
for row in rows:
    if row[2] == type:
        continue
    types = row[2].split(" · ")
    for t in types:
        write_rows.append([row[1], t.strip()])

writer = csv.writer(fout)
for row in write_rows:
    writer.writerow(row)

fout.close()
f.close()

