# -*- coding: utf-8 -*-
print('executing script: create_normalize_dict.py')

import pymysql
from credentials import DB_HOSTNAME, DB_NAME, DB_PASSWORD, DB_USERNAME

connection = pymysql.connect(user=DB_USERNAME, password=DB_PASSWORD, host=DB_HOSTNAME, database=DB_NAME, charset='utf8')

cursor = connection.cursor()

sql = 'select abnormal, normal from normalization'
# sql = 'select abnormal, normal from normalization'
cursor.execute(sql)

out_file = open('/var/www/thesis-socialmedia/py_script/normalize_words.txt','w')

for (abnormal, normal) in cursor:
    out_file.write("{},{}\n".format(abnormal, normal))

out_file.close()
cursor.close()
connection.close()

print('done')
print('')