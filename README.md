# GTM Integration Module for PrestaShop

## Overview

The `gtmintegration` module allows you to seamlessly integrate Google Tag Manager (GTM) into your PrestaShop website. This module automatically inserts the necessary GTM scripts into the correct places within your website's `<head>` and `<body>` tags, ensuring that GTM functions correctly across all pages without requiring manual code edits.

## Features

- Easy-to-use configuration from the PrestaShop backoffice.
- Automatically inserts GTM scripts into the correct parts of your website.
- No need for manual code editing or template modification.
- Supports encoding and decoding of GTM scripts to handle special characters.
- Compatible with PrestaShop versions 1.6 and above.

## Installation

1. **Download or Clone the Repository:**
   - Download the module files or clone the repository to your local machine.

2. **Upload the Module:**
   - Upload the `gtmintegration` folder to your PrestaShop installation’s `modules` directory.

3. **Install the Module:**
   - Go to your PrestaShop backoffice.
   - Navigate to `Modules > Module Manager`.
   - Search for "GTM Integration" and click `Install`.

4. **Configure the Module:**
   - After installation, click `Configure` to add your GTM codes.
   - Enter the GTM code for the `<head>` section and the `<body>` section in the provided fields.
   - Click `Save` to apply the settings.

## Folder Structure

The module follows the below folder structure:

```
gtmintegration/
├── gtmintegration.php
├── views/
│   └── templates/
│       └── hook/
│           ├── header.tpl
│           └── body.tpl
```

- **gtmintegration.php:** Main PHP file that contains the module logic.
- **views/templates/hook/header.tpl:** Template file for inserting GTM code into the `<head>` section.
- **views/templates/hook/body.tpl:** Template file for inserting GTM code after the opening `<body>` tag.

## Usage

1. **Adding GTM Codes:**
   - After configuring the module, the GTM scripts will be automatically inserted into the correct sections of your website's HTML.

2. **Verifying Installation:**
   - Use the Google Tag Assistant Chrome extension to verify that your GTM tags are correctly installed and functioning.

3. **Debugging:**
   - If the GTM tags are not detected, clear your PrestaShop cache and browser cache, then refresh your site.

## Uninstallation

1. **Uninstall via Backoffice:**
   - Go to `Modules > Module Manager`.
   - Locate "GTM Integration" and click `Uninstall`.

2. **Manual Removal:**
   - If you prefer to remove the module manually, delete the `gtmintegration` folder from the `modules` directory in your PrestaShop installation.

## Troubleshooting

- **GTM Scripts Not Detected:**
  - Ensure that caching is disabled or cleared in both PrestaShop and your browser.
  - Verify that your GTM ID is correct.
  - Check that your theme supports the `header` and `displayAfterBodyOpeningTag` hooks.

- **GTM Code Visible on Frontend:**
  - Ensure that the GTM code is correctly placed in the Smarty templates and not directly outputted to the frontend.

## License

This module is open-source and free to use. You can modify and distribute it under the terms of the MIT License.

## Support

For support, questions, or feedback, please contact the module author or raise an issue on the repository.