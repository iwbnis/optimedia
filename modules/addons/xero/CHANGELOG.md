# CHANGELOG

## 8.11 (2023-08-21)

 - Only sync contact email address when sync contacts setting or email via Xero is enabled

## 8.10 (2023-06-13)

 - Only paid invoice sync now includes credits
 - Fix for obscure payment sync errors with zero reference invoice numbers

## 8.9 (2023-05-23)

 - Add support for new Xero API changes
 - Fix for PHP 8 error
 - Reduce calls to Xero API Organisation endpoint

## 8.8 (2023-04-13)

 - Further fix for "Resource not found" error when syncing lots of payments
 - Database table improvements

## 8.7 (2023-03-29)

 - Add force sync all from specified ID option

## 8.6 (2023-03-06)

 - Improvement to WHMCS to Xero payment sync
 - Bug fix for sending Invoice emails via Xero
 - Add check to stop Xero payments syncing back after Direct Debit reversals

## 8.5 (2023-01-18)

 - Remove duplicate prefixes if WHMCS already has the same one

## 8.4 (2022-12-22)

 - Improve PHP 8.1 compatibility
 - Reduce payments synced from 100 to 50 at a time

## 8.3 (2022-12-20)

 - Fix "Resource not found" error when syncing lots of payments

## 8.2 (2022-12-19)

 - Fix issue with not all invoices syncing

## 8.1 (2022-12-05)

 - [Feature] Add {$xero_url} to invoice email variables
 - Don't sync changes to draft Invoices

## 8.0 (2022-12-01)

 - [Feature] We now sync Invoices using their "number" instead of the ID
 - [Feature] Add option to only sync paid Invoices
 - [Feature] Prevent draft Invoices syncing to Xero
 - Add support for custom/sequential invoice number format

## 7.1 (2022-11-29)

 - Fix issue with daily cron not running

## 7.0 (2022-11-10)

 - Bump minimum WHMCS version to v8.0
 - Add support for PHP 8.1 (minimum now PHP 7.2)

## 6.8 (2022-07-29)

 - Allow setting product codes in Xero
 - Sync Domains as a product
 - Reduce API limit hits

## 6.7 (2022-06-06)

 - Reveal when Xero is blocking connections
 - Add activity log entry when sending invoice email via Xero
 - Add Project Management invoice item group
 - Map add-ons to individual products in Xero

## 6.6 (2022-02-08)

 - Remove description from Items
 - Improve detection of Xero paid invoices with long prefixes

## 6.5 (2021-11-10)

 - Further fixes for Xero disconnections

## 6.4 (2021-11-09)

 - Fix for Xero sometimes disconnecting

## 6.3 (2021-10-21)

 - Allow switching between multiple organisations
 - Fixed disconnect from Xero option
 - Fixed tracking options not applying

## 6.2 (2021-09-27)

 - We are now Xero Certified! You no longer need to create your own App in Xero.
 - We updated our privacy policy https://edgehosting.uk/privacy-policy#w2x
 - Dropped support for PHP 5.6

## 6.1 (2021-09-01)

 - Renamed module to w2x

## 6.0 (2021-08-26)

 - Prepare module for Xero certification

## 5.1 (2021-08-01)

 - Improve handling for transaction fees
 - Improve rate limit prevention logic

## 5.0 (2021-03-17)

 - [Feature] Add option to sync WHMCS Products to Xero Items
 - [Feature] Send admin an email notification when sync fails
 - Set payment method in WHMCS to xero-credit for Xero Credit payments
 - Don't prefix bank fees with invoice numbers (for easier reconciliation)
 - Improve UX

## 4.5 (2021-01-19)

 - Add support for three decimal place tax rules

## 4.4 (2020-12-15)

 - Increase license grace period
 - Don't mark Invoice as sent if not AUTHORISED

## 4.3 (2020-10-20)

 - Add compatability with WHMCS 8

## 4.2 (2020-09-18)

 - Add checks to prevent duplicate bank fees when syncing history twice
 - Fix re-connect to Xero error

## 4.1 (2020-07-28)

 - Improved Xero connection handling

## 4.0 (2020-07-21)

 - Migrated to OAuth 2.0

## 3.5 (2020-05-12)

 - Fixed Xero payments not syncing due to recent changes in Xero API
 - Improved performance of payment sync
 - Improved handling of customer phone numbers

## 3.4 (2020-05-05)

 - Add support for bank fees recorded as a negative figure
 - Don't sync billing contact details to contact record if use billing contact is disabled

## 3.3 (2020-03-17)

 - Add direct cost accounts to list of bank fee options

## 3.2 (2020-01-23)

 - Support for Xero API changes to sending emails

