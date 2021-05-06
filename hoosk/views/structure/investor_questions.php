 <div id="form-questions">
<?php

if (isset($QuestionsAnswers) and !empty($QuestionsAnswers)) {
    foreach ($QuestionsAnswers as $key => $questionData) {
        $PossibleSolutions = $questionData->PossibleSolutions;
        if (!empty($PossibleSolutions)) {
            $PossibleSolutions = json_decode($PossibleSolutions);
        }
        if ($questionData->questionID) {
            $questionID = $questionData->questionID;
        }
        if (isset($questionData->isRequired) and $questionData->isRequired == '1') {
            $isRequired = true;
        } else {
            $isRequired = false;
        }
        if(!empty($PossibleSolutions) and isset($PossibleSolutions->type)){ ?>
          <fieldset class="questions" data-question-id="<?= $questionData->questionID;?>" data-question-type="<?= $PossibleSolutions->type;?>">
              <div class="form-group bg-shaded clearfix">
                  <div class="col-blocks col-xs-12 col-sm-12 col-md-6">
                    <label for="<?= $questionData->questionID;?>">
                       <?= $questionData->Question ;?>
                      <?php if($isRequired === true){ ?>
                        <span class="required-fields">*</span> 
                      <?php }?>
                    </label>
                  </div>
            <?php
            $ItemNameID = '';
            $hasChildren = $PossibleSolutions->hasChildren;
            switch ($PossibleSolutions->type) {

                case 'radios':
                    $solutionData = $PossibleSolutions->data;
                    if (!empty($solutionData)) {
                        foreach ($solutionData as $key => $radio) {
                            $radioName = explode('_', $radio->id);
                            //Remove the last item.
                            $answserID = $radioName[2];
                            unset($radioName[2]);
                            //Join back the items
                            $radioName  = implode('_', $radioName);
                            $ItemNameID = $radioName;
                      ?>
                        <div class="col-blocks col-xs-3 col-sm-2 col-md-1 questions" data-id="<?= $radio->id;?>" data-type="radios">
                            <div class="radio">
                                <label for="<?= $radio->id;?>">
                                  <input id="<?= $radio->id;?>" data-answer-id="<?=$answserID;?>" type="radio" value="<?= $radio->value;?>" name="<?= $radioName;?>" <?=(($isRequired === true) ? 'required="required"' : ''); ?> />
                                    <?= $radio->text;?>
                                </label>
                             </div>
                        </div>
                    <?php
                      } 
                    } //End of If (If not empty possible solutions for a question)
                    break;
                case 'textBoxes':
                    $solutionData = $PossibleSolutions->data;
                    if (!empty($solutionData)) {
                        foreach ($solutionData as $key => $textBox) {
                            $label       = $textBox->labelTextBox->label;
                            $textBoxID   = $textBox->labelTextBox->textBoxID;
                            $textBoxName = $textBox->labelTextBox->textBoxName;
                            $ItemNameID  = $textBoxName;
                            $textBoxSize = $textBox->grid->grid_size;
                      ?>
                      <div class="col-blocks col-xs-3 col-sm-6 col-md-6" data-id="<?= $textBoxID;?>" data-type="textBoxes">
                        <div class="<?=(empty($textBoxSize) ? '' : $textBoxSize);?>">
                            <label for="<?= $textBoxID;?>"><?= $label;?></label>
                            <div class="form-group">
                              <input type="text" id="<?= $textBoxID;?>" name="<?= $textBoxName;?>" class="form-control " />
                            </div>
                        </div>
                      </div>
                    <?php
                        } //End of foreach
                    }
                    break;
                case 'CheckBoxes':
                    $solutionData = $PossibleSolutions->data;
                    if (!empty($solutionData)) {
                        foreach ($solutionData as $checkBox) {
                            $checkBoxID   = $checkBox->id;
                            $checkBoxArray = explode('_', $checkBox->id);
                            $answserID = $checkBoxArray[2];
                            $checkBoxName = $checkBox->name;
                            $checkBoxText = $checkBox->text;
                            $ItemNameID   = $checkBoxName;

                    ?>
                      <div class="col-blocks col-xs-3 col-sm-2 col-md-1" data-id="<?= $checkBoxID;?>" data-type="CheckBoxes">
                        <div class="form-group">';
                          <label for="<?= $checkBoxID;?>">
                            <input id="<?= $checkBoxID;?>" data-answer-id="<?=$answserID;?>"  type="checkbox" class="minimal" name="<?= $checkBoxID;?>" value="<?= $checkBoxName;?>" 
                            <?=(($isRequired === true) ? 'required="required"' : '');?>>
                            <?= $checkBoxText;?> 
                          </label>
                        </div>
                      </div>
                  <?php
                      }
                    } //End of If Statement
                    break;

                case 'SelectBox':
                    //Ok. Main Question of Select can be of two types.
                    //1 . for single select
                    //2 . for multi select.
                    if (isset($PossibleSolutions->isMulti)) {
                        $isMulti = true;
                    } else {
                        $isMulti = false;
                    }
                ?>
                  <div class="col-blocks col-xs-12 col-sm-12 col-md-6 SelectBox" data-id="<?= $questionID;?>" data-type="SelectBox">
                <?php
                    $ItemNameID = 'select_id_' . $questionID;
                    if (isset($PossibleSolutions->textBoxText)) {  ?>
                      <label for="<?= $ItemNameID; ?>"><?=$PossibleSolutions->textBoxText;?></label>
                <?php } 
                  $multi = '';
                  if($isMulti){
                    $multi = 'multiple="multiple"';
                  }
                  $Required = '';
                  if($isRequired){
                    $Required = 'required="required"';
                  }
                ?>
                    <select id="<?= $ItemNameID; ?>" name="<?= $ItemNameID; ?>" <?= $multi;?> <?= $Required;?>  class="form-control">
              <?php
                    $solutionData = $PossibleSolutions->data;
                    if (!empty($solutionData)) {
                        foreach ($solutionData as $selectItem) { ?>
                            <option value="<?= $selectItem->value;?>"><?= $selectItem->text;?></option>
                        <?php
                        } //End of Foreach Statement
                    } //End of If Statement
                ?>
                    </select>
                <?php
                    break;
            } //End Of Switch
           
            ?>
               
            <?php
        } //End of Main If Statement, if Question's Solution Do Exist.
        //SubQuestion and pre-populatedList start Here
        foreach ($solutionData as $key => $item) {

            $radioItemID = $item->id;
            if(isset($item->subItems) && !empty($item->subItems)) {
                foreach ($item->subItems as $key => $subItem) {
                    $type   = $subItem->type;
                    $itemID = $subItem->itemID;
                    switch ($type) {
                        case 'pre-populatedList':
                            $data                 = '';
                            $data['prePopulated'] = fetchPrePopulatedSubQuestion($itemID);
                            $data['subItemID']    = $radioItemID;
                            $data['ItemID']       = $ItemNameID;
                            $data['Multi']        = $subItem->multi;
                            $data['subQuestionID']= $ItemID;
                            $data['questionID']   = $questionID;
                            $data['gridDesktop'] = 'col-md-4';
                            $data['type']         = $type;
                            //We Need the Provided Solution As Well.
                            
                            if (isset($providedSolution['prePopulatedItems'])) {
                                $data['prePopulated']['providedSolution'] = $providedSolution['prePopulatedItems'];
                            }
                            $this->load->view('admin/questions/templates/subFrontPrePopulated', $data);
                            break;
                        case 'subQuestion':
                            $data                 = '';
                            $data['subItemID']    = $radioItemID;
                            $data['ItemID']       = $ItemNameID;
                            $data['subQuestionID']= $ItemID;
                            $data['questionID']   = $questionID;
                            $data['type']         = $type;
                            $data['subQuestion']  = fetchQuestionAnswers($itemID);
                            $this->load->view('admin/questions/templates/subFrontQuestion', $data);
                            break;
                    }
                }
            }
        } ?>
         </div>
              </fieldset>
        <?php
    } //End of Main foreach statement.
    
}
?>
  </div>
