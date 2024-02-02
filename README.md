# TTRSS_Allow_Styles

> Tiny Tiny RSS Plugin to allow style attributes on an individual feed

## Example:

Without this plugin,
```html
<div style="color: black"></div>
```
in the item description will normally be stripped down to
```html
<div></div>
```
With this plugin, you can select feeds where `style="color: black"` is kept.

Works with the official Android app.

## Installation:

1. Place whole `ttrss_allow_styles` folder under `ttrss/plugins.local/`.
2. Enable under `Preferences -> Plugins`

## Usage:

1. `Edit feed` and head to the `Styles` section under the `Plugins` tab.
2. Enable the checkbox `Allow 'styles' attribute in feed items`.
3. Save.

## Available for Hire

I'm available for freelance, contracts, and consulting both remotely and in the Hudson Valley, NY (USA) area. [Some more about me](https://www.zweisolutions.com/about.html) and [what I can do for you](https://www.zweisolutions.com/services.html).

Feel free to drop me a message at:

```
hi [a+] zweisolutions {●} com
```

## License

[MIT](./LICENSE)