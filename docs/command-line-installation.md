# Command-line Installation Guide
This guide assumes you have command line (ssh) access to the server. If you do not have command line access,
or are not comfortable using the command line, you can install the application without it using the
[No Command-line Installation Guide](no-command-line-installation.md)

## System Requirements
1. ACE server & MySQL server are outside accessible.
   * Wherever you're hosting your ACE server, the IP address or domain name for that server needs to be accessible from
   the outside world, otherwise the application is not going to be able to talk to it.
2. Server to host the files/website from
   * PHP 5.6 or higher required
3. Access to MySQL server that ACE is using
   * Your ACE database may be hosted on a different domain than your actual ACE server. You need this IP address or domain
   name and credentials to access the database. 
4. Secure HTTP (https).
   * The site requires https to be set up on the domain/subdomain to work. This ensures that your information stays secure.
5. Command line access to the web server
   * Command line access, specifically SSH access, makes the application installation go a lot faster. However if
   you do not have access to the command line, there is an alternative method of installation below.
6. Composer (https://getcomposer.org). Composer is a requirement if you use the command-line installation method.
   
**Note:** This guide assumes that you're not working in a shared hosting environment. There will be additional instructions
 on how to make sure the application runs right in a shared environment.

## Installation
1. Clone this repo.
2. Download Composer (https://getcomposer.org) and put the composer.phar file in the root directory of the repo.
3. Make a copy of `.env.example` and name it `.env`. You can now make changes to the .env file to reflect your server's
settings.
   * For a break-down on what all the options in this file mean and how to customize it to work with your server, follow
   the [Working with .env](working-with-env.md) guide.
4. Connect to your hosting server via FTP and upload the entire repo + composer.phar to the appropriate folder on the server.
   * This would likely be the web root for the domain/subdomain that you will be using to host this site.
5. 
