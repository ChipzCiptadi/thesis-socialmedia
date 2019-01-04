# -*- coding: utf-8 -*-
# NOTE: Must be executed AFTER executing get_tweets.py

import pymysql
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

# DB connection
connection = pymysql.connect(user="root", password="", host="127.0.0.1", database="nurul", charset='utf8')
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
cursor_ddl.execute(query_ddl)

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
        cursor_dml.execute(query_similarity, (
            tweet_batch, 
            tweet_ids[i], 
            tweet_ids[j], 
            float(round(similarity[0,j], 6))
        ))

    connection.commit()

print('done')

# close connection
cursor_dml.close()
cursor_ddl.close()
connection.close()