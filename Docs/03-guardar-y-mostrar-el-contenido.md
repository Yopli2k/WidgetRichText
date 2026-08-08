# Guardar y mostrar el contenido

Lo que el widget guarda no es texto, es HTML. Eso condiciona cómo se almacena y cómo se muestra, y el mecanismo no es evidente a primera vista, así que merece la pena entenderlo antes de usar el widget en un modelo propio.

## Tu modelo tiene que aplicar Tools::noHtml

En el `test()` del modelo, el campo del editor se trata como cualquier otro campo de texto:

```php
public function test(): bool
{
    $this->body = Tools::noHtml($this->body);

    return parent::test();
}
```

`Tools::noHtml()` sustituye `<`, `>`, `"` y `'` por sus entidades, así que en la base de datos no se guarda `<p>hola</p>` sino `&lt;p&gt;hola&lt;/p&gt;`.

**Esto no es opcional y no es solo cuestión de limpieza.** Al pintar el formulario, el contenido se vuelca dentro de un `<textarea>`. Si lo guardado fuese HTML crudo, bastaría con que el usuario escribiera un `</textarea>` en el editor para cerrar la etiqueta antes de tiempo e inyectar marcado en la página. El escapado es lo que lo impide.

## Y aun así el editor recibe HTML correcto

Puede parecer que escapar el contenido rompe el editor, y no es así, porque el navegador deshace las entidades al interpretar el interior del `<textarea>`. El recorrido completo es este:

En la base de datos está `&lt;p&gt;hola&lt;/p&gt;`, el widget lo vuelca tal cual dentro del `<textarea>`, el navegador lo interpreta y el valor real del campo pasa a ser `<p>hola</p>`, y TinyMCE arranca sobre ese valor y muestra un párrafo con la palabra hola. Al guardar, el navegador envía otra vez `<p>hola</p>`, el modelo lo vuelve a escapar y se cierra el círculo.

No hay que hacer nada para que esto funcione: hay que **no** estropearlo, es decir, no desescapar el valor antes de que llegue al widget.

## Para mostrarlo fuera del formulario

Ahí sí hay que deshacer el escapado a mano, con `Tools::fixHtml()`, que es la operación inversa. En una plantilla Twig:

```twig
<td class="col-desc">{{ fixHtml(visit.name)|raw }}</td>
```

El `|raw` es imprescindible: sin él, Twig volvería a escapar el HTML y el usuario vería las etiquetas escritas en pantalla. Y en PHP, cuando compones HTML a mano:

```php
$html .= '<td class="description">' . Tools::fixHtml($visit->name) . '</td>';
```

Como esto vuelca en la página HTML escrito por el usuario, aplícalo solo a contenido introducido por usuarios en los que confías. Es el mismo criterio que con cualquier campo que se pinte con `|raw`.

En los listados no hace falta hacer nada: el widget muestra un icono en la celda en lugar del contenido, precisamente para no volcar HTML dentro de una tabla.

## El contenido crece, y las imágenes mucho

Un texto con formato ocupa bastante más que el texto pelado, de ahí que el campo de la tabla tenga que ser `text` y no un `varchar`.

Con las imágenes hay que ir con cuidado. El plugin no configura ningún destino de subida, y TinyMCE viene de fábrica aceptando imágenes pegadas, así que **lo que se pega o se arrastra al editor acaba incrustado en el propio campo** codificado en base64, en lugar de guardarse como archivo. Una captura de pantalla puede convertir una fila de unos pocos kilobytes en una de varios megabytes, y eso se paga en cada consulta que lea ese campo. Si el caso de uso va a llevar imágenes de forma habitual, lo razonable es guardarlas aparte, con los archivos adjuntos de FacturaScripts, e insertarlas en el editor por su URL.
