#!/usr/bin/python
import smtplib
import sys
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText



s = smtplib.SMTP(host="YOUR_EMAIL_SERVER", port=587)
s.starttls()
s.login("YOUR_EMAIL","YOUR_PASSWORD")
msg=MIMEMultipart()


msg["From"]="mail@mail.com"
msg["To"]=sys.argv[2]
msg["Subject"]="groupAlert"
msg.attach(MIMEText(sys.argv[1],"plain"))
s.send_message(msg,'YOUR_EMAIL',sys.argv[2])

