
$(function () {
// show bidder info list
    $(".save").click(function () {
        var resource = '';
        var name = '';
        var permission = '';
        var send = [];
        var data;
        var total = $("input[type=checkbox]").length;
        $("input[type=checkbox]").each(function (k, v) {
            resource = $(this).attr("data-resource");
            name = $(this).attr("data-name");
            if ($(this).prop("checked")) {
                permission += '1';
            } else {
                permission += '0';
            }
            if ((k == (total - 1)) || ((k + 1) % (countRole - 1) == 0)) { //last checkbox
                data = {"resourceCode": resource, "resourceName": name, "permission": permission};
                send.push(data);
                permission = '';
            }
        });
        $("#tbody").html('<tr><td colspan="' + countRole + '" class="text-center">กำลังบันทึก...</td></tr>');
        var dataJSON = JSON.stringify({permission: send});
        var dataJSONEN = encodeURIComponent(dataJSON);
        setTimeout(function () { //save data to permission interval 10ms
            var result = callAjax(js_context_path + "/api/user/permissionManage/save", "post", dataJSONEN, "json");
            if (result.save) {
                location.reload();
            } else {
                $("#tbody").html('<tr><td colspan="' + countRole + '" class="text-center text-danger">' + result.save + '</td></tr>');
            }
        }, 10);
    });
});
