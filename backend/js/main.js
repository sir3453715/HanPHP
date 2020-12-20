

// tooltip
$('[data-toggle="tooltip"]').tooltip({
  delay: { "show": 300, "hide": 100 }
});

// modal
// hook: .modal-link
$('.modal-link').click(function(e) {
    e.preventDefault();
    var modal = $($(this).attr('data-toggle')), modalBody = modal.find('.modal-body');
    modal.on('show.bs.modal', function () {
      modalBody.load(e.currentTarget.href);
        }).modal();
});
$('.modal').on('hidden.bs.modal', function (e) {
  $(this).find('.modal-body').html('<p><i class="fa fa-refresh fa-spin"></i> Loading&hellip;</p>');
});

$('.navbar-menu').on('click', function(event) {
  event.preventDefault();
  if ($(window).width() > 767) {
    $('body').removeClass('sidebarAct2').toggleClass('sidebarAct1');
  } else {
    $('body').removeClass('sidebarAct1').toggleClass('sidebarAct2');
    $('body').toggleClass('is-lock');
  }
  // console.log($(window).width());
});


$(window).scroll(function(event) {
  var bodyScroll = $('body').scrollTop();
  var navbarHeight = $('.navbar').height();
  if (bodyScroll >= navbarHeight) {
    // console.log('fix');
    $('.wrapper').addClass('topbarfix');
  }
  // console.log($('body').scrollTop());
});

// Maskedinput
// http://digitalbush.com/projects/masked-input-plugin/
jQuery(function($){
 // $(".mask-date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
 // $(".mask-phone").mask("(999) 999-9999",{placeholder:"(999) 999-9999"});
 // $(".mask-mobile").mask("9999-999999",{placeholder:"9999-999999"});
 // $(".mask-tin").mask("99-9999999");
 // $(".mask-ssn").mask("999-99-9999");
 $(".mask-orderno").mask("999999",{placeholder:"999999"});
});

// alerts
$('.sweet-alert').on('click', function(event) {
  event.preventDefault();
  var sweetAlertTitle = $(this).attr('data-title');
  swal("Good job!", sweetAlertTitle, "success")
});

// Toast
var opts = {
  "closeButton": true,
  "newestOnTop": true,
  "debug": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};

// datetimepicker
// https://eonasdan.github.io/bootstrap-datetimepicker/
$(function () {
    $('.datetimepicker').datetimepicker();
});


// 自訂 Alert
function alertHtml(status) {
  if ($('.is-alert').length <= 0) {
    var alertHtml = '<div class="alert alert-'+ status +' is-alert" style="position:fixed;top:0;right:0;z-index:9999;opacity:0;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Well done!</strong> Alert message.</div>';
    $('body').prepend(alertHtml);
  }
  $('.is-alert').animate({opacity: 1}, 600, function() {
    $(this).delay(1000).animate({opacity: 0}, 600, function() {
      $(this).remove();
    });
  })
}
