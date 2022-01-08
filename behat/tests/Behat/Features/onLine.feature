@zzz

Feature: api alarmsAction

  Scenario: Api1 - check google get - ko
    When I request "https://www.google.com/complete/search?q=test&cp=0&client=desktop-gws-wiz-on-focus-serp&xssi=t&gs_ri=gws-wiz&hl=it&authuser=0&pq=test&psi=6hsoYN-cN4mMlwSngqO4Dg.1613241324385&sugexp=foo%2Conf%3D1&dpr=1" using HTTP GET
    Then the response code is 201


  Scenario: Api1 - check google get - ok
    When I request "https://www.google.com/complete/search?q=test&cp=0&client=desktop-gws-wiz-on-focus-serp&xssi=t&gs_ri=gws-wiz&hl=it&authuser=0&pq=test&psi=6hsoYN-cN4mMlwSngqO4Dg.1613241324385&sugexp=foo%2Conf%3D1&dpr=1" using HTTP GET
    Then the response code is 200