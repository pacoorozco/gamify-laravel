/**
 * Main JS application file for Gamify. This file
 * should be included in all pages. It controls some layout
 * options.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @category   Pakus
 * @package    Gamify JavaScript
 * @author     Paco Orozco <paco_@_pacoorozco.info>
 * @license    http://www.gnu.org/licenses/gpl-2.0.html (GPL v2)
 * @link       https://github.com/pacoorozco/gamify-l5
 */

Gamify = {
    init: function () {
        $(document).on('click', '.btn-add', function (event) {
            event.preventDefault();

            var field = $(this).closest('.cloneable');
            var field_new = field.clone();

            $(this)
                .toggleClass('btn-default')
                .toggleClass('btn-add')
                .toggleClass('btn-danger')
                .toggleClass('btn-remove')
                .html('<i class="fa fa-minus"></i>');

            field_new.find('input').val('');
            field_new.insertAfter(field);
        });

        $(document).on('click', '.btn-remove', function (event) {
            event.preventDefault();
            $(this).closest('.cloneable').remove();
        });

        $(function () {
            $(".tags-input").select2({
                tags: true,
                placeholder: 'Put your tags here',
                tokenSeparators: [','],
                allowClear: true,
                theme: "bootstrap",
                matcher: function (params, data) {
                    // If there are no search terms, return all of the data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // `params.term` should be the term that is used for searching
                    // `data.text` is the text that is displayed for the data object
                    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                        return data;
                    }

                    // Return `null` if the term should not be displayed
                    return null;
                },
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === "") {
                        return null;
                    }

                    var optionsMatch = false;

                    this.$element.find("option").each(function () {
                        if (this.value.toLowerCase().indexOf(term.toLowerCase()) > -1) {
                            optionsMatch = true;
                        }
                    });

                    if (optionsMatch) {
                        return null;
                    }
                    return {id: term, text: term};
                }
            });
        });

        tinymce.init({
            selector: "textarea.tinymce",
            width: '100%',
            height: 270,
            statusbar: false,
            menubar: false,
            plugins: [
                "link",
                "code"
            ],
            toolbar: "bold italic underline strikethrough | removeformat | undo redo | bullist numlist | link code"
        });
    }
};

