dom: '<"top"lfB>rt<"bottom"ip><"clear">',
buttons: [
    {
        extend: 'copyHtml5',
        text: '<i class="fa fa-copy"></i> Copy to Clipboard',
        className: 'btn btn-sm btn-default',
        exportOptions: {
            columns: function ( idx, data, node ) {
                return $(node).is(":visible") && !$(node).hasClass('notexport') ?
                    true : false;
            } 
        }
    },
    
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o"></i> Export to Excel',
        className: 'btn btn-sm btn-default',
        exportOptions: {
            columns: function ( idx, data, node ) {
                return $(node).is(":visible") && !$(node).hasClass('notexport') ?
                    true : false;
            } 
        }
    },
    {
        extend: 'csvHtml5',
        text: '<i class="fa fa-file"></i> Export to CSV',
        className: 'btn btn-sm btn-default',
        exportOptions: {
            columns: function ( idx, data, node ) {
                return $(node).is(":visible") && !$(node).hasClass('notexport') ?
                    true : false;
            } 
        }
    }
],<?php /**PATH /home/ghpayroll/base/resources/views/layout/export_buttons.blade.php ENDPATH**/ ?>