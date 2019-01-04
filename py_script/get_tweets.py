# -*- coding: utf-8 -*-

#######################################
# project url: http://128.199.95.245/ #
#######################################

# import libraries
import tweepy
import io
import re
import datetime
import pymysql

# Variable initialization
CONSUMER_KEY = "y6SvS9b1e0NnYjVIybDqOI827"
CONSUMER_SECRET = "aCFD7Byf1dlAggt3rHHfz9xhzS66JdKZpHjwmaSNJYi3BVLVMz"
ACCESS_TOKEN = "1191910662-EDY4wBHJ5jvOD2LBP8yttWL1XxHLifgCV2buhLx"
ACCESS_SECRET = "8ucsX5TsoJAbQNDgb0B79ciPMQ6ON6zBIHohUzHCgQitW"

# API Authentication
auth = tweepy.OAuthHandler(CONSUMER_KEY, CONSUMER_SECRET)
auth.set_access_token(ACCESS_TOKEN, ACCESS_SECRET)
api = tweepy.API(auth)

# clean text using regex
def clean(text):
    # string lower
    clean_text = text.lower()
    # remove mention
    clean_text = re.sub(r'\B@[.a-zA-Z0-9_-]+', '', clean_text)
    # remove url
    clean_text = re.sub(r'http\S+', '', clean_text)
    # remove hashtag word
    clean_text = re.sub(r'([#＃]+)([0-9A-Z_]*[a-z_]+[a-z0-9_üÀ-ÖØ-öø-ÿ]*)', '', clean_text)
    # remove every symbols, numbers, and single letter a.k.a kepp only characters with len >= 2
    clean_text = re.sub(r'[^A-Za-z]+', ' ', clean_text)
    return clean_text

# remove stop-words
def remove_stop_words(text):
    from nltk.tokenize import word_tokenize
    with open('/var/www/socialmedia/py_script/id.stopwords.txt', 'r') as f:
        stopwords = f.readlines()
    stopwords = [w.strip('\n') for w in stopwords]
    tokens = word_tokenize(text)
    return ' '.join([w for w in tokens if not w in stopwords])

# normalize words
def normalize(text):
    with open('/var/www/socialmedia/py_script/normalize_words.txt', 'r') as f:
        while True:
            line = f.readline()
            if not line:
                break
            word = line.strip('\n').split(',')
            text = re.sub(r"\b%s\b" % word[0], word[1], text)

    return text

# stemming in action
def stem(text):
    from Sastrawi.Stemmer.StemmerFactory import StemmerFactory

    return StemmerFactory().create_stemmer().stem(text)

# DB Connection
connection = pymysql.connect(user="nurul", password="nurul", host="127.0.0.1", database="socialmedia", charset='utf8')
cursor_ddl = connection.cursor()
cursor_dml = connection.cursor()

# get all screen_names
query_ddl = "SELECT id, screen_name, last_tweet_id FROM tweet_account WHERE is_active=1"
cursor_ddl.execute(query_ddl)

# get last batch
last_batch = 0
with connection.cursor() as cursor_temp:
    cursor_temp.execute("SELECT batch FROM `tweets` ORDER BY batch DESC LIMIT 1")
    x = cursor_temp.fetchone()
    last_batch = x[0] if x is not None else 0

# for each account in tweet_account
for (acc_id, screen_name, last_tweet_id) in cursor_ddl:

    print('Mentioned:', screen_name, end=" ", flush=True)
    tweet_id = 0
    for tweet in tweepy.Cursor(api.search, q="@{} -filter:retweets".format(screen_name), lang="id", since_id=last_tweet_id, result_type="recent", tweet_mode="extended").items(100):
        query_insert = "INSERT INTO tweets (tweet_id, screen_name, full_text, full_text_clean, tweet_created_at, in_reply_to_status_id, in_reply_to_user_id, is_reply, retweet_count, favorite_count, batch) VALUES (%s,%s,%s,%s,%s + INTERVAL 7 HOUR,%s,%s,%s,%s,%s,%s)"
        full_text_clean = clean(tweet.full_text)
        full_text_clean = normalize(full_text_clean)
        full_text_clean = stem(full_text_clean)
        full_text_clean = remove_stop_words(full_text_clean)
        try:
            cursor_dml.execute(query_insert, (
                tweet.id,
                tweet.user.screen_name,
                tweet.full_text,
                full_text_clean,
                tweet.created_at,
                tweet.in_reply_to_status_id_str,
                tweet.in_reply_to_user_id_str,
                1 if tweet.in_reply_to_status_id_str or tweet.in_reply_to_user_id_str else 0,
                tweet.retweet_count,
                tweet.favorite_count,
                last_batch + 1
            ))

            tweet_id = tweet.id
        except Exception as e:
            with open('error.log', 'a') as logf:
                logf.write("{} - {}|{}".format(datetime.datetime.now(), screen_name, str(e)))
                pass
            pass

    query_update = "UPDATE tweet_account SET last_tweet_id=%s WHERE id=%s"
    cursor_dml.execute(query_update, (tweet_id, acc_id))

    connection.commit()
    print('saved')

# close connection
cursor_dml.close()
cursor_ddl.close()
connection.close()