// https://newbedev.com/how-to-prevent-form-resubmission-when-page-is-refreshed-f5-ctrl-r
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}