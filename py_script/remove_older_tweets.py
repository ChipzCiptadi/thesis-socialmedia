import pymysql

connection = pymysql.connect(host='localhost', user='nurul', password='nurul', db='socialmedia', charset='utf8')

with connection.cursor() as cursor:
    sql = 'delete from tweets where date(tweet_created_at) < DATE_SUB(CURDATE(), INTERVAL 3 DAY);'
    cursor.execute(sql)

connection.commit()

print('deleted tweets older than 3 days')