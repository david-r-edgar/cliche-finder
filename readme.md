# Cliche Finder

In-development project for a utility to search input text for cliches.

The idea is to provide both a web form, and a REST API through which clients (eg. mobile app) can access the search facility.

For the main search request, the API should accept Unicode text input, and return a list of matches. Markup such as HTML should be stripped by the client prior to sending the request to the server. Hopefully this will enable a number of different client use-cases (eg. checking input text in a web form, searching input text from a native application, checking a web page). 

The implementation is based on a laravel back-end, with some front-end JS for the initial web client.
