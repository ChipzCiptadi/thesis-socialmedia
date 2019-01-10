# -*- coding: utf-8 -*-
# NOTE: Must be executed AFTER executing get_tweets.py
print('executing script: tweet_similarity.py')

import pymysql
import sys
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

from credentials import DB_HOSTNAME, DB_NAME, DB_PASSWORD, DB_USERNAME

# DB connection
connection = pymysql.connect(user=DB_USERNAME, password=DB_PASSWORD, host=DB_HOSTNAME, database=DB_NAME, charset='utf8')
cursor_ddl = connection.cursor()
cursor_dml = connection.cursor()

# select tweets having latest batch number
query_similarity = "INSERT INTO similarities (batch, first_tweet_id, second_tweet_id, similarity) VALUES (%s, %s, %s, %s)"
query_ddl = """
    SELECT tweet_id, full_text_clean, tweets.batch
    FROM tweets
    JOIN (
        SELECT batch
        FROM tweets
        ORDER BY batch DESC
        LIMIT 1
    ) as batch_tweet ON batch_tweet.batch=tweets.batch
"""
numrows = cursor_ddl.execute(query_ddl)

if numrows > 0:
    tweet_texts = []
    tweet_ids = []
    tweet_batch = 0
    for (tweet_id, full_text_clean, batch) in cursor_ddl:
        tweet_texts.append(full_text_clean)
        tweet_ids.append(tweet_id)
        tweet_batch = batch

    # convert documents into BoW using TFIDF
    vectorizer = TfidfVectorizer()
    matrix = vectorizer.fit_transform(tweet_texts)

    # get similarities
    for i in range(matrix.shape[0]):
        similarity = cosine_similarity(matrix[i], matrix)

        for j in range(similarity.shape[1]):
            if similarity[0,j] >= 0.5:
                cursor_dml.execute(query_similarity, (
                    tweet_batch, 
                    tweet_ids[i], 
                    tweet_ids[j], 
                    float(round(similarity[0,j], 6))
                ))

        connection.commit()

# close connection
cursor_dml.close()
cursor_ddl.close()
connection.close()

print('done')
print('')