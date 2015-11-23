var idArr = [];
var fdata = {};

var load = 0;

$(function(){
    $("#infoTable select").each(function(){
        var id = $(this).attr("id");
        var call = $(this).attr("data-call");
        var mapping = $(this).attr("data-map");


        var result = listsObject(call);
        var html1 = '<option value="" selected="selected">ทั้งหมด</option>'+result;
        var html2 = '<option value="" selected="selected"></option>'+result;

        $("#" + id).html(html1).select2();

        if(typeof mapping !== "undefined"){
            $("#"+mapping).html(html2);
        }

        idArr.push("#"+id);
        fdata[id] = $(this).val();
    });

    $("#associateId").html(listsObject("listsAssociate"));
    $("#form select").each(function(){
        $(this).select2();
    });

    $(idArr.join(",")).change(function(){
        var id = $(this).attr("id");
        fdata[id] = $(this).val();
    });

    listsAllRice();

    $("button.table").click(function(){
        toggleShow("list");
    });

    // when you click to add bidder info
    $("button.add").click(function(){
        toggleShow("form");

        // when you save form
        $("button.submit").unbind().click(function(){
            var isValid = true;
            $('#form input[required], #form select[required]').each(function() {
                if($(this).val() == "" && !$(this).prop("disabled"))
                    isValid = false;
            });
            if(isValid){
                var fdata = dataObject(null);
                var dataJSON = JSON.stringify({riceInfo: fdata["RiceInfo"]});
                var dataJSONEN = encodeURIComponent(dataJSON);

                insertWarehouse(dataJSONEN);
            }
        });
    });

    // when you click to cancel
    $("button.cancel").click(function(){
        toggleShow("list");
    });

});

function listsAllRice(){
    var t = $('#table').DataTable( {
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: js_context_path+"/api/warehouse/warehouseInfo/listsAllRice",
            type: "post"
        },
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
                "data": "zoneNameTH",
                "sClass": "text-center"
            },
            {
                "targets": 2,
                "data": "provinceNameTH",
                "sClass": "text-center"
            },
            {
                "targets": 3,
                "data": "code",
                "sClass": "text-center"
            },
            {
                "targets": 4,
                "data": "silo",
                "sClass": "text-left"
            },
            {
                "targets": 5,
                "data": "associate",
                "sClass": "text-center"
            },
            {
                "targets": 6,
                "data": "warehouse",
                "sClass": "text-center"
            },
            {
                "targets": 7,
                "data": "stack",
                "sClass": "text-center"
            },
            {
                "targets": 8,
                "data": "project",
                "sClass": "text-center"
            },
            {
                "targets": 9,
                "data": "type",
                "sClass": "text-center"
            },
            {
                "targets": 10,
                "data": "grade",
                "sClass": "text-center"
            },
            {
                "targets": 11,
                "data": "discountRate",
                "sClass": "text-center"
            },
            {
                "targets": 12,
                "data": "status",
                "sClass": "text-center"
            },
            {
                "targets": 13,
                "data": "id",
                "sClass": "text-center",
                "render": function (data) {
                    var content = '<button class="btn btn-primary history" data-id="'+data+'" title="ดูประวัติ"><i class="fa fa-search"></i></button>&nbsp;';

                    return content;
                }
            },
            {
                "targets": 14,
                "data": "id",
                "sClass": "text-center col-md-1",
                "render": function (data) {
                    var content = '<button class="btn btn-primary edit" data-id="'+data+'" title="แก้ไข"><i class="fa fa-pencil"></i></button>&nbsp;'
                            + '<button class="btn btn-default delete" data-id="'+data+'" title="ลบ"><i class="fa fa-trash"></i></button>';

                    return content;
                }
            }
        ]
    });

    $("#sZone").change(function() {
        t.columns(1).search(this.value).draw();
    });

    $("#sProvince").change(function() {
        t.columns(2).search(this.value).draw();
    });

    $("#sCode").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(3).search(this.value).draw();
        }
    });

    $("#sSilo").keydown(function(event){
        var keyCode = (event.keyCode ? event.keyCode : event.which);
        if (keyCode == 13) {
            t.columns(4).search(this.value).draw();
        }
    });

    $('#sProject').change(function() {
        t.columns(8).search(this.value).draw();
    });

    $('#sType').change(function() {
        t.columns(9).search(this.value).draw();
    });

    $('#sGrade').change(function() {
        t.columns(10).search(this.value).draw();
    });

    $('#sStatus').change(function() {
        t.columns(12).search(this.value).draw();
    } );

    $("#table").off("click", "button.history").on("click", "button.history", function(){
        $("#viewHistory").modal("show");

        var id = $(this).attr("data-id");
        riceInfo(id);
    });

    $("#table").off("click", "button.edit").on("click", "button.edit", function(){
        toggleShow("form");

        var id = $(this).attr("data-id");
        var value = select(id);

        $("#form input").each(function() {
            var fname = $(this).attr("name");

            $("#"+fname).val(value[fname]);
        });

        $("#form select").each(function() {
            var fname = $(this).attr("name");
            console.log(value[fname]);

            $("#"+fname).select2("val", value[fname]);
        });

        // when you save form
        $("button.submit").unbind().click(function(){
            var isValid = true;
            $('#form input[required], #form select[required]').each(function() {
                if($(this).val() == "" && !$(this).prop("disabled"))
                    isValid = false;
            });
            if(isValid){
                var fdata = dataObject(id);
                var dataJSON = JSON.stringify({riceInfo: fdata["RiceInfo"]});
                var dataJSONEN = encodeURIComponent(dataJSON);

                editWarehouse(dataJSONEN);
            }
        });
    });

    $("#table").off("click", "button.delete").on("click", "button.delete", function(){
        $("#deleteModal").modal("show");

        var id = $(this).attr("data-id");
        var value = select(id);

        $("#codeDel").html(value["code"]);
        $("#siloDel").html(value["silo"]+' ['+value["provinceNameTH"]+'] ['+value["associate"]+']');
        $("#warehouseDel").html(value["warehouse"]);
        $("#stackDel").html(value["stack"]);
        $("#projectDel").html(value["project"]);
        $("#typeDel").html(value["type"]);
        $("#gradeDel").html(value["grade"]);
        $("#weightDel").html(value["weight"]);

        $("#confirmDelete").unbind().click(function(){
            var dataInfo = {};
            dataInfo["id"] = id;

            var fdata = {};
            fdata["RiceInfo"] = dataInfo;

            var dataJSON = JSON.stringify({riceInfo: fdata["RiceInfo"]});
            var dataJSONEN = encodeURIComponent(dataJSON);

            deleteWarehouse(dataJSONEN);
        });
    });
}

