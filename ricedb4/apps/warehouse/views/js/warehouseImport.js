var listArr = [];
var alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

$(function () {
    $("#form2 select").each(function(){
        var pthis = $(this);
        pthis.change(function(){
            var val = pthis.val();
            var option = pthis.attr("name");
            var col = parseInt(pthis.attr("data-col"));

            if(typeof alphabet[pthis.val()] === "undefined") alphabet[pthis.val()] = "-";

            $("#"+option+"Div").html(alphabet[pthis.val()]);

            $("#table tbody tr td:nth-child("+(col+1)+")").each(function(i){
                if(typeof listArr[i][val] === "undefined") var data = '';
                else var data = listArr[i][val];

                $(this).html(data);
            });
        });
    });


    $("#fileUpload").change(function(){
        $("#fileName").val($(this).val());
    });

    $("a.cancel").unbind().click(function(){
        toggleShow("form");
    });

    $("a.read").unbind().click(function(){
        var isValid = true;
        $('#form input[required]').each(function() {
            if($(this).val() == "" && !$(this).prop("disabled")){
                isValid = false;
                $(this).focus();
            }
        });

        if(isValid){
            toggleShow("form");

            $("#readLoading").html('Loading...');

            var formData = new FormData();
            formData.append('file', $('#fileUpload')[0].files[0]);
            formData.append('sheet', $("#sheet").val());
            formData.append('row', $("#row").val());

            var datas = callAjaxFile(js_context_path+"/api/warehouse/warehouseImport/view", "post", formData, "json");
            if(typeof datas !== "undefined" && datas !== null){
                $("#readLoading").html('');
                $("#fileNameDisplay").html($("#fileUpload").val());

                var html = '';
                $.each(datas["lists"], function(key, value){
                    //console.log(value.length);
                    listArr[key] = value;
                    html += '<tr>'
                        + '<td class="text-center"></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '<td></td>'
                        + '</tr>';
                });
                $("#table tbody").html(html);

                listsColumn();
            }
        }
    });

    $("button.import").unbind().click(function(){
        var isValid = true;
        $('#form input[required]').each(function() {
            if($(this).val() == "" && !$(this).prop("disabled")){
                isValid = false;
                $(this).focus();
            }
        });

        $('#form2 select').each(function() {
            if($(this).val() == null){
                isValid = false;
            }
        });

        if(isValid){
            $("#saveLoading").html('Loading...');

            var formData = new FormData();
            formData.append('file', $('#fileUpload')[0].files[0]);
            formData.append('sheet', $("#sheet").val());
            formData.append('row', $("#row").val());

            var object = dataObject();
            jQuery.each(object["Column"], function(key, value) {
                formData.append('column['+key+']', value);
            });

            var datas = callAjaxFile(js_context_path+"/api/warehouse/warehouseImport/import", "post", formData, "json");
            if(typeof datas !== "undefined" && datas !== null){
                if(datas["import"] == true){
                    $("#saveLoading").html('<span class="text-success">บันทึกข้อมูลเรียบร้อย</span>');
                    setTimeout(function(){
                        toggleShow("form");
                    }, 500);
                }
                else{
                    $("#saveLoading").html('<span class="text-danger">ไม่สามารถบันทึกข้อมูลได้<br>'+datas["save"]+'</span>');
                }
            }
        }
    });
});

function listsColumn(){
    var html = '<option value="-">ไม่มี</option>';
    $.each(alphabet, function(key, val){
        html += '<option value="'+key+'">'+val+'</option>';
    });
    $("#form2 select").each(function(){
        var col = $(this).attr("data-col");

        $(this).html(html).val(col).trigger("change");
    });
}

function dataObject(){
    var dataInfo = {};

    $("#form2 select").each(function (i) {
        var fname = $(this).attr("name");
        var fvalue = $(this).val();

        dataInfo[fname] = fvalue;
    });
    var fdata = {};
    fdata["Column"] = dataInfo;

    return fdata;
}

function toggleShow(option){
    if(option == "form"){
        $("#form2 select").each(function (i) {
            $(this).val('');

            $("#"+$(this).attr("name")+"Div").html("-");
        });

        $("#fileNameDisplay").html('');
        $("#table tbody").html('<tr><td colspan="16" class="text-center">-</td></tr>');

        $("#readLoading, #saveLoading").html('');
    }
}