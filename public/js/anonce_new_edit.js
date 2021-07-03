$('#add_image').click(function(){
    const index=+$('#widgets-counter').val();
    const tmpl=$('#anonce_images').data('prototype').replace(/_name_/g,index);
    $('#anonce_images').append(tmpl);
    $('#widgets-counter').val(index+1);
    handleDeleteButtons();
});
function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target=this.dataset.target;
        $(target).remove();
    });
}
function updateCounter(){
    const count=+$('#anonce_images div.form-group').length;
    $('#widget-counter').val(count);
}
updateCounter();
handleDeleteButtons();