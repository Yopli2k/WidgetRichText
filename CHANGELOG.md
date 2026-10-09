# Changelog

All significant changes to this project will be documented in this file.

## [2.03] - 2026-09-15

### New Features and Improvements
- Upgraded the minimum FacturaScripts requirement to 2026.5.

## [2.02] - 2026-08-08

### New Features and Improvements

- Update the TinyMCE library to version 7.9
- The editor height is now set from the XMLView, instead of the fixed 250 pixels of before. Use `rows` for the number of lines, just like the core textarea widget, or `height` for any valid CSS measure (`600`, `100vh`, `calc(100vh - 300px)`) when finer control is needed. If both are declared `height` wins, and if neither is declared the editor still measures 250 pixels.
- Each editor on the page is initialized on its own, so two or more rich text fields on the same view can have different heights. Before, the whole page shared a single height.
- Notice for those already using the widget: views declaring `rows` on a rich text field now honor it and change their height, since until now it was ignored.
- The editor menus and buttons now follow the FacturaScripts user language, instead of being fixed to Spanish. Basque, Catalan, Czech, French, Galician, German, Italian, Polish, Portuguese (Portugal and Brazil), Spanish (with its Mexican variant) and Turkish are now included, on top of the English the editor already had. The American variants of Spanish use general Spanish, and so does Valencian, since TinyMCE publishes no pack of its own for it.

## Bug fixes

- The plugin registered its startup with `window.onload`, which wiped out any other code the page or other plugins had set to run once loading finished.
- On FacturaScripts installations hanging from a subfolder, the editor menus and buttons showed up in English, because the language file was always requested from the domain root and could not be found.
