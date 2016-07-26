jQuery.expr[':'].between = function (a, b, c) {
    var args = c[3].split(',');
    var val = parseInt(jQuery(a).data('original'));
    return val >= parseInt(args[0]) && val <= parseInt(args[1]);
};
$(document).ready(function () {
    /* Log the original value to a custom dataibute */
    $('.reorder').on('backup', function () {
        $(this).find('input.reorderable').each(function () {
            $(this).data('original', $(this).val());
        })
    }).trigger('backup').tablesorter({
            	textExtraction:{
                    '.ordered': function(node, table, cellIndex){ return $(node).children("input").val(); }
            	}
            });

    $('.reorder input.reorderable').change(function () {
        var $vNew = parseInt($(this).val());
        var $vOriginal = parseInt($(this).data('original'));
        var $x = ($vOriginal < $vNew ? $vOriginal : $vNew);
        var $y = ($vOriginal < $vNew ? $vNew : $vOriginal);
        $(this)
                .parents('.reorder')
                .find('input.reorderable:between(' + $x + ',' + $y + ')')
                .sort(function (a, b) {
                    console.log({a:a,b:b});
                    if ($.browser.msie) {
                        if (parseInt($(b).data('original')) < parseInt($(a).data('original'))) {
                            return (parseInt($(b).val()) < parseInt($(a).val())) ? 1 : -1;
                        } else if (parseInt($(a).data('original')) < parseInt($(b).data('original'))) {
                            return (parseInt($(a).val()) < parseInt($(b).val())) ? 1 : -1;
                        } else {
                            return 0;
                        }
                    } else {
                        if (parseInt($(a).data('original')) < parseInt($(b).data('original'))) {
                            return (parseInt($(a).val()) < parseInt($(b).val())) ? -1 : 1;
                        } else {
                            return (parseInt($(a).val()) < parseInt($(b).val())) ? 1 : -1;
                        }
                    }
                }).each(function (d) {
                    $n = $x + d;
                    $(this).val($n);
                });
        $('.reorder').trigger('backup');
    });
});
