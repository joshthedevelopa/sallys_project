import { Router } from './navigate.js';
import { Util } from './utilities.js';

$(document).ready(() => {
    var table;

    const duration = 400;
    const router = new Router($("#content"));
    const loader = $("#loading-indicator");

    var data = {
        customers: {

        },
        backups: {
            1: {
                user_id: 1,
                name: "Forzen Lake",
                description: "Quarter Year Backup Routine",
                file: "",
                backup_size: 1024,
                date_created: "20-06-1999"
            }

        }
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
                                    console.log(user);

                                    _table.append(`
                                        <tr id='${element.id}'>
                                            <td>
                                                <input name="selectedInput" value="${element.id}" type="checkbox">
                                            </td>
                                            <td>${element.name}</td>
                                            <td>${element.location}</td>
                                            <td>${element.service_type}</td>
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
                    console.log(data.customers);
                    for (const key in data.backups) {
                        if (Object.hasOwnProperty.call(data.backups, key)) {
                            const element = data.backups[key];

                            _table.append(`
                                <tr id='${key}'>
                                    <td>
                                        <input name="selectedInput" value="${element.id}" type="checkbox">
                                    </td>
                                    <td>${element.name}</td>
                                    <td>${data.customers[element.user_id].name}</td>
                                    <td>${Util.intParser(element.backup_size)} MB</td>
                                    <td>${element.date_created}</td>
                                </tr>
                            `);
                        }
                    }
                    table = _table.parents("#table-data").DataTable();

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
        $(".customers-table tbody tr.selected").toggleClass("selected", false);
    });

    $(document).on("click", ".customers-table tbody tr td:not(:first-child)", function () {
        var row = $(this).parents("tr");
        var _index = row.attr("id");

        if (row.hasClass("selected")) {
            $(".customers-table tbody tr").toggleClass("selected", false);
            $("#sub-content").toggleClass("active", false);
        } else {
            $(".customers-table tbody tr").toggleClass("selected", false);

            for (var key in data.customers[_index]) {
                var _mapValue = data.customers[_index][key];
                if (key == "id") {
                    $("#sub-content .data-holder-action").attr("data", _mapValue);
                }

                if (['backupSize', 'backupQuota'].some((value, index) => key == value)) {
                    _mapValue = Util.intParser(_mapValue);
                }
                $("#sub-content .data-holder[data='" + key + "']").text(_mapValue);
            }

            row.toggleClass("selected");
            $("#sub-content").toggleClass("active", true);
        }
    })

})