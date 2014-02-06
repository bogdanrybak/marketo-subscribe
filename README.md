#Readme
==================

A WordPress plugin that includes a simple email newsletter form widget in which you can specify the campaign ID.

##How to use with Marketo?

Create a new smart campaign and in the smart list add a trigger called `campaign is requested' in which you specify the source as `Web Service API`.

Don't forget to fill out the User ID, Encryption Key and SOAP url in the settings section of WP.

Thanks to @benubois for the Marketo client.

`If installing plugin using git, don't forget to initialize the module (marketo library is a git submodule)`
