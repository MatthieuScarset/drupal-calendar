(function () {
  Drupal.behaviors.autosubmitForm = {
    attach: function (context) {
      once('form-autosubmit', '[data-autosubmit]', context).forEach(function (el) {
        const parentForm = el.form;

        // Submit form when input change.
        el.addEventListener('change', function (event) {
          parentForm.submit();
        })
      });
    }
  }
})(Drupal, once);
