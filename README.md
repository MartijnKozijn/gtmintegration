
# GTM Integration Module for PrestaShop

This PrestaShop module allows you to easily integrate Google Tag Manager (GTM) into your PrestaShop site. The module handles the placement of GTM tags in the correct positions, so you only need to input your GTM ID in the backoffice.

## Features

- Easy installation and configuration
- Automatically inserts GTM tags in the correct positions (header and footer)
- Compatible with PrestaShop 8.1.7

## Installation

1. Download the module as a `.zip` file.
2. Go to your PrestaShop backoffice.
3. Navigate to `Modules` -> `Module Manager`.
4. Click `Upload a module` and upload the `.zip` file.
5. Once uploaded, click `Install`.
6. After installation, go to the module configuration page and enter your GTM Container ID.

## Configuration

1. In the backoffice, navigate to `Modules` -> `Module Manager`.
2. Find the "GTM Integration" module and click `Configure`.
3. Enter your GTM Container ID (e.g., `GTM-XXXXXXX`).
4. Save your settings.

## File Structure

```bash
gtmintegration/
├── gtmintegration.php
├── config.xml
└── views/
    └── templates/
        └── hook/
            ├── header.tpl
            └── footer.tpl
```

## Compatibility

- PrestaShop 8.1.7 or higher

## Author

- **Jaymian-Lee Reinartz**

## License

This module is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
