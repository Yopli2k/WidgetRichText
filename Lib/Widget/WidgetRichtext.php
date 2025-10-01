<?php
/**
 * This file is part of WidgetRichText plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * WidgetRichText Copyright (C) 2024-2024 Jose Antonio Cuello Principal <yopli2000@gmail.com>
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
     * Return the HTML code for the textual representation.
     *
     * @return string
     */
    protected function show(): string
    {
        return is_null($this->value) ? '-' : '<i class="fa-regular fa-rectangle-list"></i>';
    }
}
