(function ($, Drupal) {
  'use strict';
  Drupal.AjaxCommands.prototype.showalert = function (ajax, response, status) {
    alert(drupalSettings.ws_ajax_add_to_cart.alert_message);
  };
  Drupal.AjaxCommands.prototype.showfancy = function (ajax, response, status) {
    $.fancybox.open({
      src  : drupalSettings.ws_ajax_add_to_cart.selector,
      type : 'inline'
    });
    if (drupalSettings.ws_ajax_add_to_cart.time > 0)
      setTimeout(function () {
        $.fancybox.close({
          src  : drupalSettings.ws_ajax_add_to_cart.selector
        });
      }, drupalSettings.ws_ajax_add_to_cart.time);
  };
  Drupal.AjaxCommands.prototype.setactive = function (ajax, response, status) {
    $(drupalSettings.ws_ajax_add_to_cart.selector).addClass("active");
    if (drupalSettings.ws_ajax_add_to_cart.time > 0)
      setTimeout(function () {
        $(drupalSettings.ws_ajax_add_to_cart.selector).removeClass("active");
      }, drupalSettings.ws_ajax_add_to_cart.time);
  };
})(jQuery, Drupal);
