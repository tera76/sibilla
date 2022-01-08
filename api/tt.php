<?php


$doc = new DOMDocument();
@$doc->loadHtmlFile('https://en.wikipedia.org/wiki/List_of_UFC_events');

var_dump(@$doc);
