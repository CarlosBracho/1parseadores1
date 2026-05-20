<?php

import requests
import json

headers={'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0', 'Accept': 'application/json; charset=utf-8'}
r = requests.get('https://stats.nba.com/stats/boxscoreplayertrackv2/?GameID=0021700300', headers=headers)

j =r.json()

for row in j['resultSets']:
    print (row['name'])
    for rowSet in row['rowSet']:
        print (rowSet)

?>