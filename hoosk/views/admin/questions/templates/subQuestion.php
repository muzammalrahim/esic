<?php

if(isset($subQuestion) and !empty($subQuestion)){
    $questionID = $subQuestion->QuestionID;
    $Question = $subQuestion->Question;
    $Solution = $subQuestion->Solution;
    $type = $subQuestion->Type;
    $answerID = $subQuestion->AnswerID;

    //Also Lets fetch the Provided Solution for the SubQuestion as well. if there is any.
    $listID = $this->uri->segment(4); //Previous it was a userID, so its been kept same as its not effecting the code. only the logic has been changed.
    $providedSolution = fetchUserQuestionProvidedAnswer($answerID,$listID,(isset($listingTypeID))?$listingTypeID:1); // 1 is for ESIC

    if(!empty($providedSolution)){
        $providedAnswer = json_decode($providedSolution->answer,true);
    }
    ?>

    <div class="box-body">
        <div class="username question-statement subQuestion" data-id="<?= $questionID ?>">
            <a href="#"><?= $Question ?></a>
            <span class="subQuestionPossibleSolutions">
                <?php
                    if(!empty($Solution) ){
                        $solutionArray = json_decode($Solution,true);
                        switch ($solutionArray['type']){
                            case 'radios':
                                break;
                            case 'CheckBoxes':
                                if(isset($providedAnswer) and !empty($providedAnswer) and $providedAnswer['type']==='checkbox'){
                                    $selectedCheckBoxes = $providedAnswer['selectedCheckBoxes'];
                                }
                                echo '<br /><label>Please Select Answer</label>';
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
                                                  <input type="checkbox" name="<?=$checkbox['name']?>" id="<?=$checkbox['id']?>" <?=$checked?>>
                                                  <?=$checkbox['text']?>
                                              </label>
                                          </div>
                                    <?php
                                }
                                echo '</div>';
                                break;
                            case 'textBoxes':
                                 $data = $solutionArray['data'];

                                 echo '<div class=row>';
                                 $providedText = $providedAnswer['textboxes'];
                                 foreach($data as $key=>$textBox) {
                                     ?>
                                     <div class="form-group <?= isset($textBox['grid']['grid_size'])?'col-md-'.$textBox['grid']['grid_size']:''?>">
                                         <label for="<?= $textBox['labelTextBox']['textBoxID'] ?>"><?= $textBox['labelTextBox']['label']?></label>
                                         <input type="text" id="<?= $textBox['labelTextBox']['textBoxName'] ?>"
                                                name="<?= $textBox['labelTextBox']['textBoxName'] ?>" class="form-control"
                                                value="<?= (!empty($providedText[$key]['changedValue']) ? $providedText[$key]['changedValue'] : '') ?>">
                                     </div>
                                     <?php
                                 }//End of Foreach Loop
                                echo '</div>'; //end of row div.
                                break;
                            case 'SelectBox':
                                if(empty($solutionArray['textBoxText'])){
                                    echo '<br/><label>Please Select Answer</label>';
                                }else{
                                    echo '<br/><label>'.$solutionArray['textBoxText'].'</label>';
                                }
                                $data = $solutionArray['data'];

                                if(isset($solutionArray['isDynamic']) and !empty($solutionArray['isDynamic']) and  $solutionArray['isDynamic'] === 'Yes'){
                                    $class='isDynamic';
                                }elseif(isset($solutionArray['isMulti']) and !empty($solutionArray['isMulti']) and  $solutionArray['isMulti']=== 'Yes'){
                                    $class='customSelect2';
                                }else{
                                    $class='';
                                }
                                ?>
                                <select class="form-control <?=$class?>" <?=((isset($solutionArray['isMulti']) && $solutionArray['isMulti'] === 'Yes')?'multiple="multiple"':'')?> style="width:100%">
                                      <?php

                                      if ($class === 'isDynamic' and isset($providedAnswer['selectedSelectValue']) and !empty($providedAnswer['selectedSelectValue'])) {


                                          //There was a little Issue with my previous code, where answer of 1 sub-question was same parent Question of all.
                                          //But Now. Answer of a single subQuestion assigned to multiple parent questions will hold different answers respective to their parent question IDs

                                          //For This We need to check if there is a solution for this question or not.
                                          $providedUpdatedAnswer = array_filter($providedAnswer['selectedSelectValue'],function($providedSolutionArray) use($parentQuestionID){
                                              if(intval($providedSolutionArray['parentQID']) === intval($parentQuestionID)){
                                                return true;
                                              }
                                          });

                                          if(!empty($providedUpdatedAnswer)){
                                              //As Now we have gotten our selected Solution. We Just Need to Get the Values to Continue working with Old Code.
                                              $providedAnswer['selectedSelectValue'] = array_values($providedUpdatedAnswer)[0]['selectedValues'];
                                          }else{
                                              $providedAnswer['selectedSelectValue'] = [];
                                          }



                                          if(!empty($providedAnswer['selectedSelectValue'])){
                                              $possibleValuesDataArray = array_column($data,'value');
                                              foreach($providedAnswer['selectedSelectValue'] as $key=> $value){
                                                  if(!in_array($value,$possibleValuesDataArray)){
                                                      //push if not exist.
                                                      $arrayToPush = [
                                                          'value' => $value,
                                                          'text' => $value
                                                      ];
                                                      array_push($data,$arrayToPush);
                                                  }//End of If Statement/ If Not in Array.
                                              }//End of Foreach Statement
                                          }
                                      }//End of If type is Dynamic

                                      if(!empty($data)){
                                          foreach($data as $key => $selectOption){
                                              if(in_array($selectOption['value'],$providedAnswer['selectedSelectValue'])){
                                                  $selected='selected="selected"';
                                              }else{
                                                  $selected = '';
                                              }
                                              echo '<option value="'.$selectOption['value'].'" '.(isset($selected)?$selected:'').'>'.$selectOption['text'].'</option>';
                                          }
                                      }
                                      ?>
                                  </select>
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
}
if(isset($prePopulated)){?>
    <div class="box-body">
        <div class="username question-statement subQuestion prePopulated" data-id="<?=$prePopulated['listingID']?>">
            <div class="from-group">
                <?php
                    if(isset($prePopulated['providedSolution']) and !empty($prePopulated['providedSolution'])){
                        //Only then just loop it.
                        $providedSolution = $prePopulated['providedSolution'];
                        $listingTypesIDs = array_column($providedSolution,'listTypeID');
                    }
                    if(!empty($prePopulated['data'])){
                        echo '<label>Select from '. $prePopulated['label'] .'</label>';
                        if(!empty($listingTypesIDs) and in_array($prePopulated['listingID'],$listingTypesIDs)){
                            $hasInList = true;
                        }
                         if($Multi == 'true'){ // Why the hell i have to check true like that
                              $MultiClass = "js-example-basic-multiple";
                              $Multiple = 'multiple';
                          }else{
                             $MultiClass = '';
                             $Multiple   = '';
                          }

                        $SelectedAnswers = array();
                        if(!empty($providedSolution)){
                          foreach ($providedSolution as $providedSolutionArray) {
                            if(isset($providedSolutionArray['selectedItemID'])){
                              $SelectedAnswersArray = $providedSolutionArray['selectedItemID'];
                                if(is_array($SelectedAnswersArray)){
                                  foreach ($SelectedAnswersArray as $SelectedAnswer){
                                    array_push($SelectedAnswers, $SelectedAnswer);
                                  }
                                }else{
                                  array_push($SelectedAnswers,$SelectedAnswersArray);
                                }
                             }
                           }
                         }
                        echo '<select class="form-control '.$MultiClass.'" '.$Multiple.' name="customSelect2">';
                        echo '<option value="0"> Select </option>';
                        foreach($prePopulated['data'] as $key=>$row){
                            if(isset($hasInList) and $hasInList===true){
                              if(in_array($row->ID,$SelectedAnswers)){
                                    $selected = 'selected="selected"';
                              } else {
                                    $selected = '';
                              }
                            }
                            echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->Name.'</option>';
                        }//End of foreach
                        echo '</select>';
                    }
                ?>
            </div>
        </div>
    </div>

<?php
unset($prePopulated);

} ?>

