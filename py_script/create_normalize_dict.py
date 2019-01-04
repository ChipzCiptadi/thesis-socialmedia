# -*- coding: utf-8 -*-
import pymysql

connection = pymysql.connect(user="nurul", password="nurul", host="127.0.0.1", database="socialmedia", charset='utf8')

cursor = connection.cursor()

sql = 'select abnormal, normal from normalization'
# sql = 'select abnormal, normal from normalization'
cursor.execute(sql)

out_file = open('/var/www/socialmedia/py_script/normalize_words.txt','w')

for (abnormal, normal) in cursor:
    out_file.write("{},{}\n".format(abnormal, normal))

out_file.close()
cursor.close()
connection.close()