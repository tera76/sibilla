INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('corriere_primaPosClassifica_title', 'classifica.dettaglioClassifica.0.title', 'https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10', 'json', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('corriere_primaPosClassifica_totView', 'classifica.dettaglioClassifica.0.totViews', 'https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10', 'json', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('total_population', 'total_population.0.population', 'https://d6wn6bmjj722w.population.io/1.0/population/World/today-and-tomorrow/', 'json', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('current_time', 'datetime', 'http://worldtimeapi.org/api/timezone/Europe/Rome.json', 'json', null, 0);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('coronaVirus_Total_confirmed', 'features.0.attributes.Total_Confirmed', 'https://services1.arcgis.com/0MSEUqKaxRlEPj5g/arcgis/rest/services/cases_time_v2/FeatureServer/0/query?f=json&where=1%3D1&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=*&orderByFields=Report_Date_String%20desc&outSR=102100&resultOffset=0&resultRecordCount=1&cacheHint=true', 'json', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('comment_this', 'localAction', 'comment_this_function', '', null, 0);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('cicciolina_altezza', '//*[@id=\\"mw-content-text\\"]/div/table[1]/tbody/tr[7]/td', 'https://it.wikipedia.org/wiki/Ilona_Staller', 'html', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('classifica_dischi_italiani', 'charts_details.0.title', 'https://ww2nhihg61.execute-api.eu-west-1.amazonaws.com/prod/api/charts/1?limit=10', 'json', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('gold_price', 'table_data.metal_price_current', 'https://www.orissimo.it/dati/?period=today&xignite_code=XAU&currency=eur&weight_unit=grams', 'json', null, 1);
INSERT INTO my_andreamatera.syb_alarms_map (name, locator, url, locatorType, column_5, active) VALUES ('ansa_news', '//section/article[1]/header/h3', 'http://www.ansa.it/sito/notizie/topnews/', 'html', null, 1);