$(document).ready(function () {
    var t = $('#collection-datatable').DataTable({
        data: {},
        "processing": true,
        language: datatableLang,
        "columns": [
            {"data": "id", "title": "id"},
            {"data": "name", "title": "Имя"},
            //{"data": "user_id", "title": "Пользователь"},
            {"data": "image_count", "title": "Колличество фото"},
            {"data": "isPublic", "title": "Опубликован"},
            {"data": "created_at", "title": "Создан"},
            {"data": "updated_at", "title": "Обновлен"},
            {
                "data": function (row) {
                    return '<a href="/collection/show/' + row.id + '" target="_blank">Открыть</a>'
                }, "title": "Открыть"
            },
            {
                "data": function (row) {
                    return '<a href="/collection/edit/' + row.id + '" target="_blank">ред.</a>'
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
            url: "/collection/list",
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