# Presentación de Widget RichText

El plugin **Widget RichText** permite definir columnas utilizando un nuevo tipo de widget llamado **richtext**. Con él, podrás introducir y formatear texto en la columna con las siguientes características:

- **Formato de texto**: Aplica negritas, cursivas, diferentes tipos y tamaños de fuente, y colores.
- **Formato de párrafo**: Ofrece opciones de alineación (izquierda, centrado o derecha), cabeceras y listas (numeradas o con viñetas).
- **Herramientas avanzadas**: Permite definir referencias, añadir enlaces y citar texto.

En resumen, este widget transforma el área de edición en un pequeño editor de texto avanzado.

## ⚙️ Cómo definir la columna

Para utilizar el plugin, es necesario configurar la columna como tipo **richtext**. Asegúrate de que el campo correspondiente en la base de datos sea de tipo `text`. Además, puedes especificar el número de filas (alto) que deseas emplear en el editor de texto.

Ejemplo en XML:

```xml
<column name="instructions" title="" numcolumns="12" order="200">
    <widget type="richtext" fieldname="instructions" rows="10" />
</column>
```

## 🖼️ Ejemplo de visualización

A continuación, un ejemplo de cómo se visualizará el widget:

![Ejemplo de Widget RichText](https://i.ibb.co/5TfccrV/Widget-Rich-Text-example1.png)

## 📌 Ejemplos adicionales

Para integrar el widget en diferentes contextos, considera los siguientes casos de uso:

1. **Notas de producto**: Agrega una breve descripción del producto con formato enriquecido para destacar características importantes.
2. **Instrucciones para el usuario**: Proporciona información detallada sobre el uso correcto de una función o producto.
3. **Reseñas y comentarios**: Permite a los usuarios escribir reseñas con opciones de formato, mejorando la legibilidad de las opiniones.

Estos ejemplos te ayudarán a personalizar y aprovechar al máximo las capacidades del Widget RichText en FacturaScripts.

## Licencia

El plugin es LGPL-3.0 e incorpora TinyMCE community bajo GPL-2.0-or-later. Los detalles y la atribución están en el `README.md`.
