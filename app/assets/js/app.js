//=require imports/datagrid.js
//=require imports/tooltips.js

(($) => {
    'use strict';

    $(document).on('ready', () => {
        var locale = document.documentElement.lang;
        if (locale) {
            moment.locale(locale);
        }
        $('select[data-toggle="select2"]').select2({
            theme: 'bootstrap',
            width: '100%',
        });
    });
})(jQuery);
