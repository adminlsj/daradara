import requests
from bs4 import BeautifulSoup
import bs4
import json
from selenium import webdriver
import os
import sys

url = sys.argv[1]
# Setup Web Driver
options = webdriver.FirefoxOptions()
options.headless = True
browser = webdriver.Firefox(options=options)

# Parse URL to get filename friendly title
file_title = ' - '.join(url.split('/')[3:6])

# Create Directory
if not os.path.isdir(file_title):
    os.makedirs(file_title)

# Get Site
browser.get(url)

# Parse HTML
html = BeautifulSoup(browser.page_source, 'lxml')

# Parse data from website
anime_data = {}

# Added try except because some pages don't have a banner
try:
    banner_image = html.find('div', {'class': 'banner'})['style']
    banner_image = banner_image[banner_image.find('"') + 1:banner_image.rfind('"')]
    anime_data.update({'Banner Image': banner_image})
except TypeError:
    banner_image = False
cover_image = html.find('img', {'class': 'cover'})['src']
anime_data.update({'Cover Image': cover_image})
title = html.find('h1').text.strip()
anime_data.update({'Title': title})

for x in html.find('div', {'class': 'data'}):
    # Ensure only tags are processed, not comments and other elements
    if type(x) == bs4.element.Tag:
        key = x.find('div', {'class': 'type'}).text

        # To process a data-list
        if x['class'] == ['data-set', 'data-list']:
            value = []
            for item in x.find('div', {'class': 'value'}):
                    value.append(item.text.strip().strip(','))

        # To process a normal data-set
        else:
            try:
                value = x.find('div', {'class': 'value'}).text.strip()
            except AttributeError:
                value = x.find('a', {'class': 'value'}).text.strip()
            if key == 'Episode\n\t\t\tDuration\n\t\t':
                key = 'Episode Duration'
            elif key == '\n\t\t\tDuration\n\t\t':
                key = 'Duration'

        # Add key & value pair to the data dict
        anime_data.update({key: value})

tags = []

for x in html.findAll('div', {'class': 'tag'}):
    tag = x.a.text.replace('\n', '').replace('\t', '')
    rank = x.div.text
    tags.append([tag, rank])

anime_data.update({'tags': dict(tags)})

print(json.dumps(anime_data))

# open(file_title + '/data.json', 'w').write(json.dumps(anime_data))

browser.quit()



