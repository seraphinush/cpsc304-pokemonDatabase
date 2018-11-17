import csv
import re

f = open(r"strength.csv", errors='ignore', mode='r')
fout = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\strength.csv", 'w', encoding='utf-8', newline='')

rows = csv.reader(f)
rows = list(rows)

h = len(rows)
w = len(rows[0])
write_rows = []

for i in range(1, h):
    for j in range (1, w):
        write_rows.append([rows[i][0], rows[0][j], rows[i][j]])

writer = csv.writer(fout)
for row in write_rows:
    writer.writerow(row)

f.close()
