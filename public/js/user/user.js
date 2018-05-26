$(document).ready(function() {
    var t = $('#user-datatable').DataTable({
        data: {},
        "processing": true,
        language: datatableLang,
        "columns": [
            {"data": "id", "title": "id"},
            {"data": "first_name", "title": "Имя"},
            {"data": "last_name", "title": "Фамилия"},
            {"data": "department_id", "title": "Отдел"},
            {"data": "role_id", "title": "Роль"},
            {"data": "site_id", "title": "Сайт"},
            {
                "data": function (row) {
                    return '<a href="/user/login/'+row.id+'" target="_blank">Войти</a>'
                }, "title": "Вход"
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
            url: "/user/list",
             data: $('#user-filter').serialize(),
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