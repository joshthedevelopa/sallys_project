import { Router } from './navigate.js';
import { Util } from './utilities.js';

$(document).ready(() => {
    const duration = 400;
    const router = new Router($("#content"));
    const loader = $("#loading-indicator");

    var table;
    var data = {
        customers: {},
        backups: {}
    };

    $(document).on("click", ".navigation-btn", function () {
        var target = $(this).attr("target");

        loader.fadeIn(duration);
        router.get(target, function (response, status, xhr) {
            let _table = $("#table-data tbody");

            switch (target) {
                case "customer":
                    $.ajax({
                        url: "service/users",
                        method: "get",
                        dataType: "json",
                        success: (response) => {
                            if (response.status == "OK") {
                                response.data.forEach(user => {
                                    var element = user;

                                    _table.append(`
                                        <tr id='${element.id}'>
                                            <td>
                                                <input name="selectedInput" value="${element.id}" type="checkbox">
                                            </td>
                                            <td>${element.name}</td>
                                            <td>${element.location}</td>
                                            <td>${Util.intParser(element.backup_quota)} MB</td>
                                            <td>${Util.intParser(element.backup_size)} MB</td>
                                        </tr>
                                    `);

                                    data.customers[user.id] = user;
                                });
                            }

                            table = _table.parents("#table-data").DataTable();
                        }
                    });

                    break;

                case "recovery":
                    $.ajax({
                        url: "service/backups",
                        method: "get",
                        dataType: "json",
                        success: (response) => {
                            if (response.status == "OK") {
                                response.data.forEach(backup => {
                                    var element = backup;

                                    _table.append(`
                                        <tr id='${element.id}'>
                                            <td>
                                                <input name="selectedInput" value="${element.id}" type="checkbox">
                                            </td>
                                            <td>${element.name}</td>
                                            <td>${element.users_name}</td>
                                            <td>${Util.intParser(element.backup_size)} MB</td>
                                            <td>${element.date_created}</td>
                                        </tr>
                                    `);

                                    data.customers[backup.users_id] = {};
                                    data.backups[backup.id] = {};

                                    for (const key in backup) {
                                        if (Object.hasOwnProperty.call(backup, key)) {
                                            const value = backup[key];

                                            var regex = new RegExp("^users_(.+)$");
                                            if (regex.test(key)) {
                                                data.customers[backup.users_id][key.replace("users_", "")] = value;
                                            } else {
                                                data.backups[backup.id][key] = value;
                                            }
                                        }
                                    }
                                });
                            }

                            table = _table.parents("#table-data").DataTable();
                        }
                    });

                    break;
                case "backup_form":
                    var select = $("form#backup select[name='user']");
                    for (const id in data.customers) {
                        if (Object.hasOwnProperty.call(data.customers, id)) {
                            const customer = data.customers[id];

                            select.append(`
                                <option value="${customer.id}">${customer.name}</option>
                            `);
                        }
                    }

                    break;

                // case "user_form":
                //     var select = $("form#backup select[name='user']");
                //     for (const id in data.customers) {
                //         if (Object.hasOwnProperty.call(data.customers, id)) {
                //             const customer = data.customers[id];

                //             select.append(`
                //                     <option value="${customer.id}">${customer.name}</option>
                //                 `);
                //         }
                //     }

                //     break;

                default:
                    break;
            }
            loader.fadeOut(duration);
        })

    })

    $(document).on("click", ".close-btn", function () {
        var target = $(this).attr("target");
        var selector = $(target);

        selector.toggleClass("active", false);
        $(".customers-table tbody tr#selected").toggleClass("selected", false);
    });

    $(document).on("click", ".data-holder-action", function () {
        var action = $(this).attr("action");
        var _data = $(this).attr("data");

        var form = $(this).parents("form");
        var formData = new FormData(form.get(0));

        switch (action) {
            case "create_backup":
                $.ajax({
                    url: "service/backups",
                    method: "post",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: () => {
                        loader.fadeOut(duration);
                    },
                    beforeSend: () => {
                        loader.fadeIn(duration);
                    },
                    success: (response) => {
                        loader.fadeOut(duration);
                        swal({
                            icon: response.status == "OK" ? "success" : "error",
                            title: response.title,
                            text: response.message
                        }).then(() => {
                            if (response.status == "OK") {
                                $('.navigation-btn[target="recovery"]').trigger("click");
                            }
                        });
                    }
                });
                break;
            case "restore_backup":
                window.location = "uploads/" + data.backups[_data].backup_filename;
                swal({
                    title: "File Download",
                    text: "Your download will start shortly..."
                }).then(() => {
                    $('.navigation-btn[target="recovery"]').trigger("click");
                });

                break;

            case "delete_backup":
                $.ajax({
                    url: "service/backups/" + String(_data),
                    method: "delete",
                    dataType: "json",
                    error: () => {
                        loader.fadeOut(duration);
                    },
                    beforeSend: () => {
                        loader.fadeIn(duration);
                    },
                    success: (response) => {
                        loader.fadeOut(duration);
                        swal({
                            icon: response.status == "OK" ? "success" : "error",
                            title: response.title,
                            text: response.message
                        }).then(() => {
                            if (response.status == "OK") {
                                delete data.backups[_data];
                                $('.navigation-btn[target="recovery"]').trigger("click");
                            }
                        });
                    }
                });
                break;

            case "create_user":
                $.ajax({
                    url: "service/users",
                    method: "post",
                    dataType: "json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: () => {
                        loader.fadeOut(duration);
                    },
                    beforeSend: () => {
                        loader.fadeIn(duration);
                    },
                    success: (response) => {
                        loader.fadeOut(duration);
                        swal({
                            icon: response.status == "OK" ? "success" : "error",
                            title: response.title,
                            text: response.message
                        }).then(() => {
                            if (response.status == "OK") {
                                $('.navigation-btn[target="customer"]').trigger("click");
                            }
                        });
                    }
                });
                break;

                case "delete_user":
                    $.ajax({
                        url: "service/users/" + String(_data),
                        method: "delete",
                        dataType: "json",
                        error: () => {
                            loader.fadeOut(duration);
                        },
                        beforeSend: () => {
                            loader.fadeIn(duration);
                        },
                        success: (response) => {
                            loader.fadeOut(duration);
                            swal({
                                icon: response.status == "OK" ? "success" : "error",
                                title: response.title,
                                text: response.message
                            }).then(() => {
                                if (response.status == "OK") {
                                    delete data.customers[_data];
                                    $('.navigation-btn[target="customer"]').trigger("click");
                                }
                            });
                        }
                    });
                    break;

            default:
                break;
        }
    })

    $(document).on("click", ".selective-table tbody tr td:not(:first-child)", function () {
        var _data;
        var table_name = $(this).parents(".selective-table").attr("data");
        var row = $(this).parents("tr");
        var _index = row.attr("id");

        if (table_name == "users") {
            _data = data.customers;

        } else if (table_name == "backups") {
            _data = data.backups;

        } else {
            return null;

        }


        if (!row.hasClass("selected")) {
            $(".selective-table tbody tr.selected").toggleClass("selected", false);

            for (var key in _data[_index]) {
                var _mapValue = _data[_index][key];

                if (key == "id") {
                    $("#sub-content .data-holder-action").attr("data", _mapValue);
                }

                if (['backup_size', 'backup_quota'].some((value, index) => key == value)) {
                    _mapValue = Util.intParser(_mapValue);
                }

                if (table_name == "backups") {
                    if (key == "user_id") {
                        for (const customer_key in data.customers[_mapValue]) {
                            $("#sub-content .data-holder[data='customer_" + customer_key + "']").text(data.customers[_mapValue][customer_key]);
                        }
                    }
                }

                $("#sub-content .data-holder[data='" + key + "']").text(_mapValue);
            }
        }

        $("#sub-content").toggleClass("active", !row.hasClass("selected"));
        row.toggleClass("selected", !row.hasClass("selected"));
    })


})