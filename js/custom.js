'use strict';

document.addEventListener('DOMContentLoaded', function () {

  /* Prevents user from entering paragraphs into the 'summary' text area on the Add modal. 
  This was needed due to a bug where jQuery couldn't pass through the summary as a paragraph with linebreaks as a value to the onClick of the updateModal - Code found and adapted from https://stackoverflow.com/questions/302122/jquery-event-keypress-which-key-was-pressed */
  $("#summary").keypress(function(e) {
    if (e.which == 13) 
    {
      e.preventDefault();
    }
  });
  $("#updateSummary").keypress(function(e) {
    if (e.which == 13) 
    {
      e.preventDefault();
    }
  });

  /* Needed to create my own Javascript/jQuery for certain aspects of the project as Bulma currently doesn't have an associated JS file for their CSS. I found out how to add classes to the target element online however I cannot find the link again */

  $(document).on('click', '.modal-button-edit', function (e) { 
    $("#updateModal").addClass("has-modal-open");
    $("#updateModal").addClass("is-active");
  });
  
  $(document).on('click', '.cancelEdit', function (e) { 
    $("#updateModal").removeClass("has-modal-open");
    $("#updateModal").removeClass("is-active");
  });

  $(document).on('click', '.cancelAdd', function (e) { 
    $("#modal").removeClass("has-modal-open");
    $("#modal").removeClass("is-active");
  });

  $(document).on('click', '.cancelEdit', function (e) { 
    $("#updateModal").removeClass("has-modal-open");
    $("#updateModal").removeClass("is-active");
  });

  $(document).on('click', '.cancelDelete', function (e) { 
    $("#deleteModal").removeClass("has-modal-open");
    $("#deleteModal").removeClass("is-active");
  });

  $(document).on('click', '.modal-button', function (e) { 
    $("#modal").addClass("has-modal-open");
    $("#modal").addClass("is-active");
  });
  $(document).on('click', '.delete', function (e) { 
    $("#modal").removeClass("has-modal-open");
    $("#modal").removeClass("is-active");
  });

  //Removes classes when background around the modal is clicked
  $('.modal-background, .modal-close').click(function() {
      $('html').removeClass('has-modal-open');
      $(this).parent().removeClass('is-active');
  });  
});