#Erik McLaughlin
#11/15/2015

from lxml import html
from lxml.html.clean import clean_html
import requests
import datetime
import requests
import sys
import os

def main():
    #Make sure the files are encoded in UTF-8
    reload(sys)
    sys.setdefaultencoding('utf8')
    now = datetime.datetime.now()
    
    #Retrieve lists of URLs and output file names
    urls = getURLs()
    fnames = getFNames()
    successfulRows = 0
    skippedRows = 0
    
    for i in range(len(urls)):
        tree = getData(urls[i]) #Retrieve entire HTML text from page
        rowNums = parseFile(tree, fnames[i])#Send HTML to parseFile() method
        successfulRows = successfulRows + rowNums[0]
        skippedRows = skippedRows + rowNums[1]
        
    print "\nDone."
    print "Processed %d pages from 7/2009 to %s/%d" % (len(urls), now.month, now.year)
    print "%d total malformed rows skipped out of %d" % (skippedRows, successfulRows)
    
    
#   Generates and returns a list of pages to scrape
#   Ranges from June 2009 to the current month and year
def getURLs():
    now = datetime.datetime.now()
    curYear = now.year

    months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
    ]
    curMonth = months[now.month - 1]
    #Begin with array of pages from 2009
    start_urls = [
                "http://www.montana.edu/police/policelog/2009/June2009.html",
                "http://www.montana.edu/police/policelog/2009/July2009.html",
                "http://www.montana.edu/police/policelog/2009/August2009.html",
                "http://www.montana.edu/police/policelog/2009/September2009.html",
                "http://www.montana.edu/police/policelog/2009/October2009.html",
                "http://www.montana.edu/police/policelog/2009/November2009.html",
                "http://www.montana.edu/police/policelog/2009/December2009.html"
                ]
    #Add pages to array from 2010 to the last complete year (2014 as of writing)
    for yr in range(2010, curYear):
        for mo in months:
            url = "http://www.montana.edu/police/policelog/%d/%s%d.html" % (yr, mo, yr)
            start_urls.append(url)
    #Add pages to array from current year
    for m in range(0, now.month):
        yr = curYear
        mo = months[m]
        url = url = "http://www.montana.edu/police/policelog/%s/%s%s.html" % (yr, mo, yr)
        start_urls.append(url)
        
    return start_urls
    
    
#   Same as getURLs() but without the URL formatting. 
#   These two methods could probably be condensed into one at some point
def getFNames():
    now = datetime.datetime.now()
    curYear = now.year

    months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
    ]
    curMonth = months[now.month - 1]
    start_fnames = [
                "2009June.csv",
                "2009July.csv",
                "2009August.csv",
                "2009September.csv",
                "2009October.csv",
                "2009November.csv",
                "2009December.csv"
                ]

    for yr in range(2010, curYear):
        for mo in months:
            start_fnames.append("%d%s.csv" % (yr, mo))
    for m in range(0, now.month):
        yr = curYear
        mo = months[m]
        start_fnames.append("%d%s.csv" % (yr, mo))
        
    return start_fnames
def getFile(fileName):
    with open (fileName, "r") as myfile:
        data=myfile.read().replace('\n', '').strip()
        
#   Retrieve page content from passed url string, remove extra tags and return a lxml.html tree object
def getData(url):
    print "Processing %s" % url
    page = requests.get(url)#Create tree object from page content with excess tags removed
    tree = html.fromstring(page.content.replace('<span>', '').replace('<p>', '').replace('<br>', '').replace(',', ''))
    return tree

#   Main functionality method
# 
def parseFile(tree, writeFileName):
    #Array containing names of table columns
    colNames = [    'Case Number        ',
                    'Report Date/Time   ',
                    'Occurred Date/Time ',
                    'Incident           ', 
                    'Location           ',
                    'Disposition        '
    #Extra empty elements in case table row is malformed or parsed incorrectly
    ,'', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '']; 
    
    #Folder names for output files
    outputFolder = 'output_csv/'
    skippedFolder = 'skipped/'
    #Create folders if they don't already exist
    if not os.path.exists(outputFolder):
        os.makedirs(outputFolder)
    if not os.path.exists(outputFolder + skippedFolder):
        os.makedirs(outputFolder + skippedFolder)
    
    #Create output files
    outFile = open(outputFolder + writeFileName, "wb")
    outFileSkipped = open(outputFolder + skippedFolder + writeFileName, "wb")
    recordedRows = 0
    skippedRows = 0
    
    
    #HTML parsing code... This might get rough
    tbl = tree.xpath('//section[@id=\'maincontent\']')  #tbl[] will only have one element, the table with the attribute 'maincontent'
    tr = tbl[0].xpath('//tbody/tr') #Select all <tr> elements within the <tbody> tag 
    for i in range(1,len(tr)):
        td = tr[i].xpath('td//text()')  #Select the text of each <td> element
        if len(td) == 6 and td[0] != '':    #Make sure there are exactly 6 elements in the row and the first isn't empty
            for j in range(len(td)):
                g = td[j].strip()   #strip leading and trailing whitespace
                h = " ".join(g.split()) #strip extra whitespace from the middle of string
                outStr = "%s," % h
                #print outStr
                outFile.write(outStr)   #Write value to output file
                #outFile.write("\n")
            outFile.write("\n") #Write end of line
            recordedRows = recordedRows + 1
        
        #Document malformed row values
        else:
            outFileSkipped.write(html.tostring(tr[i]))
            for j in range(len(td)):
                g = td[j].strip()
                h = " ".join(g.split())
                #outStr = "%s: %s" % (colNames[j], h)
                outStr = "%s," % h
                #print outStr
                outFileSkipped.write(outStr)
                #outFileSkipped.write("\n")
            outFileSkipped.write("\n")
            skippedRows = skippedRows + 1
            #print "Malformed row: %d in %s" % (i, writeFileName)
    outFile.close()
    print "%d/%d rows skipped" % (skippedRows, recordedRows + skippedRows)
    return [recordedRows, skippedRows]

main()