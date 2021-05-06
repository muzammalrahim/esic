<?php 
  if(isset($contentPage) && !empty($contentPage)){
      $Json = $contentPage->ContentJson;
      $Content = $contentPage->Content;
  }else{  // not working

      $Json = '';
      $Content = '';
  } // added by hamid
  if(empty($Json) && !isset($Json)) {
       $Json = '{"data":[{"type":"text","data":{"text":"<p style=\"text-align: left;\" data-mce-style=\"text-align: left;\"><span style=\"font-size: 18px;\" data-mce-style=\"font-size: 18px;\">Well come You can Build/Design your Profile page using page builder</span></p>","isHtml":true}}]}';
  }
 else{
     $Json = $Json ;
 }
 ?>
<link href="<?php echo ADMIN_THEME; ?>/js/trevor/sir-trevor.css" rel="stylesheet">
<link href="<?php echo ADMIN_THEME; ?>/js/trevor/sir-trevor-bootstrap.css" rel="stylesheet">
<link href="<?php echo ADMIN_THEME; ?>/js/trevor/sir-trevor-icons.css" rel="stylesheet">

<div id="pageBuilder-content">
    <form  method="POST" action="<?=BASE_URL.'/admin/'.$this->ControllerRouteName.'/savedesc'?>" id="descriptionPage">
        <input type="hidden" id="listingPageContentID" name="uID" value="" >
        <div class="">
            <textarea class="js-st-instance" id="desc-content" name="desc-content">
            <?= htmlentities($Json);?>
            </textarea>
         </div>
    </form>
    <div class="pagebuilder-action-button">
            <?php if(isset($templates) && !empty($templates)){ ?>
                <div class="form-group template-selectbox">
                    <select id="templateFlagBox" name="template" class="form-control select2-active" data-placeholder="Select Template">
                    <option></option>
                        <?php foreach($templates as $key => $value) {
                            $tempSelected  = '';
                             if($value->id == $templateSelectedID){
                                $tempSelected  = 'SELECTED';
                             }
                            ?>
                            <option value="<?= $value->id;?>" <?=$tempSelected;?> ><?= $value->name;?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        <button type="button" class="btn btn-primary" id="preview-content">Preview</button>
        <button type="button" class="btn btn-primary" id="save-content">Save</button>
        <button type="button" class="btn btn-primary" id="save_nd_close">Close</button>
    </div>
</div>
<div id="page-builder-preview-content" style="display: none;">
  <?= $Content;?>
</div>
<div id="page-builder-actions">
  <button type="button" class="btn btn-primary close-preview" style="display: none;">Close</button>
</div>

 <!-- /container -->
      <!--bower work-->
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/bower_components/es5-shim/es5-shim.js" type="text/javascript" charset="utf-8"></script>
      <!-- es6-shim should be bundled in with SirTrevor for now -->
      <!-- <script src="../node_modules/es6-shim/es6-shim.js" type="text/javascript" charset="utf-8"></script> -->
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/bower_components/jquery/dist/jquery.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/sir-trevor.js" type="text/javascript"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/bower_components/sir-trevor-columns-block/dist/sir-trevor-columns-block.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/bower_components/underscore/underscore.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/iFrame.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/image-extended.js" type="text/javascript" charset="utf-8"></script>
      <!--TinyMCE-->
      <script src="<?= base_url();?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/mce/sir-trevor-tinymce.js" type="text/javascript" charset="utf-8"></script>
      <script src="<?php echo ADMIN_THEME; ?>/js/sirTrevor/Button.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/vendors/select2/dist/js/select2.full.js" type="text/javascript"></script>


<!--Scripts From Listing Page-->
<script  defer="defer" type="text/javascript" src="<?php echo ADMIN_THEME; ?>/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<!-- Custom Notifications From Haider Plugin -->
<script  defer="defer" type="text/javascript" src="<?php echo ADMIN_THEME; ?>/js/Haider.js"></script>

      <script src="<?php echo base_url(); ?>assets/js/listing.js" type="text/javascript"></script>
      <script type="text/javascript">
       $(function(){
        
           SirTrevor.config.debug = false;
           SirTrevor.config.scribeDebug = false;
           SirTrevor.config.language = "en";
           SirTrevor.setBlockOptions("Text", {
               onBlockRender: function() {
                   
               }
           });
           window.editor = new SirTrevor.Editor({
               el: $('.js-st-instance'),
               blockTypes: [
                   "Columns",
                   "Text",
                   "List",
                   "Quote",
                   "ImageExtended",
                   "Video",
                   "Tweet",
                   "Button",
                   "Iframe"
               ]
           });

           SirTrevor.onBeforeSubmit();
       });
       function formSubmit(){
           SirTrevor.onBeforeSubmit();
           //document.getElementById("descriptionPage").submit();
       }
        $('#save-content').click(function(event){
             event.preventDefault();
             formSubmit();
            var uID = '<?= $listingID;?>';
            var descContent = $('#desc-content').val();
            var template    = $('#templateFlagBox').val();
            if(template == null || template == ''){
                template = 1;
            }
            var dataPost = {
                listingID: uID,
                'desc-content': descContent,
                'template' : template
            };
            $.ajax({
                url: base_url+'admin/<?=$this->ControllerRouteName;?>/savedesc',
                type: 'POST',
                data: dataPost,
                success:function(output){
                    var data= output.trim().split('::');
                    if(data[0].split(' ').join('') === 'OK'){
                        window.opener.parentWindowConfigurations();
                        Haider.notification(data[1],data[2]);
                        // check user logged in
                        if(typeof data[4]!= 'undefined'){
                            var parentBtn = $('.after-complete' ,opener.document);
                            var parentMsgDiv = $('.complete-message', opener.document);
                            parentBtn.css('display','inline-block');
                            parentMsgDiv.show();
                            parentMsgDiv.html(data[5]);
                            if(data[4]== 1){
                                parentBtn.html('<a href="<?=BASE_URL.'/admin'?>" class="btn btn-block btn-flat btn-primary">Dashboard</a>');
                            } else {
                                parentBtn.html('<a href="<?=BASE_URL.'/login'?>" class="btn btn-block btn-flat btn-primary">Login</a>');
                            }
                        } // else of outer if
                    }else if(data[0].split(' ').join('') === 'FAIL'){
                        Haider.notification(data[1],data[2]);
                    }
                    
                }
            });
        });



        $('#preview-content').click(function(event){
            event.preventDefault();
            formSubmit();
            var uID = '<?= $listingID;?>';
            var descContent = $('#desc-content').val();
            var template    = $('#templateFlagBox').val();
            if(template == null || template == ''){
              template = 1;
            }
            var dataPost = {
              listingID: uID,
              'desc-content': descContent,
              'template' : template
            };
             $.ajax({
                url: base_url+'admin/<?=$this->ControllerRouteName;?>/getPreview',
                type: 'POST',
                data: dataPost,
                success:function(output){
                    //output = jQuery.parseJSON(output);
                    $('body').addClass('database-listing listing-detail');
                    $('#page-builder-preview-content').html(output);
                    $('#pageBuilder-content').hide();
                    $('#page-builder-preview-content').show();
                    $('.close-preview').show();
                }
            });
        });
        $('.close-preview').click(function(event){
             event.preventDefault();
            $('#pageBuilder-content').show();
            $('#page-builder-preview-content').hide();
            $('.close-preview').hide();
        });

          // save and close function
          $(document).on('click', '#save_nd_close', function(e){
              window.close();
          })
   </script>
