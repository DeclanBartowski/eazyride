function changeMark (){
    let id = $('[name=MARK]').val();
    $.ajax({
        type: "post",
        url: '/api/2quick/ajax/index.php',
        data: {action:'auto',data:{id:id}},
        success: function (data) {
            $('[name = MODEL]').html(data.result).change();
            $(".rev-select-box").RevSelectBox();
            $("select").RevSelectBox();
        }
    });
}
$(document).ready(function () {
    changeMark();
    $(document).on('change','[name=MARK]',function () {
        changeMark();
    })
})