## 3.1 (2019-09-24)

 - Bug fix for bank fees
 - Use native tax_id field

## 3.0 (2019-09-17)

 - Add option to sync transaction fees
 - Add option to append contact ID to names (for uniqueness)

## 2.20 (2019-08-09)

 - Add option to send invoice emails from Xero instead of WHMCS

## 2.19 (2018-12-14)

 - Fixed an issue where WHMCS was creating duplicate payments in Xero when a Xero credit was applied

## 2.18 (2018-11-30)

 - Correctly send telephone country codes to Xero
 - Fix for account codes with .1 and .10 in them
 - Void invoices when fraud check fails

## 2.17 (2018-08-14)

 - Add option to specify branding theme for invoices

## 2.16 (2018-04-23)

 - Use exempt tax rate for late fees when untaxed
 - Fix key pair generation in PHP 7.2

## 2.15 (2018-04-06)

 - Add support for PHP 7.1/7.2 (with latest Ioncube loaders)

## 2.14 (2018-01-22)

 - Don't mark invoices as paid if total is zero

## 2.13 (2018-01-12)

 - Correctly encode quotes and apostrophes

## 2.12 (2017-12-13)

 - Add warning about missing/invalid API username

## 2.11 (2017-11-14)

 - Add option to only sync active contacts to Xero

## 2.10 (2017-11-06)

 - Add to-do item when payment sync fails due to voided Xero invoice
 - Add check for invoice status when updating invoice totals

## 2.9 (2017-09-08)

 - Fixed a bug where the account code was incorrect for some line items

## 2.8 (2017-08-10)

 - Add option to specify sales code for Setup Fees
 - Don't throw exceptions when cron job runs
 - Improved handling of fraud orders

## 2.7 (2017-06-02)

 - Add optional flag to stop invoices being marked as sent
 - Fixed an account code mapping bug in WHMCS 6

## 2.6 (2017-04-27)

 - Add flag to disable update invoice hook
 - Show a warning if mbstring is not enabled

## 2.5 (2017-04-20)

 - Fix for zero value draft invoices
 - Don't increment next invoice to sync when editing an invoice

## 2.4 (2017-04-05)

 - Match Upgrade orders to Xero Account Codes
 - Add Late Fees to product group mappings
 - Improve manual refund notifications

## 2.3 (2017-03-27)

 - [Feature] Update Xero Invoice when Late Fees are applied
 - [Feature] Update Xero Invoice when changes are made in WHMCS
 - Added reminders for manual refunds

## 2.2.0.0 (2017-03-24)

 - [Feature] Reminders to add WHMCS credits and add funds pre-payments to Xero
 - Prevent duplicate payments being sent to Xero
 - Added Overpayment action reminders

## 2.1.0.0 (2017-03-03)

 - [Feature] Ability to modify data being sent to Xero with custom PHP via custom-hook.php
 - Improve handling of multibyte (UTF8) characters

## 2.0.1.3 (2017-03-01)

 - Added support for deleting cancelled DRAFT invoices in Xero
 - Fixed a rounding issue with some Xero payments
 - No longer strips line breaks from line items

## 2.0.1.2 (2017-02-23)

 - Improve matching for Xero to WHMCS payments

## 2.0.1.1 (2017-02-17)

 - Fixed a bug when group line items was enabled
 - Fixed a bug with refunded invoices not syncing future payments

## 2.0.1.0 (2017-02-06)

 - Add custom cron.php

## 2.0.0.3 (2017-01-27)

 - Fixed a bug with Overpayments

## 2.0.0.2 (2017-01-24)

 - Security enhancements
 - Improve module logging
 - Fix part payments not being applied
 - Include "Other Income" in Sales Accounts
 - Include Bank Accounts without a Code

## 2.0.0.1 (2017-01-13)

 - Bugfix for invoice line totals
 - Bypass invalid due dates in WHMCS

## 2.0.0.0 (2017-01-10)

 - Completely refactored module
 - PHP 7 support
 - Unit Tests
 - Alert notifications for new releases
 - Improved error handling
 - Redesigned UI
 - Simplified configuration options
 - Removed taxrates.ini

## 1.9.9.16 (2016-11-03)

 - Now syncs Xero Overpayments and Prepayments to WHMCS

## 1.9.9.15 (2016-10-27)

 - Remove session_start()
 - Remove MySQL encoding settings, now uses default encoding

## 1.9.9.14 (2016-10-07)

 - Set MySQL to UTF8 encoding only during execution
 - Now requires PHP 5.6

## 1.9.9.13 (2016-10-01)

 - Support for WHMCS v7

## 1.9.9.12 (2016-09-26)

 - Implemented rate limiting

## 1.9.9.11 (2016-09-21)

 - Allow empty default account code
 - Add billable items to grouped line items

