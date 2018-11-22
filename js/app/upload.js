$(document).ready(function(){
   uploadFormData = new FormData();
   totupsize = 0;
  $("#drop-area").on("dragenter",function(e){
    e.preventDefault();
    $(this).css('background','rgba(220,250,220,0.8)');
  });
  $("#drop-area").on("dragover",function(e){
    $(this).css('background','rgba(220,250,220,0.8)');
    e.preventDefault();
  });
  $("#drop-area").on("drop",function(e){
    $(this).css('background','rgba(220,240,250,0.8)');
    e.preventDefault();
    var files = e.originalEvent.dataTransfer.files;
    createFormData(files);
  });
  $("#drop-area").on("drop",function(e){
    e.preventDefault();
  });  
  $(document).on("dragover",function(e){
    $("#drop-area").css('background','rgba(220,240,250,0.8)');
    e.preventDefault();
  });
  $(document).on("dragenter",function(e){
    $("#drop-area").css('background','rgba(220,240,250,0.8)');
    e.preventDefault();
  });
  $("#contentBox").on("click","#tgBt",function(e){
      $("#tree").show();
        getTreeData();
  });
  $("#contentBox").on("click","#svBt",function(e){
      $("#drop-area").toggle();
      totupsize = 0;
      $("#uploadList").empty();
      uploadFormData = new FormData();
      uploadFormData.append('foldId',$("#foldId").val());
  });
  view($("#foldId").val());

});
function createFormData(files){
  for(var i=0 ; i < files.length;i++){
      uploadFormData.append('ufiles[]',files[i]);
      $("#uploadList").append("<li>"+files[i].name+" ("+files[i].size+" byte)</li>");
      totupsize += files[i].size;
  }
}
function sendFormData(){
    if( totupsize > 8000000) {
        alert("한번에 첨할 수 있는 용량을 넘었습니다. 다시 시도하여 주시기 바랍니다."+totupsize);
        totupsize = 0;
        $("#uploadList").empty();
        uploadFormData = new FormData();
        $("#drop-area").hide();
        return;
    }
  $.ajax({
    url: "/app/upload.php",
    type: "POST",
    data: uploadFormData,
    contentType: false,
    cache: false,
    processData: false,
    success: function(data) {
      var json = $.parseJSON(data);
      var h= "";
      for (var i=0 ; i < json.length;i++){
          h += "" + json[i].file + " ["+json[i].stat+"] : " + json[i].msg + "\n"
      }
      alert(h)
      $("#drop-area").hide();
      view($("#foldId").val());
      
    }
  });
}
function getTreeData(){
     $.ajax({
    url: "/app/ajax.php",
    type: "POST",
    data: {"cmd":"getTreeData"},
    dataType:"json",
    success: function(json) {
      $("#tree").treeview({
          color:"#427812", 
          enableLinks:true, 
          data: json});
    }
  });
}
function view(fileid){
    //set navbar
    $.ajax({
        url: "/app/ajax.php",
        type: "POST",
        data: {"cmd":"getNavBar","id":fileid},
        dataType:"json",
        success: function(json) {
          $("#tree").hide();
          var svId = "";
          var htmldata = "";
          for (i=0; i < json.length ; i++){
              htmldata += "<li><a href=\"javascript:view('" + json[i].id + "')\">" +json[i].name + "</a></li>";
              $("#foldId").val(json[i].id);
              $fold_id = json[i].id;
          }
          $("#navdata").html(htmldata);
          $("#foldId").val($fold_id);
        }
    });
        //set File List

        $.ajax({
        url: "/app/ajax.php",
        type: "POST",
        data: {"cmd":"getFileList","id":fileid},
        dataType:"json",
        success: function(json) {
          htmldata = "";
          for (i=0; i < json.length ; i++){
                htmldata += "<tr><td><a href=\"javascript:download('" +json[i].id + "')\">" +json[i].name + "</a></td>";
                htmldata += "<td>" +json[i].type + "</td>";
                htmldata += "<td>" +json[i].size + "</td>";
                htmldata += "<td>" +json[i].reg_dt + "</td>";
          }
          $("#filelist").html(htmldata);
        }
    });
}