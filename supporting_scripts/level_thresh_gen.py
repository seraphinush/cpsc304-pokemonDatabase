import csv
import re

f = open(r"levelraw.csv", errors='ignore', mode='r')
fout = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\level_threshold.csv", 'w', encoding='utf-8', newline='')
rows = csv.reader(f)
counter = 0
name = ""
fast_moves = set()
special_moves = set()
write_rows = []
for row in rows:
    if counter == 24:
        counter = 0
    if counter == 0:
        m = re.search("Pokemon Name: ([a-zA-Z\(\)']*)\..*", row[0])
        name = m.groups()[0]
        counter += 1
        continue
    elif counter == 1 or counter == 2 or counter == 23:
        counter += 1
        continue
    else:
        m1 = re.search(".*?Level (\d*).*?", row[0])
        m2 = re.search(".*?Level (\d*).*?", row[2])
        m3 = re.search(".*?Level (\d*).*?", row[4])
        m4 = re.search(".*?Level (\d*).*?", row[6])
        m5 = re.search(".*?Level (\d*).*?", row[8])
        write_rows.append([name, m1.groups()[0], row[1]])
        write_rows.append([name, m2.groups()[0], row[3]])
        write_rows.append([name, m3.groups()[0], row[5]])
        write_rows.append([name, m4.groups()[0], row[7]])
        write_rows.append([name, m5.groups()[0], row[9]])
        counter += 1

writer = csv.writer(fout)
for row in write_rows:
    writer.writerow(row)


f.close()
fout.close()

