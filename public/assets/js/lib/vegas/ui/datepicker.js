/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <arkadiusz.ostrycharz@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
$(document).ready(function() {
    var render = function(){
        $('[vegas-datepicker]').datetimepicker({
            pickTime: false,
            format: 'YYYY-MM-DD'
        });
    };

    render();

    $('[vegas-cloneable]').on('cloned', function() {
        render();
    });
});
