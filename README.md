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
Depending on the e-mail adress or domain name, e-mails are allowed/disallowed to be sent to the customer.
The e-mail addresses are checked before the e-mail is generated.

Rewrites Mage_Core_Model_Email and Mage_Core_Email_Template to add e-mail sending events:
* Mage_Core_Model_Email: `email_send_before, email_send_after`
* Mage_Core_Model_Email_Template: `email_template_send_before, email_template_send_after`

Features:
* Block sending e-mails depending on Domainname or full e-mail address
* System Configuration:
--* Enable/Disable Module
--* Select Mode: Blacklist or Whitelist
--* Activate/deactivate Logging

Future work
-------------
* CSV Upload for E-Mail Adresses and Domains
* Check if e-mail adress does really exist (by checking mailbox etc.)
* Regex-Support

Compatibility
-------------
tbd

Installation Instructions
-------------------------
1. Install the extension using modman or copying the files.

Contributors
---------
* Andre Flitsch
* David Manners (@mannersd)
* Andreas Penz
* Anna Völkl (@rescueAnn)
* Matthias Zeis (@mzeis)

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)
