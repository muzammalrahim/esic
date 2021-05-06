<?php
    $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
    $HTTP_REFERER = str_replace(base_url(),'',$HTTP_REFERER);
    $RegLabel = 'Register';

    if(isUserLoggedIn($this)){
        $RegLabel = 'Account';
    }else if( $HTTP_REFERER == 'Register/createmember'){
        $RegLabel = 'Login';
    }else{
        $RegLabel = 'Register';
    }
?>
         <div class="row">
           <div class="col-blocks col-md-12 text-center">
                <div class="button-center-container steps-layout">
                 <a href="#" id="step-reg" class="btn btn-primary active"><?=$RegLabel;?></a>
                        <i class="fa fa-hand-o-right"></i>
                    <a href="#" id="step-sub" class="btn btn-primary"><?= $this->NameMessage;?> Listing</a>
                    <?php if($this->hasQuestionaire){ ?>   
                        <i class="fa fa-hand-o-right"></i>
                     
                        <a href="#" id="step-cho" class="btn btn-primary">Choose Option</a>
                    <?php } ?> 
                    <!-- <i class="fa fa-hand-o-right"></i>
                    <div class="btn-group">
                        <a href="#" id="step-page" class="btn btn-primary">Page Builder</a>
                         <?php
/*                         if ($this->hasQuestionaire) {
                             */?>
                             <a href="#" id="step-question" class="btn btn-primary">Questionnaire</a>
                             <?php
/*                         }
                         */?>

                    </div>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-blocks col-md-12">
                <form id="ListingForm" action="<?= base_url().$ControllerRouteName.'/New';?>" method="post" class="form" enctype="multipart/form-data">
                    <div class="">
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <div id="step-registration" class="steps step-1 registration" style="display:block;">
                                    <!-- Blade Version Of Codeigniter -->
                                    <?= $userFieldsView; ?>
                                </div>
