print('Script started')


print('Importing libraries')
import pickle
import pandas as pd
import pymysql

from credentials import DB_HOSTNAME, DB_NAME, DB_USERNAME, DB_PASSWORD


print('Loading model.pkl')
with open('model.pkl', 'r') as f:
    vectorizer, clf = pickle.load(f)


print('Loading tweets with similarity >= 0.5 and < 1')
connection = pymysql.connect(user=DB_USERNAME, password=DB_PASSWORD, host=DB_HOSTNAME, database=DB_NAME, charset='utf8')
query = """
    SELECT `similarities`.batch, tweet_id, full_text_clean
    FROM `tweets` 
    JOIN `similarities` ON `tweets`.`tweet_id`=`similarities`.`first_tweet_id` 
    JOIN (
        SELECT batch FROM `similarities` ORDER BY batch DESC LIMIT 1
    ) as last_batch ON last_batch.batch=`similarities`.`batch`
    WHERE 
        similarity >= 0.5 AND similarity < 1.0
"""
df = pd.read_sql(query, connection)


print('Extracting features using TF-IDF')
X = vectorizer.transform(df.full_text_clean)


print('Predicting class')
y_pred = clf.predict(X)
df_predicted = pd.concat([df, pd.Series(y_pred)], axis=1, ignore_index=True)
print(df_predicted)


print('Closing connection')
connection.close()


print('Script done')