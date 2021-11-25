import { Router } from './navigate.js';
import { Util } from './utilities.js';

$(document).ready(() => {
    function sum(total, value) {
        return total + value;
    }

    const duration = 400;
    const router = new Router($("#content"));
    const loader = $("#loading-indicator");
    const months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
    var _formattedData = {
        customers: {},
        backups: {}
    };
    months.forEach(_mon => {
        _formattedData.customers[_mon] = 0;
        _formattedData.backups[_mon] = 0;
    });
    var table;
    var data = {
        customers: {},
        backups: {}
    };

    $(document).on("click", ".navigation-btn", function () {
        var target = $(this).attr("target");
        var extra = $(this).attr("data");

        loader.fadeIn(duration);
        router.get(target, function (response, status, xhr) {
            let _table = $("#table-data tbody");

            switch (target) {
                case "dashboard":
                    var _size = 0, _quota = 0;
                    months.forEach(_mon => {
                        _formattedData.customers[_mon] = 0;
                        _formattedData.backups[_mon] = 0;
                    });
                    const ctx_line = $("#customer_backup_chart-line");
                    const ctx_doughnut = $("#customer_backup_chart-doughnut");

                    $.get("service/users", function (_data, status) {
                        if (_data.status != "OK") {
                            return;
                        }
                        _data.data.forEach(_user => {
                            var _monthCreated = _user.date_created.split("-")[1];
                            _formattedData.customers[months[parseInt(_monthCreated) - 1]] += 1;

                            data.customers[_user.id] = _user
                            _size += parseFloat(_user.backup_size);
                            _quota += parseFloat(_user.backup_quota);
                        })

                        $("#user_count").text(Object.keys(data.customers).length);
                        $("#backup_size").text(Util.intParser(_size) + " MB");
                        $("#backup_quota").text(Util.intParser(_quota) + " MB");


                        $.get("service/backups", function (_data, status) {
                            if (_data.status != "OK") {
                                return;
                            }
                            _data.data.forEach(_backup => {
                                data.backups[_backup.id] = {};

                                var _monthCreated = _backup.date_created.split("-")[1];
                                _formattedData.backups[months[parseInt(_monthCreated) - 1]] += 1;

                                for (const key in _backup) {
                                    if (Object.hasOwnProperty.call(_backup, key)) {
                                        const value = _backup[key];
                                        var regex = new RegExp("^users_(.+)$");

                                        if (regex.test(key)) {
                                            if (Object.keys(data.customers[_backup.users_id] ?? {}).length <= 0) {
                                                data.customers[_backup.users_id] = {};
                                                data.customers[_backup.users_id][key.replace("users_", "")] = value;
                                            }
                                        } else {
                                            data.backups[_backup.id][key] = value;
                                        }
                                    }
                                }
                            })

                            $("#backup_count").text(Object.keys(data.backups).length);
                            console.log(_formattedData);

                            const config_line = {
                                type: "line",
                                data: {
                                    labels: months,
                                    datasets: [
                                        {
                                            label: 'Users',
                                            data: Object.values(_formattedData.customers),
                                            fill: false,
                                            borderColor: '#2332B3',
                                            tension: 0.4
                                        },
                                        {
                                            label: 'Backups',
                                            data: Object.values(_formattedData.backups),
                                            fill: false,
                                            borderColor: '#17E517',
                                            tension: 0.4
                                        }
                                    ]
                                }
                            }
                            const config_doughnut = {
                                type: "doughnut",
                                options: {
                                    cutout: "60%"
                                },
                                data: {
                                    labels: ["User", "Backups"],
                                    datasets: [
                                        {
                                            label: "Ratio of User and Backups",
                                            backgroundColor: ["#2332B3", "#17E517"],
                                            data: [
                                                Object.values(_formattedData.customers).reduce(sum, 0),
                                                Object.values(_formattedData.backups).reduce(sum, 0),
                                            ]
                                        }
                                    ]
                                }
                            }
                            const chart_line = new Chart(ctx_line, config_line);
                            const chart_doughnut = new Chart(ctx_doughnut, config_doughnut);

                        });
                    });
                    break;

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

                case "settings":
                    $.get("service/admin", function (_data, status) {
                        if (_data.status != "OK") {
                            return;
                        }
                        var _admin = _data.data;

                        $("#overview .name").text(_admin.name);
                        $("#overview .contact").text(_admin.contact);
                        $("#overview .role").text(_admin.role);
                        $("#overview .status").text(_admin.status);
                        $("#overview .status").css("color", "green");

                        var _name = _admin.name.split(" ");
                        $('input[name="firstname"]').val(_name[0]);
                        $('input[name="lastname"]').val(_name[1]);
                        $('input[name="username"]').val(_admin.username);
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

                case "user_form":
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

                case "user_update_form":
                    $.get("service/users/" + extra, function (_data, status) {
                        if (_data.status != "OK") {
                            return;
                        }
                        var _user = _data.data[0];
                        console.log(_user);

                        $("input[name='name']").val(_user.name);
                        $("input[name='contact']").val(_user.contact);
                        $("input[name='location']").val(_user.location);
                        $("select[name='backup_quota'] option[value='" + _user.backup_quota.toString().split(".")[0] + "']").prop("selected", true);
                        $(".data-holder-action[action='update_user']").attr("data", _user.id);
                    })
                    
                    break;

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
                    url: "service/backups/" + String(_data) + "/delete",
                    method: "get",
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

                case "update_user":
                $.ajax({
                    url: "service/users/" + String(_data)+ "update",
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
                    url: "service/users/" + String(_data) + "/delete",
                    method: "get",
                    dataType: "json",
                    error: (m, e) => {
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
            case "update_admin":
                $.ajax({
                    url: "service/update/details",
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
                                window.location.reload();
                            }
                        });
                    }
                });
                break;

            case "update_password":
                $.ajax({
                    url: "service/update/password",
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
                                $('.navigation-btn[target="settings"]').trigger("click");
                            }
                        });
                    }
                });
                break;

            case "login":
                $.ajax({
                    url: "service/auth",
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

                        if (response.status == "OK") {
                            window.location = "home.php";
                            return;
                        }

                        swal({
                            icon: "error",
                            title: response.title,
                            text: response.message
                        });
                    }
                });
                break;

            case "logout":
                $.ajax({
                    url: "service/logout",
                    method: "get",
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
                                window.location = "home.php";
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
                    $("#sub-content .navigation-btn").attr("data", _mapValue);
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

    $('.navigation-btn[target="dashboard"]').trigger("click");
})