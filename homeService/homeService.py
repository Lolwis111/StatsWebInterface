#!/usr/bin/python

from datetime import date, datetime, time, timedelta
from time import sleep
import MySQLdb as mdb
import socket
import string


def sendNote(message):
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_BROADCAST, 1)
    sock.sendto(message, ("192.168.178.255", 17654))


con = mdb.connect('localhost', 'calluser', 'callpsw', 'caller')
with con:

        cur = con.cursor()
    
        query = "SELECT * FROM requests WHERE `Processed` = '0';"
    
        cur.execute(query)
    
        rows = cur.fetchall()
    
        for row in rows:
            query = "UPDATE requests SET `Processed` = 1 WHERE `ID` = " + str(row[0])
        
            cur.execute(query)
        
            # ID,Name, Reason, Priority, Date, Time
            msg = "Request,{0},{1},{2},{3},{4},{5}".format(row[0],row[1], row[2], row[3], row[4].isoformat(), str(row[5]))

            # print msg

            sendNote(msg);
