# Software Licensing Demo for Mindspun Payments

This repo contains a sample WordPress plugin to demonstrate how to add software licensing to your plugin.
It is meant to be used with the 'WordPress Repository' and 'Software Licensing' add-ons for Mindspun Payments.

## Overview
Plugin updates are done using the [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) library.

For simplicity, the plugin-update-checker (version 5.4) is included in this repo, but you likely want to get the most recent version.

## Getting Started
Point the PUC library to your Repo and pass your license key as a header.

```shell
PucFactory::buildUpdateChecker(
    REPO_DEMO_URL
    __FILE__,
    REPO_DEMO_SLUG
);
```

Replace REPO_DEMO_URL and REPO_DEMO_SLUG with the URL and slug of your plugin, respectively.

## Building
Using a unix-style terminal, you can build the plugin zip file by:
```shell
make
```

Otherwise, you can zip the files manually as you would for any other plugin.

To easily create other versions for testing upgrades, run make and pass it a version number, e.g.
```shell
make 1.0.1
```

## Testing/Debugging
You can validate the setup manually by testing the two network calls required for an update.

The first GET request checks for the most recent version of the plugin.  For instance:

```shell
http://localhost/wp-json/mindspun/payments/v1/repo/repo-demo?key=SLM-A010E-2EE29-A9C74-1D40E-3A84E-FEE40-3C
```

Where 'repo-demo' is the slug of your plugin or theme, and 'key' is a valid license key you created with the SLM plugin.

If it's successful, you'll get a JSON response like the following:
```json
{
    "name": "Repo Demo",
    "description": "Demo plugin for Software Licensing with Mindspun Payments",
    "version": "1.0.0",
    "last_updated": "2024-04-18 +2024",
    "download_url": "http://localhost/wp-json/mindspun/payments/v1/repo/zip_662196be1a33364423086072/repo-demo-1.0.1.zip?key=XXX"
}
```

The important property is `download_url`.  That property has a link that will download the zip bundle.
