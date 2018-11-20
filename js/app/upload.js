$(document).ready(function()
{
 $("#drop-area").on('dragenter', function (e){
  e.preventDefault();
  $(this).css('background', '#BBD5B8');
 });

 $("#drop-area").on('dragover', function (e){
  e.preventDefault();
 });

 $("#drop-area").on('drop', function (e){
  $(this).css('background', '#D8F9D3');
  e.preventDefault();
  var files = e.originalEvent.dataTransfer.files;
  createFormData(files);
 });
});

function createFormData(files)
{
 var formImage = new FormData();
 formImage.append('foldId',$("#foldId").val());
 formImage.append('ufiles', files[0]);
 uploadFormData(formImage);
}

function uploadFormData(formData) 
{
 $.ajax({
 url: "/app/upload.php",
 type: "POST",
 data: formData,
 contentType:false,
 cache: false,
 processData: false,
 success: function(data){
    // var json = $.parseJSON(data);
  $('#drop-area').html(data);
 }});
}