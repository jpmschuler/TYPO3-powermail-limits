
[![TYPO3 extension powermail_limits](https://shields.io/endpoint?label=EXT&url=https://typo3-badges.dev/badge/powermail_limits/extension/shields)](https://extensions.typo3.org/extension/powermail_limits)
[![Latest TER version](https://shields.io/endpoint?label=TER&url=https://typo3-badges.dev/badge/powermail_limits/version/shields)](https://extensions.typo3.org/extension/powermail_limits)
[![Latest Packagist version](https://shields.io/packagist/v/jpmschuler/powermail-limits?label=Packagist&logo=packagist&logoColor=white)](https://packagist.org/packages/jpmschuler/powermail-limits)
![Total downloads](https://typo3-badges.dev/badge/powermail_limits/downloads/shields.svg)

![Supported TYPO3 versions](https://shields.io/endpoint?label=typo3&url=https://typo3-badges.dev/badge/powermail/typo3/shields)
[![Current CI health](https://github.com/jpmschuler/TYPO3-powermail-limits/actions/workflows/ci.yml/badge.svg)](https://github.com/jpmschuler/TYPO3-powermail-limits/actions/workflows/ci.yml)


# EXT:powermail_limits

This extension allows you to set a submission limit for a TYPO3 EXT:powermail form

# Compatibility

- TYPO3: ^12
- PHP: ^8.0 (tested with 8.2)
- EXT:powermail ^12.4.0

# Installation

`composer req jpmschuler/powermail-limits`

# What it does

A form gets 3 new fields

- `has submission limit`: enable and enter a max submission limit in order to enable this extension for a form
- `has waiting list`: should the form be still available after submissions are full to create a waitlist
- `show allocation percentage`: should there be an indicator for how many slots are left

After enabling a submission limit the form will get a new first "page" (or fieldset) prepended with an infobox showing
there is a limit, if that limit is reached and if a waiting list exists.
If however no waiting list was configured and the limit is reached only the infobox is shown and the rest of the form
fields and submit won't be rendered.
In case the limit was reached an additional mail will be sent to the configured recipient (probably editor responsible
for the form) in order to be able to take actions.

Using a DataProcessor a field is added to the answers (thus visible in `{powermail_all}`, indicating if it is a valid
submission or a waiting list submission.
In case of a submission after the limit is reached the mail subject gets a prefix and the mail body gets a prefix
(depending on if waiting list or not). If there is an invalid submission (e.g. opened form early, others submitted and
filled limit, than late submit that old form) without an waiting list the mail record is marked hidden.

For forms without a waiting list you can disable or delete mails in the backend to make slots free again.
For forms with a waiting list the limit will be counted by all non-disabled mails. Thus, probably you don't want to
disable duplicates after the first waiting list registration was done, until the form goes offline. Contacting the
applicants to move them from waiting list to valid slot is not done via the extension, but deemed a manual
process, done after the form was disabled e.g. based on a CSV export.

# Labels and Overrides

All labels are currently locally managed and available in `en` and `de`. Thus, they can easily be overridden.
The indictator is calculated in 10percent rounded-down steps, so e.g. if there are 87% of slots filled, the label for 80
is shown. This allows a bit of transparency without telling everybody that nobody registered for that 2000 participants
event or without telling everybody you really had only 8 slots.

```
form.submissionspercentage.0: enough free slots
form.submissionspercentage.10: enough free slots
form.submissionspercentage.20: enough free slots
form.submissionspercentage.30: enough free slots
form.submissionspercentage.40: enough free slots
form.submissionspercentage.50: enough free slots
form.submissionspercentage.60: still slots available
form.submissionspercentage.70: still slots available
form.submissionspercentage.80: still slots available
form.submissionspercentage.90: Warning! Only a few slots available
```

# ToDo

- [ ] override backend module mail entry subject (currently the invalid and waitlist prefixes aren't saved)
- [ ] override answer page with visual warning prefix
- [ ] add backend powermail module deep link to limit reached mail

# Preview

## Infobox as first element in form

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

## Additional mail if limit reached

![image](./Resources/Private/Images/limitfull-mail.png)
