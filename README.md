# Gravity Forms - IBAN Field
Gravity Forms additional text field with IBAN validation logic.

This plugin uses the already tested IBAN checking library [php-iban](https://github.com/globalcitizen/php-iban) 
to validate IBAN account numbers.

I personally decided to not include a mask to frontend input field because of the too many
differences between IBAN number of characters in different countries, so you gonna find only 
a simple text input without frontend checks.