function editFeedback(element, event) {

    event.preventDefault();

    const feedback = $(element).closest('.comment');

    if ($(feedback).find('label').length) {
        return;
    }

    let label = $('<label>').text('Text:');

    let textarea = $('<textarea>', {
        text: $.trim( $('.text').text() ),
        name: 'text',
        rows: 5,
    });

    $(textarea).appendTo(label);

    $(feedback).find('.text').replaceWith(label);

    let score = $(
        '<label>\n' +
            'Score\n' +
            '<input type="range" name="score" autocomplete="off" min="1" max="5" step="1">\n' +
            '<p class="current_score">\n' +
            '<p class="error score-error"></p>\n' +
        '</label>'
    );

    let currentScore = String($(feedback).find('.rate').text())[0];

    $(score).find('input').css({
        'padding': '0 3px',
        'cursor': 'col-resize'
    }).val( currentScore );

    $(score).find('.current_score').html(`<span>${currentScore}</span>/5</p>`);

    $(score).insertAfter(textarea);

    $(feedback).find('label').css({
        'display': 'inline-flex',
        'flex-direction': 'column',
        'width': '100%',
        'margin-top': '15px',
        'font-size': '12px',
        'line-height': 1,
    });

    $(feedback).find('.rate').hide();

    let button = $('<button>', {type: 'button'});
    $(button).text('Save').css({
        'margin-left': 'auto',
        'max-width': 75,
        'margin-top': 15,
    }).addClass('button save');

    $(button).insertAfter(score);
}

document.addEventListener("DOMContentLoaded", () => {

    $(document).on('change input', 'input[name="score"]', function () {
        let container = $(this).closest('label');
        $(container).find('.current_score span').html( $(this).val() );
    });

    (function () {
        $('input[name="score"]').trigger('input');
    })();

    $(document).on('click', '.comment button.save', function (event) {

        event.preventDefault();

        const $this = this;

        const feedback = $(this).closest('.comment');

        const feedbackId = $(feedback).attr('data-id');
        const text = $(feedback).find('textarea[name="text"]').val();
        const score = $(feedback).find('input[name="score"]').val();

        let formData = new FormData();
        formData.append('text', text);
        formData.append('score', score);

        $.ajax({
            url: '/feedbacks/edit/' + feedbackId,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function(){
                $($this).prop('disabled', true);
                $(feedback).find('input, textarea, select').removeClass('is-invalid').css({
                    'border-color': 'rgba(0, 0, 0, 0.15)',
                });
            },
            success: function(response) {

                if (response.status === true) {

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

                    $(feedback).find('.rate').text(`${score}/5`).show();

                    $(feedback).find('label').remove();

                    $('<p>', {
                        text: text,
                        class: 'text'
                    }).insertAfter( $(feedback).find('.name') );

                    $($this).remove();

                } else {

                    $($this).prop('disabled', false);

                    $.each(response.errors, function(prefix, value){

                        prefix = prefix.replace( ".", "-" );

                        if (typeof value === 'object') {
                            value = Object.values(value);
                        }

                        if (value[0] !== false && value[0] !== null && value[0] !== undefined && value[0] !== '') {
                            $(feedback).find('.' + prefix + '-error').text(value[0]);
                            $(feedback).find('.' + prefix + '-error').show();
                        }

                        $(feedback).find('[name="' + prefix + '"]').addClass('is-invalid').css({
                            'border-color': 'red'
                        });
                    });
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
});
