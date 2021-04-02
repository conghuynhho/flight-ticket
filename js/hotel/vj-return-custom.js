$('.booking-vj-return-item-container').children('.booking-vj-return-item').click(function(event) {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).parent().removeClass('active');
    } else {
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $(this).delay(1500).queue(function() {
            $(this).addClass('viewed')
        });
    }
});