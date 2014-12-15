/**
 * This file is part of Vegas package
 *
 * @author Frank Broersen <fbroersen@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

var browserElement;

$(document).ready(function() {
    var config = {
        filebrowserBrowseUrl: '/assets/html/ui/elbrowser.html',
        filebrowserWindowWidth: '740',
        filebrowserWindowHeight: '410'
    };

    var render = function() {
        $('.btn-browse').click(function(){
            browserElement = $(this).parents('.browser-wrapper');
            window.open(config.filebrowserBrowseUrl,'vegas-browser','left=100, top=100, width=' + config.filebrowserWindowWidth + ',height=' + config.filebrowserWindowHeight);
        });
    }

    render();

    $('[vegas-cloneable]').on('cloned', function() {
        render();
    });
});

function browserCallback(file) {
    browserElement.find('input').val(file);
};