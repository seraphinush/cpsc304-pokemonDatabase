import csv
import re

f = open(r"type-move.csv", errors='ignore', mode='r')
fout = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\specie-move.csv", 'w', encoding='utf-8', newline='')
movesf = open(r"C:\Users\Ofirt\Desktop\CPSC 304\Project\moves.csv", 'w', encoding='utf-8', newline='')
rows = csv.reader(f)
counter = 0
name = ""
fast_moves = set()
special_moves = set()
write_rows = []
for row in rows:
    name = row[1].strip()
    if name == "identifier":
        continue
    fast = row[2].split(",")
    special = row[3].split(",")
    for fa in fast:
        write_rows.append([name, fa.strip()])
        fast_moves.add(fa)
    for sp in special:
        write_rows.append([name, sp.strip()])
        special_moves.add(sp)


writer = csv.writer(fout)
for row in write_rows:
    writer.writerow(row)

write_rows = []
for fa in fast_moves:
    write_rows.append([fa.strip(), "fast"])
for sp in special_moves:
    write_rows.append([sp.strip(), "special"])

writer = csv.writer(movesf)
for row in write_rows:
    writer.writerow(row)

print(len(fast_moves))
print("\n\r")
print(len(special_moves))

f.close()
fout.close()
movesf.close()