function listsObject(dataCall){
    var html = '';

    var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/"+dataCall, "post", {}, "json");
    if(typeof datas !== "undefined" && datas !== null){
        $.each(datas["lists"], function(key, value){
            html += '<option value="'+value["id"]+'">'+value["name"]+'</option>';
        });
    }

    return html;
}

function riceInfo(id){
    var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/riceInfo", "post", {id: id}, "json");
    if(typeof datas !== "undefined" && datas !== null){
        var value = datas["lists"];

        $("#codeDisp").html(value["code"]);
        $("#siloDisp").html(value["silo"]+' ['+value["provinceNameTH"]+'] ['+value["associate"]+']');
        $("#warehouseDisp").html(value["warehouse"]);
        $("#stackDisp").html(value["stack"]);
        $("#projectDisp").html(value["project"]);
        $("#typeDisp").html(value["type"]);
        $("#gradeDisp").html(value["grade"]);
        $("#weightDisp").html(value["weight"]);

        var html = '';
        if(value["statusArr"].length > 0){
            var count = 0;
            $.each(value["statusArr"], function(key, val){
                html += '<tr>'
                    + '<td class="text-center">'+(++count)+'</td>'
                    + '<td class="text-center">'+val["status"]+'</td>'
                    + '</tr>';
            });
        }
        else{
            html = '<tr><td colspan="2" class="text-center">-</td></tr>'
        }

        $("#table2 tbody").html(html);
    }
}

function select(id){
    var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/select", "post", {id: id}, "json");
    if(typeof datas !== "undefined" && datas !== null) {
        return datas["lists"];
    }
}

function insertWarehouse(dataJSONEN){
    $("#loading").html("กำลังบันทึกข้อมูล...");

    setTimeout(function(){
        var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/insert", "post", dataJSONEN, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            if(datas["add"] == true){
                $("#loading").html('<span class="text-success">บันทึกข้อมูลเรียบร้อย</span>');
                setTimeout(function(){
                    toggleShow("list");
                }, 500);
            }
            else{
                $("#loading").html('<span class="text-danger">ไม่สามารถบันทึกข้อมูลได้<br>'+datas["add"]+'</span>');
            }
        }
    }, 100);
}

function editWarehouse(dataJSONEN){
    $("#loading").html("กำลังบันทึกข้อมูล...");

    setTimeout(function(){
        var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/update", "post", dataJSONEN, "json");
        if (typeof datas !== "undefined" && datas !== null) {
            if(datas["update"] == true){
                $("#loading").html('<span class="text-success">บันทึกข้อมูลเรียบร้อย</span>');
                setTimeout(function(){
                    toggleShow("list");
                }, 500);
            }
            else{
                $("#loading").html('<span class="text-danger">ไม่สามารถบันทึกข้อมูลได้<br>'+datas["add"]+'</span>');
            }
        }
    }, 100);
}

function deleteWarehouse(dataJSONEN) {
    var datas = callAjax(js_context_path+"/api/warehouse/warehouseInfo/delete", "post", dataJSONEN, "json");
    if (typeof datas !== "undefined" && datas !== null) {
        if (datas["delete"] == true) {
            toggleShow("list");
        }
    }
}

function dataObject(uid){
    var dataInfo = {};

    //edit
    if(uid !== null){
        dataInfo["id"] = uid;

    }
    $("#form input, #form select").each(function (i) {
        var fname = $(this).attr("name");
        var fvalue = $(this).val();

        dataInfo[fname] = fvalue;
    });
    var fdata = {};
    fdata["RiceInfo"] = dataInfo;

    return fdata;
}

function toggleShow(option){
    if(option == "form"){
        $("#infoForm, #showTable").show();
        $("#infoTable, #addToTable").hide();

        $("#form input").each(function(){
            $(this).val("");
        });
        $("#form select").each(function(){
            $(this).select2("val", "");
        });

        $("#loading, #searching").empty();
    }

    else if(option == "list"){
        $("#infoTable, #addToTable").show();
        $("#infoForm, #showTable").hide();
        listsAllRice();
    }
}