document.addEventListener("DOMContentLoaded", () => {

    $('select[name="city"]').select2({
        allowClear: true
    });

    $('select[name="company_name"]').select2({
        allowClear: true,
        tags: true
    });
});
