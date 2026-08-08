# Arquitectura

El plugin es deliberadamente pequeño: una clase de widget, un archivo JavaScript y la librería. Todo lo demás lo pone FacturaScripts.

## Las piezas

`Lib/Widget/WidgetRichtext.php` extiende `WidgetTextarea` del núcleo. Hereda de él la emisión del `<textarea>` y el tratamiento de `rows`, y solo añade cuatro cosas: la clase CSS `widget-tinymce` que marca el elemento, la carga de los assets, los atributos `data-*` que configuran el editor y un `show()` que devuelve un icono en lugar del contenido.

`Assets/JS/WidgetRichText.js` busca los elementos marcados y arranca un editor sobre cada uno.

`node_modules/tinymce` es la librería, que **viaja versionada dentro del repositorio**.

## Por qué la clase se llama WidgetRichtext y no WidgetRichText

Es el detalle que más despista de todo el plugin, porque parece una errata. El nombre de la clase no lo elige el plugin: lo deduce FacturaScripts del atributo `type` del XMLView, componiéndolo como `'Widget' . ucfirst($type)` en `ColumnItem::loadWidget()`. Con `type="richtext"`, la clase que se busca es exactamente `WidgetRichtext`, con la `t` minúscula, y el archivo tiene que llamarse igual.

De ahí también que el `type` haya que escribirlo en minúsculas en el XML. Si no se encuentra la clase, el núcleo no da error: cae silenciosamente al widget de texto normal, y lo que se ve es un área de texto plano donde esperabas un editor.

La clase vive en `Lib/Widget/` y se localiza a través de `Dinamic`, como el resto de clases extensibles del framework.

## El contrato entre PHP y JavaScript

Toda la configuración que depende de la vista o de la instalación se pasa en atributos `data-*` del `<textarea>`, y el JavaScript los lee al inicializar cada editor. Son tres.

`data-height` lleva la medida CSS declarada en el XMLView, ya filtrada. El filtro descarta por completo cualquier valor que no encaje en el patrón de una medida CSS, porque ese valor acaba aplicándose como estilo y no conviene que un XMLView de terceros pueda colar ahí lo que quiera.

`data-rows` solo se emite **si el XMLView declaró `rows`**. Esta distinción es necesaria porque `WidgetTextarea` siempre pone un `rows` en el HTML, con un valor por defecto de 3, así que el JavaScript no puede mirar el atributo `rows` del elemento para saber si el programador pidió algo: le constaría un `rows="3"` que nadie escribió y el editor mediría 192 píxeles en lugar de los 250 previstos.

`data-language` y `data-language-url` llevan el pack de idioma que corresponde al usuario y la URL desde la que servirlo, con el prefijo de la instalación ya puesto. Los emite PHP por dos motivos: es el único lado que conoce la ruta base configurada, y es el único que puede mirar en disco qué packs hay instalados. Cuando no hay pack para el idioma del usuario **no se emite ninguno de los dos**, el JavaScript no toca esas opciones y el editor usa el inglés que TinyMCE lleva compilado, que es su valor por defecto. La resolución del pack está en `findLanguage()` y se explica desde el punto de vista de uso en [04-idiomas.md](04-idiomas.md).

Antes de la versión 2.02 el idioma estaba fijo a español y la URL escrita a mano desde la raíz del dominio, lo que además dejaba el editor en inglés en cualquier instalación colgada de una subcarpeta.

## Un editor por elemento

El JavaScript recorre los elementos y llama a `tinymce.init()` una vez por cada uno, pasándole `target`. La alternativa evidente sería una sola llamada con `selector`, más corta, pero entonces todos los editores de la página compartirían configuración y no habría manera de darle a cada uno su altura: `height` es una opción de la llamada, no del elemento.

El arranque se engancha con `addEventListener('load', ...)`. No uses `window.onload = ...` aquí: es una asignación, no un registro, y machaca cualquier manejador que hubieran puesto la página o los demás plugins.

## Actualizar TinyMCE

La librería está en el repositorio, así que actualizarla es `npm install` y commitear el resultado. `.gitignore` ignora todo `node_modules` salvo `node_modules/tinymce`, con el par de reglas `/node_modules/*` y `!/node_modules/tinymce/`; el orden importa, porque si se ignorase el directorio entero git no descendería a él y la excepción no llegaría a aplicarse.

Al saltar de versión mayor conviene revisar tres cosas. Que la opción `license_key: 'gpl'` siga siendo la forma de declarar la edición community. Que la opción `height` siga aceptando cadenas y no solo números, que es lo que permite los `vh` y los `calc()`; hoy la acepta porque el tema la registra con un procesador de número o cadena y valida la medida contra un elemento real. Y que la lista de `plugins` y de botones del `toolbar` no haya perdido ninguno por el camino.

Y hay que recordar actualizar también los packs de `Langs/`, que son las traducciones de la interfaz del editor, van aparte de la librería y se descargan de su propia página.

## Limitaciones conocidas

**Los packs de idioma se actualizan aparte de la librería.** Vienen incluidos los trece idiomas que FacturaScripts traduce y TinyMCE publica, pero no viajan dentro de TinyMCE ni se actualizan con él, así que al saltar de versión mayor hay que rebajarlos y sustituirlos a mano. Los detalles están en [04-idiomas.md](04-idiomas.md).

**El tema claro u oscuro lo decide el navegador, no FacturaScripts.** La skin se elige consultando `prefers-color-scheme`, la preferencia del sistema operativo, y no el tema que el usuario tenga configurado en FacturaScripts. Si alguien usa FacturaScripts en claro con el sistema en oscuro, o al revés, el editor desentonará.

**No hay integración con los archivos adjuntos.** Las imágenes se acaban incrustando en el propio campo en base64, como se explica en [03-guardar-y-mostrar-el-contenido.md](03-guardar-y-mostrar-el-contenido.md).

**No hay nada configurable desde el panel de control.** La barra de herramientas, los plugins de TinyMCE activos y el resto de opciones están escritos en el JavaScript; cambiarlos es tocar el archivo.
