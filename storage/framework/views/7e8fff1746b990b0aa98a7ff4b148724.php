dom: '<"top"lfB>rt<"bottom"ip><"clear">',
buttons: [
    {
        extend: 'copyHtml5',
        text: '<i class="fa fa-copy"></i> Copy ',
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
        text: '<i class="fa fa-file-excel-o"></i> Excel',
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
        text: '<i class="fa fa-file"></i> CSV',
        className: 'btn btn-sm btn-default',
        exportOptions: {
            columns: function ( idx, data, node ) {
                return $(node).is(":visible") && !$(node).hasClass('notexport') ?
                    true : false;
            } 
        }
    }
],<?php /**PATH C:\laragon\www\comaziwa\resources\views/layout/export_buttons.blade.php ENDPATH**/ ?>