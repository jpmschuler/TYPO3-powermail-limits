[![CI](https://github.com/jpmschuler/powermail-limits/actions/workflows/ci.yml/badge.svg)](https://github.com/jpmschuler/powermail-limits/actions/workflows/ci.yml)
![PHP-v](https://shields.io/packagist/php-v/jpmschuler/powermail-limits)
![Packagist](https://shields.io/packagist/v/jpmschuler/powermail-limits)



# EXT:powermail_limits
This extension allows you to set a submission limit for a TYPO3 EXT:powermail form

# Compatibility
- TYPO3: ^11
- PHP: ^7.4
- EXT:powermail ^10

# Installation
via composer `jpmschuler/powermail-limits`

# What it does
A form gets 3 new fields
- submissionlimit ?int: number of maximum submission
- haswaitlist: should the form be available after submissions are full to create a waitlist
- showpercentage: should there be an indicator for how many slots are left


In case of a configured limit:
- A new first "page" is prepended to the form with an infobox showing there is a limit, if that limit is reached, if a waiting list exists.
- If no waiting list and limit reached: rendering of other pages and submit is prohibited
- A field is added to the answers, indicating if it is a valid submission or a waiting list submission
- In case on invalid submission (limit reached, no waiting list) the mails are overridden to inform the user (Prefix for subject and body)

# ToDo
- [ ] override answer page with visual warning prefix
- [ ] check html and plain mail for sync
- [ ] mark invalid submission as hidden

# Preview

##  Infobox as first element in form
![image](./Resources/Private/Images/valid-form-0percentWithWait.png)
![image](./Resources/Private/Images/valid-form-90percent.png)
![image](./Resources/Private/Images/waitlist-form.png)
![image](./Resources/Private/Images/invalid-form.png)
## Dynamically added field about status
![image](./Resources/Private/Images/valid-answer.png)
![image](./Resources/Private/Images/waitlist-answer.png)
![image](./Resources/Private/Images/invalid-answer.png)
## Dynamically added mail prefixes
![image](./Resources/Private/Images/waitlist-mail.png)
![image](./Resources/Private/Images/invalid-mail.png)
