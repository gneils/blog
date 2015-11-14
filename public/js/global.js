$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

$(document).ready(function(){
    $('.modalphotos img').on('click', function() {
        $('.modal').modal({
            show: true,
        })
        var mysrc = this.src      
        $('#modalimage').attr('src', mysrc);
        $('#modalimage').on('click', function() {
            $('.modal').modal('hide');
        })
    });
});
    