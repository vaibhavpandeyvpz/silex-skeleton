(($) => {
    'use strict';

    $.extend({
        renderCell (renderer, data, row) {
            switch (renderer) {
                case 'email':
                    return sprintf('<a href class="mailto:%1$s">%1$s</a>', data);
                case 'boolean':
                    return sprintf(
                        '<span class="label label-%s">%s</span>',
                        data == 1 ? 'success' : 'danger',
                        data == 1 ? translations.yes : translations.no,
                    );
                case 'roles':
                    return data.split(',')
                        .map((i) => {
                            let clazz = i === 'ROLE_ADMIN' ? 'danger' : 'info';
                            return sprintf('<span class="label label-%s">%s</span>', clazz, translations[i])
                        })
                        .join('\n');
                case 'time_diff': {
                    if (data != null) {
                        return sprintf('<abbr data-toggle="tooltip" title="%s">%s</abbr>', data, moment(data).fromNow());
                    }
                    return '<span class="text-muted">' + translations.never + '</span>';
                }
                default:
                    return data;
            }
        }
    });

    $.fn.dataTable.ext.errMode = 'none';

    $.fn.datagrid = function () {
        return this.each(() => {
            let columns = [];
            let $table = $(this);

            // Columns
            $('thead th[data-column]', $table).each((i, el) => {
                let $el = $(el);
                let column = $el.data('column'),
                    renderer = $el.data('renderer') || column;
                let exclusions = {
                    ordering: [],
                    searching: [],
                };
                switch (column) {
                    case 'details':
                        columns.push({
                            className: 'control',
                            data: 'blank',
                            orderable: false,
                            searchable: false,
                        });
                        break;
                    default:
                        columns.push({
                            data: column,
                            name: column,
                            orderable: exclusions.ordering.indexOf(column) < 0,
                            searchable: exclusions.searching.indexOf(column) < 0,
                            render (data, type, row, meta) {
                                if ((typeof data !== 'undefined') && (type == 'display')) {
                                    return $.renderCell(renderer, data, row);
                                }
                                return data;
                            }
                        });
                        break;
                }
            });

            // DataTable
            let $datatable = $table.DataTable({
                ajax: {
                    type: 'GET',
                    url: urls.base + '/grid',
                },
                autoWidth: false,
                columns: columns,
                order: $table.data('sorting') || [[columns.length - 1, 'desc']],
                pagingType: 'full_numbers',
                processing: false,
                responsive: {
                    details: { type: 'column' }
                },
                rowCallback (row, data, i) {
                    $('[data-toggle="tooltip"]', row).tooltip({container: 'body'});
                },
                searchDelay: 250,
                serverSide: true,
            });

            // Ajax Events
            let $actions = $($table.data('toolbar') + " [data-action]"),
                $loader = $($table.data('loader'));
            $table.on('error.dt', () => {});
            $table.on('preXhr.dt', () => {
                $actions.filter('[data-require-selection]')
                    .attr('disabled', 'disabled')
                    .prop('disabled', true);
                $loader.removeClass('hidden');
            });
            $table.on('xhr.dt', () => {
                $loader.addClass('hidden');
            });

            // Selection
            $('tbody', $table).on('click', 'tr[role="row"]', function () {
                if ($datatable.data().count()) {
                    if ($(this).hasClass('info')) {
                        $(this).removeClass('info');
                        $actions.filter('[data-require-selection]')
                            .attr('disabled', 'disabled')
                            .prop('disabled', true);
                    } else {
                        $datatable.$('tr.info')
                            .removeClass('info');
                        $(this).addClass('info');
                        $actions.filter('[data-require-selection]')
                            .removeAttr('disabled')
                            .prop('disabled', false);
                    }
                }
            });

            // Triggers
            $actions.click(function (e) {
                e.preventDefault();
                let data = $datatable.row('.info').data(),
                    $action = $(this),
                    action = $action.data('action');
                switch (action) {
                    case 'redirect': {
                        let confirmation = $action.data('confirm'),
                            target = urls.base + '/' + data.id + '/' + $action.data('redirect-to');
                        if (typeof confirmation !== 'undefined') {
                            bootbox.confirm(confirmation, (yes) => {
                                if (yes) {
                                    window.location.href = target;
                                }
                            });
                        } else {
                            window.location.href = target;
                        }
                        break;
                    }
                    case 'refresh':
                        $datatable.ajax.reload(null, false);
                        break;
                    default:
                        break;
                }
            });
        });
    };

    $(document).on('ready', () => $('table[data-widget="datagrid"]').datagrid());
})(jQuery);
