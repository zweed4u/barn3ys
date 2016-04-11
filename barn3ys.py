#!/usr/bin/env python
import urllib2

count=504000000

def redirect(url):
	req = urllib2.Request(url)
	res = urllib2.urlopen(req)
	end = res.geturl()
	print str(count)+' - '+end

while count<504999999:
	try:
		redirect('http://www.barneys.com/'+str(count)+'.html')
	except:
		print str(count)
	count+=1