## 1.9.9.10 (2016-07-26)

  - Try to automatically generate a key/pair when activating module

## 1.9.9.9 (2016-07-21)

 - Fix Xero payments not sending out email confirmations

## 1.9.9.8 (2016-06-21)

 - Add option to specify sales code for Addons

## 1.9.9.7 (2016-05-11)

 - Allow commas in product group names

## 1.9.9.6 (2016-05-05)

 - Add option to group invoice line items by product group

## 1.9.9.5 (2016-02-27)

 - Minor typo

## 1.9.9.4 (2016-02-10)

 - Fix cron & void not always running

## 1.9.9.3 (2016-02-05)

 - Add option to disable WHMCS payment emails

## 1.9.9.2 (2016-02-01)

 - Mark invoices as sent in Xero

## 1.9.9.1 (2016-01-25)

 - Run Xero to WHMCS payment sync before the daily cron

## 1.9.9.0 (2016-01-10)

- Support tax exempt status in WHMCS 6.1

## 1.9.8.5 (2015-12-18)

- Fix bug with bill payments marking sales invoices as paid

## 1.9.8.4 (2015-11-02)

- Reduce query string length for payments
- Allow ampersands in payment references

## 1.9.8.3 (2015-08-28)

- Add CA Bundle

## 1.9.8.2 (2015-07-25)

- Fix bug with inclusive tax setups
- Tested against WHMCS v6

## 1.9.8.1 (2015-04-16)

- Show connection errors when they occur

## 1.9.8.0 (2015-03-17)

- Remove limit flag, send data in batches

## 1.9.7.0 (2015-01-28)

- Add MOSS VAT support

## 1.9.6.4 (2014-11-27)

- Prevent double encoding of quotes

## 1.9.6.3 (2014-11-03)

- Fix calculations bug in Xero Payments sync

## 1.9.6.2 (2014-10-01)

- Allow slash characters in product group names

## 1.9.6.1 (2014-09-18)

- Include credit payments in Xero when syncing
- Add configuration flag to disable use of billing contact name

## 1.9.6.0 (2014-09-09)

- Improved Xero credit note handling

## 1.9.5.1 (2014-08-13)

- Fixed a mass payments bug
- Don't sync payments for cancelled invoices
- Support alphanumeric Xero account codes
- Remove option to specify overpayments account
- Fix problems with XML encoding in specific versions of PHP (supports 5.3.23+)

## 1.9.4.0 (2014-07-15)

- Integrate with WHMCS Module Log for API calls

## 1.9.3.0 (2014-07-01)

- Added support for TaxNumber Field (EC Sales List)
- Added to-do list notification when VOID fails
- Sync full country name, not abbreviation

## 1.9.2.0 (2014-03-24)

- Now uses clients billing contact details where available

## 1.9.0.0 (2013-10-22)

- Added support for part payments in Xero to be synced
- No longer sending full contact data with Invoices when Contact Sync disabled
- Fixed bug where multiple transactions in WHMCS were ignored
- Tracking for WHMCS Payment ID's in Xero to prevent duplicates
- A number of minor bug fixes
- Full support for WHMCS 5.2

## 1.7.0.0 (2013-02-23)

- Add support for UTF8 characters in description (EURO)
- Fix for Xero Ampersand Bug
- Added Customer Redirect Script
- Added additional CurrencyRate Support

## 1.5.1.0 (2012-03-15)

- Updated to support changes made by Xero to API
- Now uses WHMCS Internal API
- Fully Tested in WHMCS v5
- Misc Bug Fixes

## 1.4.0.1 (2012-02-06)

- Tested with WHMCS v5.0.3
- Switch to Internal API

## 1.3.1.0 (2011-08-19)

- Added hook to void cancelled invoices at Xero
- Added option to specify Xero Sales account per Product Group

## 1.3.0.0 (2011-06-28)

- Added Support for Approved Invoices
- Added Tracking Group Integration
- Invoice Synchronization Improvements

## 1.2.0.0 (2011-01-13)

- Added Multi-currency Support
- 2-Way Syncronisation of Invoice Payments
- Support for new WHMCS Add-on System
- Other Core Enhancements

## 1.1.0.0 (2010-05-24)

- Support for Add Funds Invoices (Xero Credit Notes)
- Support for Multiple Invoice Payments in a single transaction
- Improved Cron Integration
- Bux Fixes

## 1.0.0.3 (2010-05-01)

- Integrates with WHMCS Cron Job

## 1.0.0.2 (2010-04-29)

- Bug Fixes
- Support for Tax Inclusive Invoice Lines
- Switched to 'Private' Application Type

## 1.0.0.1 (2010-03-24)

- Initial release
