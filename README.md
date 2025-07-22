# Starter mu-plugins

This is my starting point for the `mu-plugins` folder. It pairs nicely with [my hybrid starter theme](https://github.com/mrwweb/hybrid-starter-theme).

It includes modifications of core WordPress along with configuration changes to specific plugins.

## Core Functions Changes

- Turn off and hide comments
- Reorder and cleanup admin menu and admin bar
- Style the login screen and change links to go to homepage rather that wordpress.org
- Notify me of site errors rather than Admin Email
- Automatic feed links
- Set `DISALLOW_FILE_EDIT` to true
- [email] shortcode for obfuscating email addresses and making email links with pre-filled subjects
- Enqueue a stylesheet for adding CSS to the admin
- Add Featured Image and Excerpt support to Pages
- Add Announcement Banner feature (depends on ACF)

## Plugin Configuration

- Advanced Custom Fields PRO - Stores JSON fields in /mu-plugins/acf-json/ and loads them from there.
- The Events Calendar - Numerous changes to default behavior and templates. This is a copy of my [TEC resets](https://github.com/mrwweb/the-events-calendar-reset/blob/main/mu-plugins/tec-customizations.php)
- WP-CFM - Stores and loads settings JSON files from /mu-plugins/wp-cfm-json/
- Archived Post Status - Hides archived posts from default post list

### WP-CFM Starter Settings

- Core
- Yoast SEO - Including if The Events Calendar, Content Audit, and WooCommerce are installed
- Editoria11y - Helpful default elements and pages to ignore
