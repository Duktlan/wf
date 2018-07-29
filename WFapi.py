import requests, json
import pymysql
import time

url="https://api.warframestat.us/pc/alerts"
reqs = requests.get(url)
reqsjson = json.loads(reqs.text)

db = pymysql.connect("localhost","root","","wf")
cursor = db.cursor()
cursor.execute("DROP TABLE IF EXISTS wfa")
sql ="""CREATE TABLE `wfa` (
    `type` varchar(50) NOT NULL,
    `Time` varchar(100) NOT NULL,
    `Reward` varchar(100) NOT NULL)"""
cursor.execute(sql)

for alert in reqsjson:
    sql = """INSERT INTO wfa(type,TIME,REWARD)
            VALUES (("%s"),("%s"),("%s"))""" %\
            (alert['mission']['type'],alert['eta'],alert['mission']['reward']['asString'])
    try:
        cursor.execute(sql)
        db.commit()
        print("更新成功")
    except:
        db.rollback()
        print("更新失敗")
db.close()
