# Idiomas del editor

Los menús y botones del editor se muestran en el idioma del usuario de FacturaScripts. **No hay nada que configurar**: el plugin trae instalados todos los idiomas que FacturaScripts traduce y para los que TinyMCE publica un pack.

En concreto: alemán, castellano (con su variante de México), catalán, checo, euskera, francés, gallego, italiano, polaco, portugués de Portugal, portugués de Brasil y turco. El **inglés** funciona siempre y no necesita archivo, porque sus textos van compilados dentro de la librería y son su idioma por defecto.

Quedan dos casos particulares. Todas las variantes americanas del castellano (`es_AR`, `es_CO`, `es_PE` y demás) se sirven con el castellano general, salvo México que tiene el suyo propio. Y el **valenciano** se sirve en castellano, porque TinyMCE no publica pack de valenciano y el castellano resulta más útil ahí que el inglés.

## Cómo se elige el idioma

Se toma el idioma activo del usuario, por ejemplo `es_ES` o `fr_FR`, y se busca su pack en la carpeta `Langs/` del plugin: primero con el código completo (`fr_FR.js`) y, si no está, con el código corto (`fr.js`). Se usa el primero que exista.

Esa doble búsqueda es la que hace que un solo archivo cubra varias variantes: `ca_ES` se sirve con `ca.js`, `de_DE` con `de.js` y cualquier `es_XX` con `es.js`, mientras que los idiomas cuyo pack sí lleva país, como `fr_FR`, `pt_BR` o `es_MX`, encajan directamente por el código completo. Un usuario en inglés no encuentra ni `en_EN.js` ni `en.js`, y acaba correctamente en el inglés interno de TinyMCE.

## Cómo añadir un idioma que no venga incluido

Solo hace falta si FacturaScripts incorpora un idioma nuevo, o si quieres sustituir un pack por una versión propia.

Los packs no vienen con la librería: la carpeta `node_modules/tinymce/langs` viaja vacía a propósito y hay que descargarlos aparte. Descarga el de tu idioma desde [www.tiny.cloud/get-tiny/language-packages](https://www.tiny.cloud/get-tiny/language-packages) y copia el archivo `.js` en la carpeta `Langs/` del plugin. Ya está: no hay que tocar código ni reiniciar nada, el siguiente formulario que abras lo usará.

**Conserva el nombre original del archivo.** No es cosmético: dentro del pack hay una llamada `tinymce.addI18n("<código>", ...)` y el nombre del archivo tiene que coincidir con ese código, porque es lo que se le pide al editor. Los packs de TinyMCE ya vienen bien nombrados, así que basta con no renombrarlos. Como referencia, el español instalado se llama `es.js` y declara `tinymce.addI18n("es", ...)`.

Si el idioma que necesitas usa un código que no encaja con el de FacturaScripts, puedes duplicar el archivo con el nombre que sí encaje, pero entonces hay que editar dentro el código de `addI18n` para que coincida con el nuevo nombre.

## Al actualizar el plugin

Los idiomas que vienen incluidos se reponen solos con cada actualización, así que no hay que hacer nada.

Los packs que hayas añadido tú viven en esa misma carpeta, así que **una actualización del plugin puede borrarlos**. Guarda una copia y vuelve a copiarlos después de actualizar. Si el idioma es de uso general, dilo y se incluye en el plugin, que es la forma de no tener que reponerlo nunca más.

## Al actualizar TinyMCE

Los packs van por su cuenta y no se actualizan con la librería, así que al saltar a una versión mayor de TinyMCE hay que volver a descargarlos todos y sustituirlos, o quedarán desfasados respecto a las opciones nuevas del editor.
