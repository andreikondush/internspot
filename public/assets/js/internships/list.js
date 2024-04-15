function sort(element) {

    const sort = $(element).attr('data-sort');
    const type = $(element).attr('data-type');

    const sortButton = $(element).find('.sort_button');

    $(sortButton).find('.top, .bottom').removeClass('active');

    switch (sort) {
        case 'desc':

            $(sortButton).find('.bottom').addClass('active');
            $(element).attr('data-sort', 'asc');

            break;
        case 'asc':

            $(element).attr('data-sort', 'default');

            break;

        default:

            $(sortButton).find('.top').addClass('active');
            $(element).attr('data-sort', 'desc');

    }

    let sortValue = '';

    if (sort === 'default') {
        sortValue = 'desc'
    } else if (sort === 'desc') {
        sortValue = 'asc'
    } else if (sort === 'asc') {
        sortValue = '';
    }

    switch (type) {
        case 'score':

            $('form.search').find('input[name="sort_by_score"]').val(sortValue).trigger('input');

            break;
        case 'feedbacks':

            $('form.search').find('input[name="sort_by_feedbacks"]').val(sortValue).trigger('input');

            break;

        case 'date':

            $('form.search').find('input[name="sort_by_date"]').val(sortValue).trigger('input');

            break;

    }
}

document.addEventListener("DOMContentLoaded", () => {

    $('select[name="city"]').select2({
        placeholder: "Select city",
        allowClear: true
    });

    $('select[name="company"]').select2({
        placeholder: "Select company",
        allowClear: true
    });

    $('select[name="tags\[\]"]').select2({
        placeholder: "Select tags",
        allowClear: true
    });
});
