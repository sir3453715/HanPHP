
// clipboard
$(document).ready(function(){
  ZeroClipboard.config( { swfPath: "./assets/js/ZeroClipboard.swf" } );
  var client = new ZeroClipboard($(".btnCopy"));
  var copiedValue;
  var clipboardAlertOpts = {
    "closeButton": true,
    "newestOnTop": true,
    "debug": false,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "showDuration": "600",
    "hideDuration": "1000",
    "timeOut": "1000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  // API
  // 拷貝對像 : data-copy
  // 對像位置 : data-copy-pos -> outer(包含id對像本身的html) | text(網頁render後前台文字)
  client.on("copy", function (event) {
      var copiedTa = $(event.target).data('copy'),
          copieTaPos = $(event.target).data('copy-pos');
      if (copieTaPos == 'outer') {
        copiedValue = $(copiedTa)[0].outerHTML;
      } else if (copieTaPos == 'text') {
        copiedValue = $(copiedTa).text();
      } else {
        copiedValue = $(copiedTa).html();
      }
      var clipboard = event.clipboardData;
      clipboard.setData("text/plain", copiedValue);
      // alert('The copied value is: ' + copiedValue);
  });
  client.on( "aftercopy", function( event ) {
    if (event.data["text/plain"] == copiedValue) {
      toastr.success('語法已複製到剪貼簿!', null, clipboardAlertOpts);
    } else if ($(event.target).data('clipboard-text').length > 0) {
      toastr.success('語法已複製到剪貼簿!', null, clipboardAlertOpts);
    } else {
      toastr.error('複製失敗', null, clipboardAlertOpts);
    }
  });
})
