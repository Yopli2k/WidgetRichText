# Changelog

Todos los cambios notables en este proyecto se documentarán en este archivo.

## [2.03] - 2026-09-15

### Nuevas funcionalidades y mejoras
- Subido el requisito mínimo de FacturaScripts a 2026.5.

## [2.02] - 2026-08-08

### Nuevas funcionalidades y mejoras

- Actualizada librería Tinymce a la versión 7.9
- El alto del editor se configura desde el XMLView, en lugar de los 250 píxeles fijos de antes. Con `rows` se indica el número de líneas, igual que en el widget textarea del núcleo, y con `height` cualquier medida CSS válida (`600`, `100vh`, `calc(100vh - 300px)`) cuando hace falta un control más fino. Si se declaran los dos manda `height`, y si no se declara ninguno el editor sigue midiendo 250 píxeles.
- Cada editor de la página se inicializa por separado, así que dos o más campos de texto enriquecido en la misma vista pueden tener alturas distintas. Antes toda la página compartía una única altura.
- Aviso para quien ya usaba el widget: las vistas que declaraban `rows` en un campo de texto enriquecido pasan a respetarlo y cambian de alto, porque hasta ahora se ignoraba.
- Los menús y botones del editor siguen ahora el idioma del usuario de FacturaScripts, y ya no están fijos en español. Se incluyen alemán, castellano (con su variante de México), catalán, checo, euskera, francés, gallego, italiano, polaco, portugués de Portugal, portugués de Brasil y turco, además del inglés que el editor ya traía. Las variantes americanas del castellano usan el castellano general, y el valenciano también, al no publicar TinyMCE un pack propio.

## Correcciones de errores

- El plugin registraba su arranque con `window.onload`, que anulaba cualquier otro código que la página o el resto de plugins hubieran preparado para ejecutarse al terminar de cargar.
- En las instalaciones de FacturaScripts que cuelgan de una subcarpeta, los menús y botones del editor salían en inglés, porque el archivo de idioma se pedía siempre desde la raíz del dominio y no se llegaba a encontrar.
