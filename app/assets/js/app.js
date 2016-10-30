//=require imports/datagrid.js
//=require imports/tooltips.js

(($) => {
    'use strict';

    $(document).on('ready', () => {
        var locale = document.documentElement.lang;
        if (locale) {
            moment.locale(locale);
        }
        $('input[data-toggle="datepicker"]').datetimepicker({
            format: 'YYYY-MM-DD', // YYYY-MM-DD HH:mm:ss
            useCurrent: false,
        });
        $('select[data-toggle="select2"]').select2({
            theme: 'bootstrap',
            width: '100%',
        });
    });
})(jQuery);
