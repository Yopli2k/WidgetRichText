# Alto del editor

El editor mide **250 píxeles** si no se dice otra cosa. Para cambiarlo hay dos atributos, y se declara uno u otro según lo que necesites.

## rows, la medida cómoda

`rows` indica el número de líneas, igual que en el widget `textarea` del núcleo:

```xml
<widget type="richtext" fieldname="body" rows="12" />
```

Cada línea cuenta como 24 píxeles y se suman 120 más para el hueco del menú y la barra de herramientas, así que un `rows="12"` da 408 píxeles. Es una aproximación deliberada: sirve para pedir "un editor de unas doce líneas" sin pelearse con números exactos.

## height, el control fino

`height` admite **cualquier medida CSS válida**, no solo píxeles:

```xml
<widget type="richtext" fieldname="body" height="600" />
<widget type="richtext" fieldname="body" height="60vh" />
<widget type="richtext" fieldname="body" height="calc(100vh - 300px)" />
```

Un número pelado se interpreta como píxeles. Todo lo demás se aplica tal cual, así que valen `vh`, `%`, `em` o un `calc()`.

El caso real que justifica admitir medidas relativas es `LawFirm/XMLView/EditEngagementSection.xml`, donde las secciones de un contrato se editan en un modal que en tablet ocupa la pantalla entera: una medida en píxeles se quedaría corta o se saldría según el dispositivo, mientras que `calc(100vh - 300px)` se adapta.

## Cuál manda

`height` gana sobre `rows`. Declarar los dos no aporta nada, porque el `rows` quedaría ignorado para el alto del editor; su único efecto residual sería gobernar el `<textarea>` en el caso de que TinyMCE no llegara a cargar.

Sin ninguno de los dos, 250 píxeles.

## Detalles que conviene saber

**Cada editor tiene su propio alto.** Si una vista tiene dos o más campos `richtext`, cada uno respeta lo que declare su columna. Esto no siempre fue así: antes de la versión 2.02 toda la página compartía una única altura.

**Una medida inválida no rompe la página, pero tampoco avisa.** El plugin descarta antes de tiempo cualquier valor que ni siquiera parezca una medida CSS, y en ese caso el editor vuelve a los 250 píxeles. Si el valor tiene pinta de medida pero no lo es, es TinyMCE quien lo rechaza y planta el editor en 400 píxeles, que es su propio valor de reserva. Un editor de 400 píxeles que no habías pedido suele significar que hay una errata en el `height`.

**Ojo con los altos relativos en ventanas bajas.** Un `100vh` en una pantalla pequeña deja un área de escritura ridícula. No hay ningún alto mínimo puesto por el plugin, precisamente para no contradecir a quien pide un `rows` pequeño a propósito, así que el ajuste es cosa tuya.

**Dentro de un modal de Bootstrap conviene probarlo.** TinyMCE se inicializa con el contenedor todavía oculto y en algunas combinaciones calcula mal la altura del iframe.
