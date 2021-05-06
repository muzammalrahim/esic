<?php 
if(isset($prePopulated)){ ?>
<div class="col-blocks col-xs-12 col-sm-6 <?=$gridDesktop;?> subquestions username question-statement subQuestion prePopulated <?=$subItemID?>_s <?=$ItemID?>_s" 
        data-id= "<?= $prePopulated['listingID'];?>"
        data-questionID= "<?= $questionID; ?>" 
        data-subquestionID= "<?= $subQuestionID; ?>" 
        data-type= "<?= $type; ?>" 
         style="display:none">
            <div class="from-group">
                <?php
                    if(isset($prePopulated['providedSolution']) and !empty($prePopulated['providedSolution'])){
                        //Only then just loop it.
                        $providedSolution = $prePopulated['providedSolution'];
                        $listingTypesIDs = array_column($providedSolution,'listTypeID');
                    }
                    if(!empty($prePopulated['data'])){
                       // echo '<label>Select from '. $prePopulated['label'] .'</label>';
                        if(!empty($listingTypesIDs) and in_array($prePopulated['listingID'],$listingTypesIDs)){
                            $hasInList = true;
                        }
                         
                          if($Multi == 'true'){ // Why the hell i have to check true like that
                              $MultiClass = "select2-active js-example-basic-multiple"; 
                              $Multiple = 'Multiple';
                          }else{
                             $MultiClass = '';
                             $Multiple   = '';
                          }
                      ?>
                         <select class="form-control <?=$MultiClass;?>" <?=$Multiple;?> name="" style="width:100%;" data-placeholder="<?= 'Select from '. $prePopulated['label'];?>" >
                        <?php
                        echo '<option value="0">Select</option>';
                        foreach($prePopulated['data'] as $key=>$row){
                            if(isset($hasInList) and $hasInList===true){
                                $where = [
                                    'selectedItemID'=>$row->ID,
                                    'listTypeID'=>$prePopulated['listingID']
                                ];
                                if(!empty($returned = findWhere($providedSolution,$where))){
                                    $selected = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                            }
                            echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->Name.'</option>';
                        }//End of foreach
                        ?>
                        </select>
                    <?php
                    }
                ?>
            </div>
</div>

<?php 
unset($prePopulated);
//TO Avoid Duplicates
} 
?>
