# -*- coding: utf-8 -*-
import pymysql

connection = pymysql.connect(user="root", password="", host="127.0.0.1", database="nurul", charset='utf8')

with connection.cursor() as cursor:
    sql = 'delete from tweets where date(tweet_created_at) < DATE_SUB(CURDATE(), INTERVAL 3 DAY);'
    cursor.execute(sql)

connection.commit()

print('deleted tweets older than 3 days')