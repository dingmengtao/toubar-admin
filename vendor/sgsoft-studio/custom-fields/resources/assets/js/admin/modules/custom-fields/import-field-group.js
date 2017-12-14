(function ($) {
    let $body = $('body');

    $body.on('click', '.trigger-import', function (event) {
        let $form = $(this).closest('form');
        $form.find('input[type=file]').val('');
    });

    $body.on('change', 'form.import-field-group input[type=file]', function (event) {
        let $form = $(this).closest('form');
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.readAsText(file);
            reader.onload = function(e) {
                let json = Helpers.jsonDecode(e.target.result);
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: {
                        json_data: json,
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        WebEd.showLoading();
                    },
                    success: function (res) {
                        WebEd.showNotification(res.messages, (res.error ? 'error' : 'success'));
                        if (!res.error) {
                            let dataTableHelper = $('table.datatables')[0].dataTableHelper;
                            if (dataTableHelper) {
                                dataTableHelper.getDataTable().ajax.reload();
                            }
                        }
                    },
                    complete: function (data) {
                        WebEd.hideLoading();
                    },
                    error: function (data) {
                        WebEd.showNotification('Some error occurred', 'error');
                    }
                });
            };
        }
    });
}(jQuery));