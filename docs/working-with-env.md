# Working with .env

The `.env` file is what Laravel uses to customize settings that are commonly changed across environments. In other platforms,
this file would be referred to as your config file. Most/all of the variables referenced in this file have default values
set within the application, so if the variable in the `.env` file doesn't exist, it has something to fall back to.

Here is the example `.env` file provided with this application. Variables can be added to this file as necessary, and any
fields that are not necessary for your setup, you can remove them entirely or comment them out by putting a `#` in
front of it.

```text
APP_ENV=local
APP_KEY=SomeRandomStringSomeRandomString
APP_DEBUG=true
APP_LOG=daily
APP_LOG_MAX_FILES=5
APP_LOG_LEVEL=debug
APP_TIMEZONE=America/Chicago

RECAPTCHA_KEY=

AC_SERVER_HOSTNAME=example.com
AC_SERVER_PORT=9000

LAYOUT_ANIMATED_BACKGROUND=false

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_USERNAME=
DB_PASSWORD=
AUTH_DATABASE=ace_auth
CHARACTER_DATABASE=ace_shard
WORLD_DATABASE=ace_world

ACCESS_LEVEL=0

CACHE_DRIVER=file
SESSION_DRIVER=file

MAIL_DRIVER=sendmail
MAIL_HOST=
#MAIL_PORT=
#MAIL_USERNAME=null
#MAIL_PASSWORD=null
#MAIL_ENCRYPTION=null
```

1. `APP_ENV` - This value determines the "environment" your application is currently running in. This may determine how
you prefer to configure various services your application utilizes.
   * Example - `local`, `stage`, or `production`
   * Setting this to `local` or `dev` during your setup and installation is perfectly normal. 
2. `APP_KEY` - This key is used by the encrypter service and should be set to a random, 32 character string, otherwise
these encrypted strings will not be safe.
   * By default, a 32 character string has been included in this file, however you're going to want to change it to
   something more secure.
3. `APP_DEBUG` - When your application is in debug mode, detailed error messages with stack traces will be shown on every
error that occurs within your application. If disabled, a simple generic error page is shown.
   * To disable this setting, set the value to `false`. You'll likely want to do this right before opening up general
   access to your site.
4. `APP_LOG` - Out of the box, laravel supports writing log information to one `single` file, a `daily` file, the `syslog`,
and the `errorlog`. You can use this variable to configure which logging option you want. By default, `daily` is selected,
since that does not have any underlying operating system requirements.
   * `single` - The log information will be stored in one single file. This is not recommended for a production environment,
   as there is no management for how big this file can get.
   * `daily` - The logging system will create a new log file for each day the server needs to log something.
   * `syslog` - This setting utilizes the syslog on your server (linux only). Data will be written to this file instead
   of generating log files within the laravel directory.
   * `errorlog` - This setting utilizes the errorlog for your web server (linux only). Data will be written to this file
    instead of generating log files within the laravel directory.
5. `APP_LOG_MAX_FILES` - The maximum number of log files laravel should keep before deleting old logs.
   * This setting is only used with the `daily` logging system. The default is `5`.
6. `APP_LOG_LEVEL` - You can choose how much information is recorded in the logs by default. Whatever option you choose,
the logging system will ignore any messages that fall into less severe categories. So if you choose `error`, the system
will log messages that fall into `error`, `critical`, `alert`, and `emergency`. The logging system severity levels are
(from least to most severe):
   * `debug`
   * `info`
   * `notice`
   * `warning`
   * `error`
   * `critical`
   * `alert`
   * `emergency`
7. `APP_TIMEZONE` - The system's default timezone.
   * You can find the list of supported timezones here: http://php.net/manual/en/timezones.php
8. `RECAPTCHA_KEY` - reCaptcha is required if you are going to utilize ACE registration through this application. Once you
sign up, all you need to do is add your key to this value for registration to be enabled.
   * You can learn more about reCaptcha here: https://developers.google.com/recaptcha/
9. `AC_SERVER_HOSTNAME` - This is the domain name or IP address to your ACE server. You don't need to include `http://`
or anything in front of it.
   * Example: `ac.example.com`
10. `AC_SERVER_PORT` - This is the port that your ACE server is listening on.
   * Example: `9000`
11. `LAYOUT_ANIMATED_BACKGROUND` - This application features an animated background on all the login/registration screens.
This background is actually a youtube video that features various portals in interesting sights throughout the game.
   * To turn this on, set the value to `true`.
12. `DB_CONNECTION` - This value should contain the type of database that your application will be using. To work with ACE,
you need to set this to `mysql`.
13. `DB_HOST` - This is the domain name or IP address to your ACE server's MySQL database. You don't need to include `http://`
or anything in front of it.
   * Example: `example.com`
14. `DB_PORT` - This is the port your mysql server is running on. Default is `3306`.
15. `DB_USERNAME` - This is the username you use to connect to your database. You should use the same information that
is found in the `config.json` file for your ACE server.
16. `DB_PASSWORD` - This is the password you use to connect to your database. You should use the same information that
is found in the `config.json` file for your ACE server.
17. `AUTH_DATABASE` - This is the name of the authentication database for ACE. This should be `ace_auth` as of when this
file was written.
18. `CHARACTER_DATABASE` - This is the name of the character database for ACE. This should be `ace_shard` as of when this
file was written.
19. `WORLD_DATABASE` - This is the name of the world database for ACE. This should be `ace_world` as of when this
file was written.
20. `ACCESS_LEVEL` - This is the access level that all users who register through this application will be given. This
corresponds directly to things the user can do while logged into the game world and into the application. This should stay
as `0`. Access levels:
   * `0` - Player
   * `1` - Advocate
   * `2` - Sentinel
   * `3` - Envoy
   * `4` - Developer
   * `5` - Admin
21. `CACHE_DRIVER` - This is the name of the driver for the caching mechanism the site uses. Default is `file`. If you want
to implement a caching system like `memcached` or `redis`, this is where you would specify that to the application.
   * You can learn more about implementing a caching system here: https://laravel.com/docs/5.2/cache
22. `SESSION_DRIVER` - This is the name of the driver for the session storage mechanism the site uses. Default is `file`.
If you want to implement a system for managing your session storage, this is where you would specify that.
    * You can learn more about implementing a session system here: https://laravel.com/docs/5.2/session
23. `MAIL_DRIVER` - This is the name of the mail service you would like to use to send any mail to your users, like
"Forgot Password" notifications. Your most commonly available options are going to be PHP's `mail` and `sendmail`. You'll want
to check with your hosting provider which one you can use. Laravel supports the following mail services:
   * SMTP
   * Mailgun
   * SparkPost
   * Amazon SES
   * PHP's default `mail` protocol
   * `sendmail`
24. `MAIL_HOST` - This is the email hostname that your email is going to be sent from.
   * Example: `mail.example.com`
25. `MAIL_PORT` - This is the port that your mail service uses to send mail. If your mail service or hosting provider
use a non-standard port to send mail, you would specify that here.
26. `MAIL_USERNAME` - This is the username you need to send an email. If your mail service or hosting provider requires
 you to authenticate to send an email, this is where you specify the username.
27. `MAIL_PASSWORD` - This is the password you need to send an email. If your mail service or hosting provider requires
you to authenticate to send an email, this is where you specify the username.
28. `MAIL_ENCRYPTION` - This is where you would specify any encryption information needed by your mail service or hosting
provider to send an email.