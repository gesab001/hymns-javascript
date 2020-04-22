import requests
import os
import sqlite3
import mysql.connector
import json
import verseSplitter

def addHymnMYSQL(number, title, verses):
    mydb = mysql.connector.connect(
       host="bible.cvtfhbljhzkg.ap-southeast-2.rds.amazonaws.com",
       user="gesab001",
       passwd="ch5t8k4u",
       database="bible"
    )
    print(mydb) 

    mycursor = mydb.cursor()

    sql = "INSERT INTO HYMNS (NUMBER, TITLE, VERSES) VALUES (%s, %s, %s)"
    val = (number, title, verses)
    mycursor.execute(sql, val)

    mydb.commit()

    print(mycursor.rowcount, title, "successful")

def add(number, title, verses):
  try:
    jsonFile = open("hymns.json", "r") # Open the JSON file for reading
    data = json.load(jsonFile) # Read the JSON into the buffer
    jsonFile.close() # Close the JSON file
    newHymn = {}
    newHymn["title"] = title
    newHymn["number"]= str(number)
    lyrics =  verseSplitter.splitter(verses)

    newHymn["verses"] =  lyrics
    newHymn["lastAccessed"]= ""
    newHymn["viewCount"]= "0"
    ## Working with buffered content
    data["hymns"].append(newHymn)
    ## Save our changes to JSON file
    jsonFile = open("hymns.json", "w+")
    jsonFile.write(json.dumps(data, indent=4))
    jsonFile.close()
  except Exception as e:
     print(e)


def getHymns():
    mydb = mysql.connector.connect(
       host="bible.cvtfhbljhzkg.ap-southeast-2.rds.amazonaws.com",
       user="gesab001",
       passwd="ch5t8k4u",
       database="bible"
    )
    mycursor = mydb.cursor()

    mycursor.execute("SELECT * FROM HYMNS")

    myresult = mycursor.fetchall()

    for x in myresult:
      number = x[1]
      title = x[2]
      verses = x[3]
      add(number, title, verses)

getHymns()
