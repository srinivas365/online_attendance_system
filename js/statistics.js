$(document).ready(function() {
  $('.list').hide();
  //$('#detained').hide();
  $('.classes').click(function() {
    $('.classes').css('font-weight','');
    if($(this).find('.list').css('display') == 'block') {
      $('.list').slideUp('fast');
    } else {
      $(this).css('font-weight','bold');
      $('.list').slideUp('fast');
      $(this).find('.list').slideDown('fast');
    }      
  });
});