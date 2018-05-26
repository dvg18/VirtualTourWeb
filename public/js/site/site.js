$(document).ready(function() {
    var t = $('#site-datatable').DataTable({
    data: {},
    "processing": true,
    language: datatableLang,
    "columns": [
        {"data": "id", "title": "id"},
        {"data": "site_name", "title": "Сайт"},
        {"data": "widget_settings", "title": "Настройки"},
        {
            "data": function (row) {
                return '<a href="/site/edit/'+row.id+'" target="_blank">ред.</a>'
            }, "title": "Ред."
        }
    ]
    });
    
    function fillTable(data) {
        t.clear();
        t.rows.add(data);
        t.draw()
    }

    function getInititalData() {
        var jdata;
        $.ajax({
            type: "GET",
            cache: false,
            async: true,
            url: "/site/list",
            data: $('#site-filter').serialize(),
            contentType: "application/json;"
        }).done(function (resp) {
            fillTable(resp);
        }).fail(function (xhr, result, status) {
            alert('Alert ' + xhr.statusText + ' ' + xhr.responseText + ' ' + xhr.status);
        });
        return jdata;
    }

    getInititalData();
});