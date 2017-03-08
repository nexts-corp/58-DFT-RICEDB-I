var fdata;

$(function () {
    // show bidder info list
    initUser();

});

function initUser() {
    var username = $.cookie("username");
    var value = callAjax(js_context_path + "/api/user/profile/get", "post", {username: username}, "json")["user"];

    //var value = listArr[userId];

    $("#name").val(value["name"]);
    $("#surname").val(value["surname"]);
    $("#roleCode").val(value["role"]);
    $("#departmentId").val(value["department"]);
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
        $('#form-part1 input[required]').each(function () {
            if ($(this).val() == "")
                isValid = false;
        });
//        var username = $("#username").val();
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
//            if (username != value["username"]) {
//                newData["username"] = username;
//            }
            if (password != "") {
                newData["password"] = password;
            }

            fdata = dataObject(value["id"]);
            $.each(newData, function (k, v) {
                fdata["User"][k] = v;
            });
        }
        //console.log(fdata);
        if (isValid) {
            //var fdata = dataObject(userId);
            var dataJSON = JSON.stringify({user: fdata["User"]});
            var dataJSONEN = encodeURIComponent(dataJSON);

            editUser(dataJSONEN);
        }
    });


}

function editUser(dataJSONEN) {
    $("#loading").html("กำลังบันทึกข้อมูล...");

    setTimeout(function () {
        var datas = callAjax(js_context_path + "/api/user/profile/update", "post", dataJSONEN, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            if (datas["update"] == true) {
                $("#loading").html('<span class="text-success">บันทึกข้อมูลเรียบร้อย</span>');
                logout();
//                setTimeout(function () {
//                    $("#loading").html('<span class="text-success"></span>');
//                }, 1000);
            }
            else {
                $("#loading").html('<span class="text-danger">' + datas["update"] + '</span>');
            }
        }
    }, 100);
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
