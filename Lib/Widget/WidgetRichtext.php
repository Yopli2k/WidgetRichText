<?php
/**
 * This file is part of WidgetRichText plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2026 Carlos Garcia Gomez <carlos@facturascripts.com>
 * WidgetRichText Copyright (C) 2024-2026 Jose Antonio Cuello Principal <yopli2000@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace FacturaScripts\Plugins\WidgetRichText\Lib\Widget;

use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Lib\AssetManager;
use FacturaScripts\Dinamic\Lib\Widget\WidgetTextarea;

/**
 * Add a TinyMCE editor to the textarea.
 *
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
 */
class WidgetRichtext extends WidgetTextarea
{
    /**
     * Editor height, as any valid CSS measure.
     *
     * @var string
     */
    protected $height;

    /**
     * Indicates if rows was set on the XMLView, to tell it from the parent default.
     *
     * @var bool
     */
    protected $rowsDefined;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->height = $this->fixHeight($data['height'] ?? '');
        $this->rowsDefined = isset($data['rows']);
    }

    /**
     * Add the necessary assets for the widget.
     *
     * @return void
     */
    protected function assets(): void
    {
        $route = Tools::config('route');
        AssetManager::addJs($route . '/Plugins/WidgetRichText/node_modules/tinymce/tinymce.min.js');
        AssetManager::addJs($route . '/Dinamic/Assets/JS/WidgetRichText.js');
    }

    /**
     * Return the HTML code for the input form.
     *
     * @param string $type
     * @param string $extraClass
     * @return string
     */
    protected function inputHtml($type = 'text', $extraClass = 'widget-tinymce'): string
    {
        return parent::inputHtml($type, $extraClass);
    }

    /**
     * Add the height and rows requested on the XMLView, so the editor can size itself,
     * and the language pack, that only php can resolve.
     *
     * @return string
     */
    protected function inputHtmlExtraParams(): string
    {
        $params = parent::inputHtmlExtraParams();
        if (false === empty($this->height)) {
            $params .= ' data-height="' . $this->height . '"';
        }
        if ($this->rowsDefined) {
            $params .= ' data-rows="' . $this->rows . '"';
        }

        // sin pack para el idioma del usuario no se emite nada, y el editor usa su inglés interno
        $language = $this->findLanguage();
        if (false === empty($language)) {
            $params .= ' data-language="' . $language . '"'
                . ' data-language-url="' . Tools::config('route') . '/Plugins/WidgetRichText/Langs/' . $language . '.js"';
        }

        return $params;
    }

    /**
     * Return the HTML code for the textual representation.
     *
     * @return string
     */
    protected function show(): string
    {
        return is_null($this->value) ? '-' : '<i class="fa-regular fa-rectangle-list"></i>';
    }

    /**
     * Return the language pack code for the user language, empty when there is none.
     * The full code is tried first, then the short one, so es.js serves every es_XX.
     *
     * @return string
     */
    private function findLanguage(): string
    {
        $lang = Tools::lang()->getLang();

        // el valenciano no tiene pack en TinyMCE, y el castellano le sirve mejor que el inglés
        if ($lang === 'va_ES') {
            $lang = 'es_ES';
        }

        foreach ([$lang, substr($lang, 0, 2)] as $code) {
            if (file_exists(Tools::folder('Plugins', 'WidgetRichText', 'Langs', $code . '.js'))) {
                return $code;
            }
        }

        return '';
    }

    /**
     * Discard anything that can not be a CSS measure, as it ends up on a style.
     *
     * @param string $height
     * @return string
     */
    private function fixHeight(string $height): string
    {
        return preg_match('/^[0-9a-z().,%+\-* \/]+$/i', $height) ? $height : '';
    }
}
