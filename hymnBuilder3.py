import requests
import os
import sqlite3
import mysql.connector

def addHymnMYSQL(number, title, verses):
    mydb = mysql.connector.connect(
       host="bibledb.cvtfhbljhzkg.ap-southeast-2.rds.amazonaws.com",
       user="giovanni",
       passwd="mypassword",
       database="bible"
    )
    print(mydb) 

    mycursor = mydb.cursor()

    sql = "INSERT INTO HYMNS (NUMBER, TITLE, VERSES) VALUES (%s, %s, %s)"
    val = (number, title, verses)
    mycursor.execute(sql, val)

    mydb.commit()

    print(mycursor.rowcount, title, "successful")


def addHymn(number, title, verses):
        conn = sqlite3.connect('hymn2.db')
        conn.execute("INSERT INTO HYMNS (NUMBER, TITLE, VERSES) VALUES(?, ?, ?)", (number, title, verses));
        conn.commit()
        print (str(number) + " " + str(title) + "  added successfully");
        conn.close()    

response = requests.get('http://sdahymnals.com/Hymnal/')
#print(response.status_code)
hymntitles = str(response.content)
hymntitles = hymntitles.split('href="')
print(len(hymntitles))
hymnlinks = []
for hymn in hymntitles:
   if hymn.startswith("http://sdahymnals.com/Hymnal/"):
      hymn = hymn.split("</a>")
      hymn2 = hymn[0]
      hymn3 = hymn2.split('">')
      if hymn3[0].endswith("/"):
         hymnlinks.append(hymn3[0])

print (len(hymnlinks))

#print (hymnlinks[0])

response = requests.get(hymnlinks[0])
#print(response.status_code)
hymn = str(response.content)    
print(hymn)


response = requests.get("http://adventisthymns.com/numbers/")
hymnnumbers = str(response.content)
hymnnumbers = hymnnumbers.split('href="')
numbercategories = []
for hymn in hymnnumbers:
   if hymn.startswith("http://adventisthymns.com/numbers/"):
      split = hymn.split('" title="')
      numbercategories.append(split[0])

hymnlinks =  []
for value in numbercategories:
   response = requests.get(value)
   #print(response.status_code)
   hymntitles = str(response.content)    
   hymntitles = hymntitles.split('href="')
   for hymn in hymntitles:
      if hymn.startswith("http://adventisthymns.com/lyrics/"):
         hymn1 = hymn.split("&ndash;")
         hymn2 = hymn1[0].split('">')
         hymnlinks.append(hymn2[0])


hymnsList = []
aHymn = []
count = 1
for link in hymnlinks:
  response = requests.get(link)
  hymnWords = str(response.content)
#hymnWords = #hymnWords.split('palm-one-whole  lyrics">')
#verses = #hymnWords[1].split('<ol class="hymn-nav  nav  nav--fit  pagination  hide--desk">')
  indexStart = int(hymnWords.index("<h1 class=\"hymn-title\" itemprop=\"name\">"))
#print(indexStart)
  indexStart = int(hymnWords.index("<h1 class=\"hymn-title\" itemprop=\"name\">")) + 39
#print(indexStart)
  hymnTitle1 = hymnWords[indexStart:]
  titleSplit = hymnTitle1.split("</h1>")
  hymnTitle = titleSplit[0]
  split2 = hymnTitle.split("\\n")
  hymnTitle = split2[0]
  #indexEnd = int(hymnTitle.index("</h1>\\n\\t\\t\\t\\t<div"))
  #hymnTitle = hymnTitle[:indexEnd] + "\n\n"
  index = len("<div class=\"g  four-sixths  palm-one-whole  lyrics\">")
  indexStart = int(hymnWords.index('<div class="g  four-sixths  palm-one-whole  lyrics">')) + index 
  indexEnd = int(hymnWords.index('<ol class="hymn-nav  nav  nav--fit  pagination  hide--desk">'))
  completeHymn = str(hymnWords[indexStart:indexEnd])
  completeHymn = completeHymn.replace("\\t", " ")
  completeHymn = completeHymn.replace("\\n", " ")
  completeHymn = completeHymn.replace("\\xe2\\x80\\x99", "'")
  completeHymn = completeHymn.replace("class=\"line-type\">", "")
  completeHymn = completeHymn.replace("</p>", "")
#completeHymn = completeHymn.replace("/> ", "")
  completeHymn = completeHymn.replace("<br /> ", "\n")
  completeHymn = completeHymn.replace("<h2", "\n\n")
  completeHymn = completeHymn.replace("</h2>", "")
  completeHymn = completeHymn.replace("<p>", "\n")
  completeHymn = completeHymn.replace(" Verse", "Verse")
  completeHymn = completeHymn.replace("\\n ", "\n")
  completeHymn = completeHymn.replace("&#8217;", "'")
  completeHymn = completeHymn.replace("\\xe2\\x80\\x94", "-")
  completeHymn = completeHymn.replace("\\xe2\\x80\\x99", "'")
  completeHymn = completeHymn.replace("\\xe2\\x80\\x93", "-")
  completeHymn = completeHymn.replace("\\xe2\\x80\\x9c", "\"")
  completeHymn = completeHymn.replace("&#8216;", "'")
  completeHymn = completeHymn.replace("&#8220;", "")
  completeHymn = completeHymn.replace("&#8221;", "")
  completeHymn = completeHymn.replace("\\xe2\\x80\\x98", "")
  completeHymn = completeHymn.replace("&", "")
  completeHymn = completeHymn.replace(";'", "'")
  completeHymn = completeHymn.replace(" Refrain", "Refrain")
#completeHymn = completeHymn.replace("
 # print(len(titleSplit))
 # print(hymnTitle)
 # print (completeHymn)
#print(hymnWords[9122:])
#  for string in verses2:
  number = count
  title = hymnTitle
  verses = completeHymn
  #addHymn(number, title, verses)
  addHymnMYSQL(number, title, verses)
  aHymn = []
  count = count +1

"""
  aHymn.append(hymnTitle)
  aHymn.append(completeHymn)
  hymnsList.append(aHymn)

  aHymn = []
  count = count +1


print(len(hymnsList))
print(hymnsList)

for x in range(0,len(hymnsList)+1, 1):
    hymn = hymnsList[x]
    number = x + 1
    title = hymn[0] 
    verses = hymn[1]
    with open("hymns.txt", "a") as myfile:
      myfile.write("<hymn>\n" + "<number>" + str(number) + "</number>" + "\n" + "<title>"+title + "</title>\n" + "<verses>"  + verses + "</verses>\n" + "</hymn>" + "\n\n\n")
      myfile.close()

    #addHymn(number, title, verses)
"""
