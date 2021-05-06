<?php
if(isset($subQuestion) and !empty($subQuestion)){
    $questionID = $subQuestion->QuestionID;
    $Question   = $subQuestion->Question;
    $Solution   = $subQuestion->Solution;
    $answerID   = $subQuestion->AnswerID;
    if(!empty($Solution)){
      $solutionArray = json_decode($Solution,true);
      $subtype = $solutionArray['type'];
    }

    //Also Lets fetch the Provided Solution for the SubQuestion as well. if there is any.
    $listID = $this->uri->segment(4); //Previous it was a userID, so its been kept same as its not effecting the code. only the logic has been changed.
    $providedSolution = fetchUserQuestionProvidedAnswer($answerID,$listID,1); // 1 is for ESIC
    if(!empty($providedSolution)){
        $providedAnswer = json_decode($providedSolution->answer,true);
    }
  ?>
<div class="col-blocks col-xs-12 col-sm-12 col-md-12 subquestions username question-statement subQuestion <?=$subItemID?>_s <?=$ItemID?>_s" data-item-id=""  data-id="<?= $questionID ?>"
        data-questionID= "<?= $questionID; ?>" 
        data-type= "<?= $type; ?>" 
        data-subquestionID= "<?= $subQuestionID; ?>"  
        data-subtype= "<?= $subtype; ?>" 
         style="display:none">
            <div class="form-group bg-shaded clearfix">
                <div class="col-blocks col-xs-12 col-sm-12 col-md-6">
                  <label for="">
                    <?= $Question ?>
                  </label>
                </div>
                <span class="subQuestionPossibleSolutions">
                <?php
                    if(!empty($Solution) ){
                        $solutionArray = json_decode($Solution,true);
                        switch ($solutionArray['type']){
                            case 'radios':
                               $data = $solutionArray['data'];
                              if (!empty($data)) {
                                  foreach ($data as $key => $radio) {
                                      $radioID  = $radio['id'];
                                      $radioValue = $radio['value'];
                                      $radioText = $radio['text'];
                                      $radioName = explode('_', $radioID);
                                      //Remove the last item.
                                      $answserID = $radioName[2];
                                      unset($radioName[2]);
                                      //Join back the items
                                      $radioName  = implode('_', $radioName);
                                      $ItemNameID = $radioName;
                                     
                                ?>
                                  <div class="col-blocks col-xs-3 col-sm-2 col-md-1 questions" data-id="<?= $radioID;?>" data-type="radios">
                                      <div class="radio">
                                          <label for="<?= $radioID;?>">
                                            <input id="<?= $radioID; ?>" data-answer-id="<?=$answserID;?>" type="radio" value="<?= $radioValue;?>" name="<?= $radioName;?>">
                                              <?= $radioText;?>
                                          </label>
                                       </div>
                                  </div>
                              <?php
                                } 
                              } //End of If (If not empty possible solutions for a question)
                              break;
                            case 'CheckBoxes':
                                if(isset($providedAnswer) and !empty($providedAnswer) and $providedAnswer['type']==='checkbox'){
                                    $selectedCheckBoxes = $providedAnswer['selectedCheckBoxes'];
                                }
                               // echo '<br /><label>Please Select Answer</label>';
                                $data = $solutionArray['data'];
                                echo '<div class="form-group">';
                                foreach($data as $checkbox){
                                    if(isset($selectedCheckBoxes) and in_array_r($checkbox['id'],$selectedCheckBoxes) and in_array_r($checkbox['name'],$selectedCheckBoxes)){
                                        $checked = 'checked="checked"';
                                    }else{
                                        $checked = '';
                                    }
                                    ?>
                                    <div class="checkbox">
                                          <label>
                                            <input type="checkbox" name="<?=$checkbox['id']?>" id="<?=$checkbox['id']?>" <?=$checked?> value="<?= $checkbox['text'];?>">
                                                  <?=$checkbox['text']?>
                                          </label>
                                      </div>
                                    <?php
                                }
                                break;
                            case 'textBoxes':
                                 $data = $solutionArray['data'];

                                 echo '<div class=row>';
                                 $providedText = $providedAnswer['textboxes'];
                                 foreach($data as $key=>$textBox) {
                                     ?>
                                     <div class="col-blocks col-xs-3 col-sm-6 col-md-6" data-id="<?= $textBoxID;?>" data-type="textBoxes">
                                       <div class="form-group <?= $textBox['grid']['grid_size'] ?>">
                                           <label for="<?= $textBox['labelTextBox']['textBoxID'] ?>"><?= $textBox['labelTextBox']['label']?>
                                           </label>
                                           <input type="text" id="<?= $textBox['labelTextBox']['textBoxName'] ?>" 
                                                  name="<?= $textBox['labelTextBox']['textBoxName'] ?>" class="form-control"
                                                  value="<?= (!empty($providedText[$key]['changedValue']) ? $providedText[$key]['changedValue'] : '') ?>">
                                        </div>
                                     </div>
                                     <?php
                                 }//End of Foreach Loop
                                echo '</div>'; //end of row div.
                                break;
                            case 'SelectBox':
                                $label ='';
                                if(!empty($solutionArray['textBoxText'])){
                                    $label = '<label>'.$solutionArray['textBoxText'].'</label>';
                                }
                                if( isset($solutionArray['isDynamic'])
                                   && !empty($solutionArray['isDynamic']) 
                                   && $solutionArray['isDynamic'] === 'Yes'){
                                          $class='isDynamic';
                                }elseif( isset($solutionArray['isMulti']) 
                                  && !empty($solutionArray['isMulti'])
                                  && $solutionArray['isMulti'] === 'Yes'){
                                          $class='customSelect2';
                                }else{
                                    $class='';
                                }
                                $data = $solutionArray['data'];

                                ?>
                                 <div class="col-blocks col-xs-3 col-sm-8 col-md-8 SelectBox" data-id="<?= $questionID;?>" data-type="SelectBox">
                                <?= $label; ?>
                                <select class="form-control <?= $class;?> <?=((isset($solutionArray['isMulti']) && $solutionArray['isMulti'] === 'Yes')?'customSelect2':'')?>" <?=((isset($solutionArray['isMulti']) && $solutionArray['isMulti'] === 'Yes')?'multiple="multiple"':'')?> style="width:100%">
                                      <?php
                                      if(!empty($data)){
                                          foreach($data as $key => $selectOption){
                                            $selected = '';
                                            if(!empty($providedAnswer['selectedSelectValue'])){
                                              if(in_array($selectOption['value'],$providedAnswer['selectedSelectValue'])){
                                                  $selected='selected="selected"';
                                              }
                                            }
                                              echo '<option value="'.$selectOption['value'].'" '.(isset($selected)?$selected:'').'>'.$selectOption['text'].'</option>';
                                          }
                                      }
                                      ?>
                                  </select>
                                  </div>
                                <?php
                                break;
                        }//End of Switch
                    }//If Not Empty Solution.
                ?>
            </span>
          </div>
        </div>

<?php 
unset($subQuestion);
//TO Avoid Duplicates
} 
?>