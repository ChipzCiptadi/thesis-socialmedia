# -*- coding: utf-8 -*-
print('Script started')


print('Importing libraries')
import pickle
import pandas as pd
import pymysql

from credentials import DB_HOSTNAME, DB_NAME, DB_USERNAME, DB_PASSWORD


print('Loading model.pkl')
with open('model.pkl', 'rb') as f:
    vectorizer, clf = pickle.load(f)


print('Loading tweets with similarity >= 0.5 and < 1')
connection = pymysql.connect(user=DB_USERNAME, password=DB_PASSWORD, host=DB_HOSTNAME, database=DB_NAME, charset='utf8')
query = """
    SELECT similarities.id, full_text_clean
    FROM tweets 
    JOIN similarities ON tweets.tweet_id=similarities.first_tweet_id 
    JOIN (
        SELECT batch FROM similarities ORDER BY batch DESC LIMIT 1
    ) as last_batch ON last_batch.batch=similarities.batch
    WHERE 
        similarity >= 0.5 AND similarity < 1.0 AND
        prediction IS NULL
"""
df = pd.read_sql(query, connection)


print('Extracting features using TF-IDF')
X = vectorizer.transform(df.full_text_clean)


print('Predicting class')
y_pred = clf.predict(X)
df_predicted = pd.concat([df, pd.Series(y_pred, name="prediction")], axis=1, ignore_index=True)
print(df_predicted)

print('Insert prediction to DB')
cursor = connection.cursor()
for index, row in df_predicted.iterrows():
    query = "UPDATE similarities SET prediction=%s WHERE id=%s"
    cursor.execute(query, (row[2], row[0]))

connection.commit()

print('Closing connection')
cursor.close()
connection.close()


print('Script done')