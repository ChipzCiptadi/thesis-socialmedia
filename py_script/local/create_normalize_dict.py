# -*- coding: utf-8 -*-

import pymysql

connection = pymysql.connect(user="root", password="", host="127.0.0.1", database="nurul", charset='utf8')

cursor = connection.cursor()

sql = 'select abnormal, normal from normalization'
cursor.execute(sql)

out_file = open('normalize_words.txt','w')

for (abnormal, normal) in cursor:
    out_file.write("{},{}\n".format(abnormal, normal))

out_file.close()
cursor.close()
connection.close()