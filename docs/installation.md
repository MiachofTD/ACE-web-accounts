# Installation Guide

Installation can happen one of two ways, depending on if you have command line access to the server you're going to host
this on. If you do have command line access, you're going to want to follow the "Command-line Installation Guide" below.
If you don't have command line access, you're going to want to follow the "No Command-line Installation Guide" below.
The command line method is the recommended way of installing this application.

* [Command-line Installation Guide](command-line-installation.md)
* [No Command-line Installation Guide](no-command-line-installation.md)

## Last Steps
Before granting full access to this application, there are a few things that you should do.

1. In your `.env` file, change the following values:
   * Change `APP_ENV` to `production`
      * You can also opt to remove this variable entirely and let the system default within Laravel take over
   * Change `APP_DEBUG` to `false`
2.