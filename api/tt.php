<?php


$doc = new DOMDocument();
// $url=“https://https.programmitv.it/stasera.html”;
@$doc->loadHtmlFile('https://https.programmitv.it/stasera.html');

var_dump(@$doc);
