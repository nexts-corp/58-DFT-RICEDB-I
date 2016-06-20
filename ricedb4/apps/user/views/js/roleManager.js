var listArr = [];
var role;
$(function () {
    // show bidder info list

   //listsRole();


});



function listsRole() {
    var datas = callAjax(js_context_path + "/api/user/userManager/listsRole", "post", {}, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        role = datas["lists"];
    }
}
