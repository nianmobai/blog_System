/**
 * function: to prevents the page from going back
 * extraneous framework: jquery
 */
$(function () {
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
}) 