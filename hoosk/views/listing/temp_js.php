
<div id="addressEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?= base_url().$ControllerRouteName.'/'; ?>previewValueUpdate" method="post">
                <input type="hidden" name="id" value="<?=$detail->id?>">
                <input type="hidden" name="updateType" value="address">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Address Details</h4>
                </div>
                <div class="modal-body">
                    <?php
                   // $this->data['selectors'] = $addressPostCodeValue;
                     $this->load->view('structure/modal_addressfields', $this->data);

                    ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" id="updateAddressBtn">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</form>
</div>

</div>
</div>
<div id="socialLinksEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="<?= base_url().$ControllerRouteName.'/'; ?>previewValueUpdate" method="post">
                <input type="hidden" name="id" value="<?=$detail->id;?>">
                <input type="hidden" name="userID" value="<?=$detail->userID;?>">
                <input type="hidden" name="updateType" value="socialLinks">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Social Links Details</h4>
                </div>
                <div class="modal-body">
                    <?php
                    // $this->data['selectors'] = $addressPostCodeValue;
                    $this->load->view('structure/modal_socialLinksFields', $this->data);
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="updateSocialLinksBtn">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    //$("body #Logo-file").change(function(){
    $(document).on('change',"body #Logo-file", function(){
        var input = this;
        readURL(input,'body #Logo-show');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var formData = new FormData();
                formData.append('logo', input.files[0]);
                formData.append('id', <?= $detail->id;?>);
                $.ajax({
                    crossOrigin: true,
                    type: 'POST',
                    url: baseUrl + "admin/<?=$this->ControllerRouteManage?>/updateLogo",
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(function (response) {
                    var data = response.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {

                    }
                    if(data[3]){
                        Haider.notification(data[1],data[2],data[3]);
                    }else{
                        Haider.notification(data[1],data[2]);
                    }
                });

            };
            reader.readAsDataURL(input.files[0]);
        }
    });
   // $("body #Banner-file").change(function(){
    $(document).on('change',"body #Banner-file",function(){
        var input = this;
        readURL(input,'body #Banner-show');
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var formData = new FormData();
                formData.append('banner', input.files[0]);
                formData.append('id', <?= $detail->id;?>);
                $.ajax({
                    crossOrigin: true,
                    type: 'POST',
                    url: baseUrl + "admin/<?=$this->ControllerRouteManage?>/updateBanner",
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(function (response) {
                    var data = response.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {

                    }
                    if(data[3]){
                        Haider.notification(data[1],data[2],data[3]);
                    }else{
                        Haider.notification(data[1],data[2]);
                    }
                });

            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    //Code From Haider.
    $(document).on('mouseover','.editable-input', function(){
        $(this).find('span').show();
    });
    $(document).on('mouseout','.editable-input', function(){
        var h3 = $(this).find('h3');
        var contentEditable = h3.attr('contenteditable');
        if(typeof contentEditable !== typeof undefined && contentEditable !== false){
        }else{
            $(this).find('span').hide();
        }
    });
    //$('.editable-input span').on('click','i.fa-pencil',function(){
    $(document).on('click','.editable-input span i.fa-pencil',function(){
        var clickedPencil = $(this);
        var mainInputDiv = clickedPencil.parents('.editable-input');
        var editType = mainInputDiv.attr('data-edit');
        switch(editType){
            case 'input':
                var h3 = mainInputDiv.find('h3');
                h3.addClass('inputContentEditable');
                h3.attr('contenteditable','true');
                /*               clickedPencil.removeClass('fa-pencil');
                 clickedPencil.addClass('fa-check');
                 clickedPencil.addClass('text-green');*/
                clickedPencil.parent('span').append('<i class="fa fa-check text-green"></i>');
                clickedPencil.parent('span').append('<i class="fa fa-times text-red"></i>');
                clickedPencil.remove();
                break;
            case 'address':
                //For Address we need to show the Address Modal.
                $('#addressEditModal').modal('show');
                break;
            case 'textarea':
                var p = mainInputDiv.parents('.description').find('.short-descrp').find('p');
                p.addClass('inputContentEditable');
                p.attr('contenteditable','true');
                clickedPencil.parent('span').append('<i class="fa fa-check text-green"></i>');
                clickedPencil.parent('span').append('<i class="fa fa-times text-red"></i>');
                clickedPencil.remove();

        }
    });
//    $('.editable-input').on('click','', function(e){
      $(document).on('click','.editable-input .inputContentEditable',function(e){
        e.preventDefault();
    });
    //$('span').on('click','i.fa-check',function(){
    $(document).on('click','span i.fa-check',function(){
        // var updatedText = $(this).parents('.editable-input').find('h3').text();
        var mainDiv = $(this).parents('.editable-input');
        if(mainDiv.attr('data-edit') == 'textarea'){
            var updatedText = mainDiv.parents('.description').find('.short-descrp').find('p').text();
            var textContainer = mainDiv.parents('.description').find('.short-descrp').find('p');
        } else {
            var updatedText =  mainDiv.find('h3').text();
            var textContainer = mainDiv.find('h3');
        }
        var actionSpan = mainDiv.find('span');
        var colName = mainDiv.attr('data-column');
        var data = {name:colName,val:updatedText,id:<?=$detail->id;?>};
        $.ajax({
            url:"<?=base_url().$ControllerRouteName.'/';?>previewValueUpdate",
            type:"POST",
            data:data,
            success:function(output){
                var data = output.split('::');
                if(data[0].split(' ').join('') == 'OK'){
                    //Remove the Additional Work for Making the Div in Edit Mode.
                    textContainer.removeAttr('contenteditable');
                    textContainer.removeClass('inputContentEditable');
                    //now fix back the icons
                    //removed the additional cross icon
                    mainDiv.find('span i.fa-check').remove();
                    mainDiv.find('span i.fa-times').remove();
                    actionSpan.append('<i class="fa fa-pencil"></i>');
                    //Notify the User
                    Haider.notification(data[1],data[2]);
                }else if(data[0].split(' ').join('') == 'FAIL'){
                    //Notify the User
                    Haider.notification(data[1],data[2]);
                }
            }
        });
    });
    //$('span').on('click','i.fa-times',function(){
    $(document).on('click','span i.fa-times',function(){
        var mainDiv = $(this).parents('.editable-input');
        var h3 = mainDiv.find('h3');
        //Remove the Additional Work for Making the Div in Edit Mode.
        h3.removeAttr('contenteditable');
        h3.removeClass('inputContentEditable');

        mainDiv.parents('.description').find('.short-descrp').find('p').removeAttr('contenteditable').removeClass('inputContentEditable');
        //now fix back the icons
        //removed the additional cross icon
        $(this).remove();
        mainDiv.find('span i.fa-check').remove();
        //chec icon moved back to pencil icon
        var actionSpan = mainDiv.find('span');
        actionSpan.append('<i class="fa fa-pencil"></i>');
    });
    //Code for Modal.
   // $('#updateAddressBtn').on('click',function(){
    $(document).on('click','#updateAddressBtn', function(){
        var form = $(this).parents('form');
        var postData = form.serializeArray();
        $.ajax({
            url:form.attr('action'),
            type:form.attr('method'),
            data:postData,
            success:function(output){
                var data = output.split('::');
                if(data[0].split(' ').join('') == 'OK'){
                    form.parents('.modal').modal('hide');
                }
                //Throw the Message to User.
                Haider.notification(data[1],data[2]);
            }
        });
    });
    //Code for Social Links
    // $('.main-social-container').on('mouseover',function(){
    $(document).on('mouseover','.main-social-container', function(){
        var editSpan = $(this).find('#editSocialDetailsSpan');
        editSpan.show();
    });
        //$('.main-social-container').on('mouseout',function(){
    $(document).on('mouseout','.main-social-container', function(){
        var editSpan = $(this).find('#editSocialDetailsSpan');
        editSpan.hide();
    });
    $(document).on('click','.main-social-container span#editSocialDetailsSpan a',function(e){
        e.preventDefault();
        $('#socialLinksEditModal').modal('show');
    });
   // $('#updateSocialLinksBtn').on('click',function(){
    $(document).on('click','#updateSocialLinksBtn', function(){
        var form = $(this).parents('form');
        var postData = form.serializeArray();
        var modal = $(this).parents('.modal');
        $.ajax({
            url:form.attr('action'),
            type:form.attr('method'),
            data:postData,
            success:function(output){
                var data = output.split('::');
                //If SUccess Just Hide the Modal.
                if(data[0].split(' ').join('') == 'OK'){
                    modal.modal('hide');
                }
                //Notify the User about the Update.
                Haider.notification(data[1],data[2]);
            }
        })
    });
    $(document).on('change', '#address_state', function (e) {
        var $state = $(this).val();
        var $postCodesURL = '<?= base_url('get_post_codes')?>';
        var $selector = $('select[name="address_post_code"]');
        console.log($selector.val());
        getPostCodes($selector, $postCodesURL, $state);
    })
</script>