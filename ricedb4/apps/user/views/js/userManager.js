var listArr = [];

$(function () {
    // show bidder info list
    showAllUser();

    listsRole();
    listsDepartment();

    $("button.table").click(function () {
        toggleShow("list");
    });

    // when you click to add bidder info
    $("button.add").click(function () {
        toggleShow("form-insert");

        // when you save form
        $("button.submit").unbind().click(function () {
            var isValid = true;
            $('#form input[required], #form select[required]').each(function () {
                if ($(this).val() == "" && !$(this).prop("disabled"))
                    isValid = false;
            });
            if (isValid) {
                var fdata = dataObject(null);
                var dataJSON = JSON.stringify({user: fdata["User"]});
                var dataJSONEN = encodeURIComponent(dataJSON);

                insertUser(dataJSONEN);
            }
        });
    });

    // when you click to cancel
    $("button.cancel").click(function () {
        toggleShow("list");
    });

});

function showAllUser() {
    listArr = [];

    var dataSet = [];

    $("#table tbody").html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');

    setTimeout(function () {
        var datas = callAjax(js_context_path + "/api/user/userManager/listsUser", "post", {}, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            $.each(datas["lists"], function (key, value) {
                listArr[value["id"]] = value;
                dataSet.push(value);
            });
        }

        var t = $("#table").DataTable({
            "destroy": true,
            "data": dataSet,
            "order": [[1, 'asc']],
            "iDisplayLength": 50,
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "data": "id",
                    "sClass": "text-center"
                },
                {
                    "targets": 1,
                    "data": "id",
                    "sClass": "text-left",
                    "render": function (data, key, full) {
                        var content = full["name"] + ' ' + full["surname"];

                        return content;
                    }
                },
                {
                    "targets": 2,
                    "data": "role",
                    "sClass": "text-left"
                },
                {
                    "targets": 3,
                    "data": "department",
                    "sClass": "text-left"
                },
                {
                    "targets": 4,
                    "data": "isActive",
                    "sClass": "text-center"
                },
                {
                    "targets": 5,
                    "orderable": false,
                    "data": "id",
                    "sClass": "text-center",
                    "render": function (data) {
                        var content = '<button class="btn btn-primary view" data-uid="' + data + '" title="รายละเอียด"><i class="fa fa-list"></i></button>';

                        return content;
                    }
                },
                {
                    "targets": 6,
                    "orderable": false,
                    "data": "id",
                    "sClass": "text-center",
                    "render": function (data) {
                        var content = '<button class="btn btn-primary edit" data-uid="' + data + '" title="แก้ไข"><i class="fa fa-pencil"></i></button>&nbsp;'
                                + '<button class="btn btn-default delete" data-uid="' + data + '"  title="ลบ"><i class="fa fa-trash"></i></button>';

                        return content;
                    }
                }
            ]
        });

        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // when you click to delete bidder info
        $("#table").on("click", "button.view", function () {
            $("#viewModal").modal("show");

            var userId = $(this).attr("data-uid");
            var value = listArr[userId];

            $("#nameView").html(value["name"] + " " + value["surname"]);
            $("#usernameView").html(value["username"]);
            $("#roleView").html(value["role"]);
            $("#departmentView").html(value["department"]);
            $("#emailView").html(value["email"]);
            $("#telephoneView").html(value["telephone"]);
            $("#addressView").html(value["address"]);
            $("#isActiveView").html(value["isActive"]);

        });

        $("#table").on("click", "button.edit", function () {
            toggleShow("form-edit");

            var userId = $(this).attr("data-uid");
            var value = listArr[userId];

            $("#name").val(value["name"]);
            $("#surname").val(value["surname"]);
            $("#roleCode option:contains('" + value["role"] + "')").prop("selected", true);
            $("#departmentId option:contains('" + value["department"] + "')").prop("selected", true);
            $("#email").val(value["email"]);
            $("#telephone").val(value["telephone"]);
            $("#address").val(value["address"]);
            $("#isActive").val(value["isActive"]);


            $("#username").val(value["username"]);
            $("#password").removeAttr("required");
            $("#passwordCheck").removeAttr("required");
            // when you save the user info was modified
            $("button.submit").unbind().click(function () {
                var isValid = true;
                $('#form-part1 input[required], #form-part1 select[required]').each(function () {
                    if ($(this).val() == "" && !$(this).prop("disabled"))
                        isValid = false;
                });
                var username = $("#username").val();
                var password = $("#password").val();
                var passwordCheck = $("#passwordCheck").val();
                if (username == "" || password != passwordCheck) {
                    isValid = false;
                    $("#loading").html('<span class="text-danger">Username หรือ Password ไม่ถูกต้อง</span>');
                } else if (password.length > 0 && password.length < 4) {
                    isValid = false;
                    $("#loading").html('<span class="text-danger">Password ต้อง 4 ตัวอักษรขึ้นไป</span>');
                } else {
                    $("#loading").html('');
                    var newData = {};
                    if (username != value["username"]) {
                        newData["username"] = username;
                    }
                    if (password != "") {
                        newData["password"] = password;
                    }

                    var fdata = dataObject(userId);
                    $.each(newData, function (k, v) {
                        fdata["User"][k] = v;
                    });
                }
                if (isValid) {
                    //var fdata = dataObject(userId);
                    var dataJSON = JSON.stringify({user: fdata["User"]});
                    var dataJSONEN = encodeURIComponent(dataJSON);
                    editUser(dataJSONEN);
                }
            });

        });

        // when you click to delete bidder info
        $("#table").on("click", "button.delete", function () {
            $("#deleteModal").modal("show");

            var userId = $(this).attr("data-uid");
            var value = listArr[userId];

            $("#nameDel").html(value["name"] + " " + value["surname"]);
            $("#usernameDel").html(value["username"]);
            $("#roleDel").html(value["role"]);
            $("#departmentDel").html(value["department"]);
            $("#isActiveDel").html(value["isActive"]);

            $("#confirmDelete").unbind().click(function () {
                var dataUser = {};
                dataUser["id"] = userId;

                var fdata = {};
                fdata["User"] = dataUser;

                var dataJSON = JSON.stringify({user: fdata["User"]});
                var dataJSONEN = encodeURIComponent(dataJSON);

                deleteUser(dataJSONEN);
            });
        });
    }, 10);
}

