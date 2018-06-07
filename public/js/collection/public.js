$(document).ready(function () {
    var t = $('#collection-datatable').DataTable({
        data: {},
        "processing": true,
        language: datatableLang,
        "columns": [
            {"data": "name", "title": "Имя"},
            //{"data": "user_id", "title": "Пользователь"},
            {"data": "image_count", "title": "Колличество фото"},
            {"data": "created_at", "title": "Создана"},
            {"data": "updated_at", "title": "Обновлена"},
            {
                "data": function (row) {
                    return '<a href="/public/' + row.id + '" target="_blank">Открыть</a>'
                }, "title": "Открыть"
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
            url: "/public/list",
            data: $('#collection-filter').serialize(),
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