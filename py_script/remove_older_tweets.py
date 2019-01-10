# -*- coding: utf-8 -*-
print('executing script: remove_older_tweets.py')

import pymysql
from credentials import DB_HOSTNAME, DB_NAME, DB_PASSWORD, DB_USERNAME

connection = pymysql.connect(host=DB_HOSTNAME, user=DB_USERNAME, password=DB_PASSWORD, db=DB_NAME, charset='utf8')

with connection.cursor() as cursor:
    sql = 'delete from similarities where first_tweet_id in (select tweet_id from tweets where date(tweet_created_at) < DATE_SUB(CURDATE(), INTERVAL 3 DAY));'
    cursor.execute(sql)
    sql = 'delete from tweets where date(tweet_created_at) < DATE_SUB(CURDATE(), INTERVAL 3 DAY);'
    cursor.execute(sql)

connection.commit()

print('deleted tweets older than 3 days')

print('done')
print('')