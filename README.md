# Objective:

At many organisation, the marketing department often find themselves using long URLs with utm tracking. These URLs often travel in emails and getting copied over sheets and docs, thereby are at risk of getting ruined by formatters. The Objective of the project is to design and implement a url shortening system which would allow us to overcome these problems primarily.
   
# Benefits:

- There is no restriction to URL length.
- The query parameters are not ignored.
- There is click tracking implementation.
- The generated url is used single time only.
- The short URL will be generated as a query string as well as with friendly url. 
- If TRACK_URL is set to "TRUE", the referral/hit count will be updated against the URL.
- If TRACK_URL is set to "FALSE", the short URL will be used only one time.

# Prerequisite:

Make sure your server meets the requirements:
- PHP
- Apache
- MySQL
- MOD_REWRITE enable.


# Setup & Assumptions:

- The setup guide regarding the system are mentioned in <a href="https://github.com/saumil122/urlShorten/blob/master/SETUP.md">setup.md</a>
- The assumptions regarding the system are mentioned in <a href="https://github.com/saumil122/urlShorten/blob/master/ASSUMPTIONS.md">assumption.md</a>
