$(function(){
  var activeProject = $('.project-bar li.active');
  var targetProject = '#' + activeProject.data('target');
  $(targetProject).show();
});

$('.project-bar li').click(function(){
  $('.project-list .project-content').hide();
  $('.project-bar li').removeClass('active');
  $(this).addClass('active');
  var target = '#' + $(this).data('target');
  $(target).show();
});
