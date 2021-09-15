$(document).ready(function () {
    $.each($('.mnu-box a'), function( index, value ) {

       if($($(this).attr('href')).length === 0){
           $(this).closest('li').remove();
       }
    })
})
$(document).on('click','.overlay, .close',function () {
    let $this = $(this);
    if($this.data('reload') === 'Y'){
        if($this.data('reload_href')){
            location.href = $this.data('reload_href');
        }else{
            location.reload();
        }


    }
})