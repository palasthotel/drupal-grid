/**
 * The grid editor talks to the grid endpoints through jQuery. Its requests there
 * carry Drupal's CSRF token, which the routes require.
 */
(function ($, drupalSettings) {
  $.ajaxPrefilter(function (options, originalOptions, xhr) {
    var token = drupalSettings.grid && drupalSettings.grid.csrfToken;
    if (token && /\/grid_(ajax|file)_endpoint/.test(options.url || '')) {
      xhr.setRequestHeader('X-CSRF-Token', token);
    }
  });
})(jQuery, drupalSettings);
