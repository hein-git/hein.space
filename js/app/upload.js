$(document).ready(function(){
  $("#drop-area").on("dragenter",function(e){
    e.preventDefault();
    $(this).css('background','#BBD5B8');
  });
  $("#drop-area").on("dragover",function(e){
    e.preventDefault();
  });
  $("#drop-area").on("drop",function(e){
    $(this).css('background','#D8F9D3');
    e.preventDefault();
    var files = e.originalEvent.dataTransfer.files;
    createFormData(files);
  });
  
  $("#contentBox").on("click","#tgBt",function(e){
      $("#tree").toggle();
  });
    view('ekxkaks');

});
function createFormData(files){
  var fd = new FormData();
  fd.append('foldId',$("#foldId").val());
  for(var i=0 ; i < files.length;i++){
      fd.append('ufiles[]',files[i]);
  }
  uploadFormData(fd);
}
function uploadFormData(formdata){
  $.ajax({
    url: "/app/upload.php",
    type: "POST",
    data: formdata,
    contentType: false,
    cache: false,
    processData: false,
    success: function(data) {
      var json = $.parseJSON(data);
      var h= "<ul>";
      for (var i=0 ; i < json.length;i++){
          h += "<li>" + json[i].file + " ["+json[i].stat+"] : " + json[i].msg + "</li>\n"
      }
      h += "</ul>";
      $("#drop-area").html(h);
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
function view(data){
    getTreeData();
    $.ajax({
        url: "/app/ajax.php",
        type: "POST",
        data: {"cmd":"getNavBar","id":data},
        dataType:"json",
        success: function(json) {
          $("#tree").toggle();
          var svId = "";
          var htmldata = "<nav class='navbar navbar-default' role='navigation'>";
          htmldata += "<div class='navbar-header'><a class='navbar-brand' href='#'>Home</a></div>";
          htmldata += "<div><ul class='nav navbar-nav'>";
          for (i=0; i < json.length ; i++){
              htmldata += "<li><a href=\"javascript:view('" + json[i].id + "')\">" +json[i].name + "</a></li>";
              $("#foldId").val(json[i].id);
          }
          htmldata += "</ul></div><div><p class='navbar-text navbar-right'><button type='button' class='btn btn-default' id='tgBt'>";
          htmldata += "<span class='glyphicon glyphicon-th-large'></span></button></p></div></nav>";
          $("#content").html(htmldata);
        }
    });
}