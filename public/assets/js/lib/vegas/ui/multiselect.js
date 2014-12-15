/**
 * This file is part of Vegas package
 *
 * @author Jaroslaw Macko <jarek@amsterdam-standard.pl> 
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(document).ready(function () {
    $('[data-vegas-multiselect]').each(function() {
        id = $(this).attr('id');

        $(this).multiSelect({
            selectableHeader: '<div class="custom-header">Avaiable items <a href="#" class="ms-add-all">Select all</a></div>',
            selectionHeader: '<div class="custom-header">Selected items <a href="#" class="ms-remove-all">Remove all</a></div>',
        });

        $(document).on('click', '.ms-add-all', function(e) {
            e.preventDefault();
            $(this).closest('.ms-container').prev().multiSelect('select_all');
        });

        $(document).on('click', '.ms-remove-all', function(e) {
            e.preventDefault();
            $(this).closest('.ms-container').prev().multiSelect('deselect_all');
        });
    });
});
