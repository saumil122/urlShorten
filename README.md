# urlShorten

Objective:

At many organisation, the marketing department often find themselves using long URLs with utm tracking.
These URLs often travel in emails and getting copied over sheets and docs, thereby are at risk of getting ruined by formatters.
The Objective of the project is to design and implement a url shortening system which would allow us to overcome these problems primarily.
   
Benefits:

- There is no restriction to URL length.
- The query parameters are not ignored.
- There is click tracking implementation.
- The generated url is used single time only.
- The short URL will be generated as a query string as well as with friendly url. 
- If TRACK_URL is set to "TRUE", the referral/hit count will be updated against the URL.
- If TRACK_URL is set to "FALSE", the short URL will be used only one time.

Installation:

1. Make sure your server meets the requirements:
    a) Optionally you can run this from your current domain or find a short domain
    b) Apache
    c) PHP
    d) MySQL
    e) Access to run SQL queries for installation
2. Download a .zip file of the "urlShorten" files
3. Upload the contents of the .zip file to your web server
4. Update the database info in config.php
5. Run the SQL included in urlShorten.sql. Many people use phpMyAdmin for this, if you can’t do it yourself contact your host.
