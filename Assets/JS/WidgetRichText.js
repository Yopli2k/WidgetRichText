/**
 * This file is part of WidgetRichText plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2024 Carlos Garcia Gomez <carlos@facturascripts.com>
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

'use strict';

/**
 * Main process.
 *  - init tinymce editor.
 */
window.onload = function () {
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    tinymce.init({
        selector: '.widget-tinymce',
        plugins: 'print preview paste importcss searchreplace autolink save code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable quickbars emoticons',
        license_key: 'gpl',
        promotion: false,
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        menubar: 'file edit view insert format tools table',
        toolbar: "fullscreen preview print | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor removeformat | align numlist bullist | link image | table media | lineheight outdent indent| charmap emoticons | code | pagebreak anchor",
        language: 'es',
    });
};
