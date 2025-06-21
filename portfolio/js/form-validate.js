jQuery(document).ready(function ($) {
  $("#contact_form").validate({
    errorPlacement: function (error, element) {
      // thの直後にエラーを表示（スマホ対応も含む）
      if (window.matchMedia("(max-width: 768px)").matches) {
        var th = element.closest("td").prev("th");
        if (th.length) {
          error.insertAfter(th);
        } else {
          error.insertAfter(element);
        }
      } else {
        if (element.is(':radio')) {
          error.insertAfter(element.closest('.radio-group'));
        } else {
          error.insertAfter(element);
        }
      }
    }
  });
});
