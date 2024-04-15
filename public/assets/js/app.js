function updateDOM(container)
{
    let containerForUpdate = $( container );

    $.ajax({
        url: window.location.href,
        method: 'GET',
        success: function(response) {

            $(containerForUpdate).replaceWith( $(response).find(container) );

            // Update score
            if ($(response).find('.internshipScore').length) {
                $('.internshipScore').replaceWith( $(response).find('.internshipScore') );
            }
        },
    });
}

document.addEventListener("DOMContentLoaded", () => {

    (function () {
        $("input.tags").each(function( index, item ) {
            new Tagify(item);
        });
    })();

    $('body').on('submit', '.ajax-form', function(event) {

        event.preventDefault();

        const form = this;

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function(){
                $(form).find('.error').hide().text('');
                $(form).find('input, textarea, select').removeClass('is-invalid');
            },
            success: function(response) {

                if (response.status === false) {

                    $.each(response.errors, function(prefix, value){

                        prefix = prefix.replace( ".", "-" );

                        if (typeof value === 'object') {
                            value = Object.values(value);
                        }

                        if (value[0] !== false && value[0] !== null && value[0] !== undefined && value[0] !== '') {
                            $(form).find('.' + prefix + '-error').text(value[0]);
                            $(form).find('.' + prefix + '-error').show();
                        }

                        $(form).find('[name="' + prefix + '"]').addClass('is-invalid');
                    });

                    if (response.message) {

                        if (typeof response.title !== 'number' || typeof response.title !== 'string') {
                            response.title = "Oops...";
                        }

                        Swal.fire({
                            icon: 'error',
                            title: response.title,
                            text: response.message,
                            confirmButtonColor: '#217EDA'
                        })
                    }

                } else {

                    if (typeof response.title === 'string') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.title,
                            showConfirmButton: false,
                            timer: 2000,
                            confirmButtonColor: '#217EDA'
                        })
                    }
                }

                if (response.redirect) {
                    window.location.href = response.redirect;
                }

                if (response.update) {

                    updateDOM( $(form).attr('data-update') );
                }
            }

        }).fail(function (jqXHR, textStatus) {
            Swal.fire({
                icon: 'error',
                title: "Oops...",
                text: "The request failed or the server did not respond in time!",
                confirmButtonColor: '#217EDA',
            });
        });
    });

    (function () {

        if (typeof Quill !== 'function') {
            return;
        }

        var editorsSetting = {
            modules: {
                'toolbar': [
                    [ 'bold', 'italic', 'underline', 'strike' ],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'super' }, { 'script': 'sub' }],
                    [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
                    [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
                    [ 'direction', { 'align': [] }],
                    [ 'link', 'formula'],
                    [ 'clean' ],
                ],
                'imageResize': {},
                'imageDrop': true,
                'videoResize': {}
            },
            theme: 'snow'
        };

        $('.editor').each(function(index, item) {

            var quill = new Quill(item, editorsSetting);

            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                if (quill.getText().trim().length > 0 || quill.getContents()['ops'].length > 1) {
                    $(item).parents('label').find('textarea').val(html);
                } else {
                    $(item).parents('label').find('textarea').val('');
                }
            });
        });

    })();

    $(document).on('click', ".dropbtn", function (event) {

        event.preventDefault();

        const content = $(this).closest(".dropdown").find('.dropdown-content');

        if ($(content).css('display') === 'none') {
            $(content).slideDown();
        } else {
            $(content).slideUp();
        }
    });

    $(document).click(function (event) {
        if (!$(event.target).closest('.dropdown').length) {
            $(".dropdown-content").slideUp();
        }
    });

    $(document).on("click", '.remove', function (event) {
        var $this = this;
        event.preventDefault();
        Swal.fire({
            icon: 'question',
            title: "Are you sure?",
            text: "Are you sure you want to delete the selected element?",
            showCancelButton: true,
            confirmButtonColor: "red",
            cancelButtonText: "Cancel",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.value) {
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {

                    },
                    success: function (response) {

                        setTimeout(function () {

                            if (response.status === true) {

                                if ($($this).closest('table').length) {
                                    if ($('table tbody tr').length <= 1) {

                                        location.reload();

                                    } else {
                                        setTimeout(function () {
                                            Swal.fire(
                                                "Deleted!",
                                                "The selected element was successfully deleted.",
                                                'success'
                                            );
                                        }, 150);

                                        $($this).parents('tr').slideUp(function () {
                                            $(this).remove();
                                        });
                                    }

                                } else if ($($this).closest('.comments').length) {
                                    if ($($this).closest('.comments').find('.comment').length <= 1) {
                                        $($this).closest('.comments').slideUp();
                                    } else {
                                        $($this).closest('.comment').slideUp(function () {
                                            $(this).remove();
                                        });
                                    }
                                }

                            } else {

                                setTimeout(function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: "Oops...",
                                        text: "Failed to delete selected element!"
                                    });
                                }, 150);
                            }

                        }, 500);

                    }
                }).fail(function (jqXHR, textStatus) {

                    setTimeout(function () {

                        setTimeout(function () {
                            Swal.fire({
                                icon: 'error',
                                title: "Oops...",
                                text: "The request was not fulfilled or the service did not respond in time!"
                            });
                        }, 150);

                    }, 500);
                });
            }
        });
    });

    (function () {

        var timer;

        $('.search input, .search select, .search textarea').on('input change', function () {

            const $this = this;

            clearTimeout(timer);

            timer = setTimeout(function() {

                const form = $($this).closest('form.search').first()[0];

                $.ajax({
                    url: $(form).attr('action') + "?" + $(form).serialize(),
                    method: $(form).attr('method'),
                    data: new FormData( form ),
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        preloader.start( $('#result-search') );
                    },
                    success: function(response) {

                        $('#result-search').html( $(response).find('#result-search').html() );

                        preloader.stop( $('#result-search') );
                    }
                });
            }, 1000);
        });

    })();

});
