

def splitter(string):
    string = string.replace("\n", " ")
    verses = string.replace("Verse", "splithere")
    verses = verses.split("splithere")
    verses = verses[1::]
    lyrics = []

    count = 1
    for x in range(len(verses)):
       verse = verses[x]
       verseDic = {}
       if verse.find("Refrain")>-1:
         versewithrefrain = verse.split("Refrain")
         verseOnly = versewithrefrain[0][12::]
         verseDic["Verse " + str(count)] = verseOnly
         lyrics.append(verseDic)
         verseDic = {}
         refrain = versewithrefrain[1][10::]
         verseDic["Refrain"] = refrain
         lyrics.append(verseDic)
         print("Verse " + str(count) + verseOnly)
         print(refrain)
         count = count + 1
         verseDic = {}
       else:
         verseDic["Verse " + str(count)] = verse[12::]
         lyrics.append(verseDic)
         verseDic = {}
         print("Verse " +str(count) + verse[10::])
         count = count + 1
    return lyrics

#string = "                                \n\nVerse 1         \nAll to Jesus I surrender;\nAll to him I freely give;\nI will ever love and trust him,\nIn his presence daily live.                  \n\nRefrain         \nI surrender all, I surrender all,\nAll to Thee, my blessed Savior,\nI surrender all.                          \n\nVerse 2         \nAll to Jesus I surrender;\nHumbly at his feet I bow,\nWorldly pleasures all forsaken;\nTake me, Jesus, take me now.                 \n\nVerse 3         \nAll to Jesus I surrender;\nMake me, Savior, wholly thine;\nLet me feel the Holy Spirit\nTruly know that Thou art mine.                 \n\nVerse 4         \nAll to Jesus I surrender;\nNow I feel the sacred flame.\nO the joy of full salvation!\nGlory, glory, to His name!                                "
#splitter(string)
