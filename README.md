# CTC Starter Theme

By Chris Campbell

## About

[CTC Starter Theme](https://github.com/christophertcampbell/ctc-starter-theme) is a fork of the [_s](https://github.com/Automattic/_s) (or <em>underscores</em>) starter theme by [Automattic](https://github.com/Automattic).

The original _s README.md can be [viewed here](README-S.md).

## Changes

CTC Starter Theme includes many changes from the original _s starter theme, including the following:

* Styling for Gutenberg blocks and wide/full-width block alignments
* Improved generic styling, including expanded SASS variables for controlling widths, heights, breakpoints, colors, etc
* Improved mobile menu styling
* Sidebar and non-sidebar page and post templates
* Footer, branding and banner widget areas
* A set of SASS "optionals" for quickly scaffolding basic styling, including:
	* Banner inline
	* Branding inline
	* Menu inline
	* Sticky header
* Scroll detection / custom CSS body classes applied to aid in styling based on amount of browser scroll
* Expand-to-auto-height behavior for mobile sub-menus
* Customizer settings for customizing the footer credits
* Customizer settings for showing new login/login/account/welcome links and text in the header
* Pre-wired "theme-specific" files for consolidating theme-specific css, variables and php code separate from the main starter theme code.

## Development

### Making styling changes

This starter theme uses SASS for CSS development.  Make your changes to the SASS files, and compile to CSS via the following:
1. Open a terminal window to the root directory of the theme
2. To build once: <code>sass sass\style.scss:style.css</code>
3. To build and watch: <code>sass sass\style.scss:style.css --watch</code>

### Enabling or disabling SASS "optionals"

Several SASS "optionals" are provided for quickly scaffolding basic styling.  The optionals are included in the <code>/sass/optionals</code> directory.  To enable or disable individual optionals, comment or un-comment them and re-compile the CSS (see above).

Disable all optionals to start with the most minimalist version for complete customization.

## License

CTC Starter Theme is licensed under the [GNU General Public License v2.0](LICENSE)

## GitHub Repo

https://github.com/christophertcampbell/ctc-starter-theme