function insertUser(dataJSONEN) {
    if ($("#password").val() != $("#passwordCheck").val()) {
        $("#loading").html('<span class="text-danger">รหัสผ่านไม่ตรงกัน</span>');
    }
    else {
        $("#loading").html("กำลังบันทึกข้อมูล...");

        setTimeout(function () {
            var datas = callAjax(js_context_path + "/api/user/userManager/insert", "post", dataJSONEN, "json");
            if (typeof datas !== "undefined" && datas !== null) {
                if (datas["add"] == true) {
                    $("#loading").html('<span class="text-success">บันทึกข้อมูลเรียบร้อย</span>');
                    setTimeout(function () {
                        toggleShow("list");
                    }, 500);
                }
                else {
                    $("#loading").html('<span class="text-danger">ไม่สามารถบันทึกข้อมูลได้<br>' + datas["add"] + '</span>');
                }
            }
        }, 100);
    }
}

function editUser(dataJSONEN) {
    $("#loading").html("กำลังบันทึกข้อมูล...");

    setTimeout(function () {
        var datas = callAjax(js_context_path + "/api/user/userManager/update", "post", dataJSONEN, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            if (datas["update"] == true) {
                $("#loading").html('<span class="text-success">บันทึกข้อมูลเรียบร้อย</span>');
                setTimeout(function () {
                    toggleShow("list");
                }, 500);
            }
            else {
                $("#loading").html('<span class="text-danger">' + datas["update"] + '</span>');
            }
        }
    }, 100);
}

function deleteUser(dataJSONEN) {
    var datas = callAjax(js_context_path + "/api/user/userManager/delete", "post", dataJSONEN, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        if (datas["delete"] == true) {
            toggleShow("list");
        }
    }
}

function listsRole() {
    var html = '<option value="">เลือกสิทธิผู้ใช้งาน</option>';
    var datas = callAjax(js_context_path + "/api/user/userManager/listsRole", "post", {}, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        $.each(datas["lists"], function (key, value) {
            html += '<option value="' + value["code"] + '">' + value["role"] + '</option>'
        });
    }

    $("#roleCode").html(html);
}

function listsDepartment() {
    var html = '<option value="">เลือกหน่วยงาน</option>';
    var datas = callAjax(js_context_path + "/api/user/userManager/listsDepartment", "post", {}, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        $.each(datas["lists"], function (key, value) {
            html += '<option value="' + value["id"] + '">' + value["department"] + '</option>'
        });
    }

    $("#departmentId").html(html);
}

function dataObject(uid) {
    var dataUser = {};

    //edit
    if (uid !== null) {
        dataUser["id"] = uid;
        $("#form-part1 input, #form-part1 select, #form-part1 textarea").each(function (i) {
            var fattr = $(this).attr("data-entity");
            var fname = $(this).attr("name");
            var fvalue = $(this).val();
            dataUser[fname] = fvalue;
        });
    }
    //insert
    else {
        $("#form input, #form select, #form textarea").each(function (i) {
            var fattr = $(this).attr("data-entity");
            var fname = $(this).attr("name");
            var fvalue = $(this).val();
            dataUser[fname] = fvalue;
        });
    }
    var fdata = {};
    fdata["User"] = dataUser;

    return fdata;
}

function toggleShow(option) {
    if (option == "form-insert" || option == "form-edit") {
        $("#userForm, #showTable").show();
        $("#userTable, #addToTable").hide();

        $("#form-part1").show();
        $("#form-part2").show();

        $("#form input, #form select, #form textarea").each(function () {
            $(this).val("");
        });

        $("#loading, #searching").empty();
    }
//
//    if(option == "form-edit"){
//        $("#userForm, #showTable").show();
//        $("#userTable, #addToTable").hide();
//
//        $("#form-part1").show();
//        $("#form-part2").show();
//
//        $("#form input, #form select, #form textarea").each(function(){
//            $(this).val("");
//        });
//
//        $("#loading, #searching").empty();
//    }

    else if (option == "list") {
        $("#userTable, #addToTable").show();
        $("#userForm, #showTable").hide();
        showAllUser();
    }
}