MailGuard
=========

Hackathon_MailGuard
=====================
Blacklist and Whiltelist solution for Magento E-Mails

Facts
-----
- version: XXX
- [extension on GitHub](https://github.com/magento-hackathon/MailGuard)

Description
-----------
Depending on the e-mail address or domain name, e-mails are allowed/disallowed to be sent to the customer.
The e-mail addresses are checked before the e-mail is generated.

Rewrites Mage_Core_Model_Email and Mage_Core_Email_Template to add e-mail sending events:
* Mage_Core_Model_Email: `email_send_before, email_send_after`
* Mage_Core_Model_Email_Template: `email_template_send_before, email_template_send_after`

### Features:
#### Allows/Blocks sending e-mails
   depending on Domainname or full e-mail address
   When working with domainname it must start with @ e.g. @example.com
#### System Configuration:
 * Enable/Disable Module
 * Select Mode: Blacklist or Whitelist
 * Activate/deactivate Logging
 * Importing addresses via CSV file

### Importing addresses via CSV file

The file import dialog can be found in `System > Configuration > Mail Guard > General Settings > Import > Import address list`.

Specify the column names in the first line. Two columns are required: `mailaddress` and `type`.
The order of the columns is determined automatically. If you export the CSV file you can leave the `id` column in but it will be ignored.

Note that the `type` values are translated. This means that you should import the file in the same language in which you
exported the entries before. If you get an error that you didn't provide an expected value first check if you have to
translate the type.

### Future work
* Validate input on form edit / CSV import
* Check if e-mail address does really exist (by checking mailbox etc.) [phpclasses.org](http://www.phpclasses.org/package/13-PHP-Determine-if-a-given-e-mail-address-is-valid-.html)
* Regex-Support

Compatibility
-------------
tbd

Installation Instructions
-------------------------
1. Install the extension using modman or copying the files.

Contributors
---------
* Andre Flitsch (@andreflitsch)
* David Manners (@mannersd)
* Andreas Penz
* Anna Völkl (@rescueAnn)
* Matthias Zeis (@mzeis)

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)
