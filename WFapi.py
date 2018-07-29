#引入函示庫
import requests, json
import pymysql
import time

#while 1<2:
#利用get取得API資料
url="https://api.warframestat.us/pc/alerts"
reqs = requests.get(url)

#利用json.loads()解碼JSON
reqsjson = json.loads(reqs.text)

#利用迴圈儲存任務獎勵
#for alert in reqsjson:
    #print(alert['id'])
    #print(alert['eta'])
    #print(alert['mission']['reward']['asString'])


# 打开数据库连接
db = pymysql.connect("localhost","root","","wf")

    # 使用 cursor() 方法创建一个游标对象 cursor
cursor = db.cursor()

# 使用 execute() 方法执行 SQL，如果表存在则删除
cursor.execute("DROP TABLE IF EXISTS wfa")

# 创建表
sql ="""CREATE TABLE `wfa` (
    `type` varchar(50) NOT NULL,
    `Time` varchar(100) NOT NULL,
    `Reward` varchar(100) NOT NULL)"""

cursor.execute(sql)

# SQL 插入语句
for alert in reqsjson:
    sql = """INSERT INTO wfa(type,TIME,REWARD)
            VALUES (("%s"),("%s"),("%s"))""" %\
            (alert['mission']['type'],alert['eta'],alert['mission']['reward']['asString'])
    try:
        # 执行sql语句
        cursor.execute(sql)
        # 提交到数据库执行
        db.commit()
        print("更新成功")
    except:
        # 如果发生错误则回滚
        db.rollback()
        print("更新失敗")
    
    # 关闭数据库连接
db.close()
    
    #time.sleep(60)