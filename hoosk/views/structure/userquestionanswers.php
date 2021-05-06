            <?php if(isset($usersQuestionsAnswers)){
                        $usersQuestionsAnswers = json_decode(json_encode($usersQuestionsAnswers),true);

                        //The Modals Needed for the Questions.
                        $neededModals = [];
                if(!empty($usersQuestionsAnswers)){
                    foreach ($usersQuestionsAnswers as $key => $value) { ?>
                            <div class="post question-post <?= 'question-'.$value['questionID'];?>" data-id="<?= 'question-'.$value['questionID'];?>">
                                <div class="user-block">
                          <span class="username question-statement">
                              <?= $value['Question']; ?>
                              <a href="javascript:void(0)" class="pull-right btn-box-tool question-edit"
                                 data-id="<?= 'question-' . $value['questionID']; ?>"
                                 data-question-id="<?= $value['questionID']; ?>"><i class="fa fa-pencil"></i></a>

                              <?php if (!empty($value['points'])) { ?>
                                  <span class="question-points"
                                        data-score="<?= $value['points']; ?>">(<?= $value['points']; ?>)</span>
                              <?php } else { ?>
                                  <span class="question-points"></span>
                              <?php } ?>
                          </span>
                                    <?php
                                    $possibleSolutions = $value['PossibleSolution'];
                                    $providedSolution  = $value['ProvidedSolution'];

                                    if(!empty($possibleSolutions)){
                                        $possibleSolutions = json_decode($possibleSolutions);
                                        $type = $possibleSolutions->type;
                                        $hasChildren = $possibleSolutions->hasChildren;
                                    }
                                    if(!empty($providedSolution)){
                                        $providedSolution = json_decode($providedSolution,true);
                                    }
                                    ?>
                                </div>
                                <?php
                                    //Lets fetch just the provided solution
                                $solutionString = '';
                                if($hasChildren){
                                    $solutionString.=' <span class="label label-danger"><i class="fa fa-arrow"></i>Sub</span>';
                                }
                                switch ($type){
                                    case 'CheckBoxes':
                                        if(!empty($providedSolution['selectedCheckBoxes'])){
                                            foreach($providedSolution['selectedCheckBoxes'] as $selectedCheckBox){
                                                $solutionString.=' <span class="label label-info"><i class="fa fa-check"></i> '.$selectedCheckBox["checkBoxValue"].'</span>';
                                            }
                                        }
                                        break;
                                    case 'radios':
                                        if(isset($providedSolution["selectedValue"])){
                                            if($providedSolution["selectedValue"] == 1 || $providedSolution["selectedValue"] == 0 ){
                                                $radiosres  = $providedSolution["selectedValue"] == 1 ? 'Yes' : "No";
                                            }elseif(strtolower($providedSolution["selectedValue"]) == 'no' || strtolower($providedSolution["selectedValue"]) == 'yes'){
                                                $radiosres  = strtolower($providedSolution["selectedValue"] ) == 'yes' ? 'Yes' : "No";
                                            }else{
                                                $radiosres  = '';
                                            }
                                            $solutionString.=' <span class="label label-info"><i class="fa fa-dot-circle-o"></i> '.$radiosres.'</span>';
                                        }
                                        break;
                                    case 'SelectBox':
                                        if(isset($providedSolution['selectedSelectValue']) and !empty($providedSolution['selectedSelectValue'])){
                                            if(is_array($providedSolution['selectedSelectValue'])){
                                                foreach($providedSolution['selectedSelectValue'] as $selectedValue){
                                                    if(is_array($selectedValue['selectedValues'])){
                                                        foreach($selectedValue['selectedValues'] as $multipleSelected){
                                                            $solutionString.=' <span class="label label-info"> <i class=" "></i>'. $multipleSelected .'</span>';
                                                        }

                                                    }else{
                                                            $solutionString.=' <span class="label label-info"> <i class=" "></i>'. $selectedValue['selectedValues'] .'</span>';
                                                    }
                                                }
                                            }elseif(is_string($providedSolution['selectedSelectValue'])){
                                                $solutionString.=' <span class="label label-info"> <i class="fa fa-indent"></i> '.$providedSolution["selectedSelectValue"].'</span>';
                                            }
                                        }
                                        break;
                                    case 'textBoxes':
                                        if(isset($providedSolution['textboxes']) and !empty($providedSolution['textboxes'])){
                                            foreach($providedSolution['textboxes'] as $key=>$textBox){
                                                if(!empty($textBox['changedValue'])){
                                                    $solutionString.=' <span class="label label-info"><i class=" "></i> '.$textBox['changedValue'].'</span>';
                                                }
                                            }
                                        }
                                        break;
                                }
                                ?>
                                <p class="answer-solution"><?= (isset($solutionString)?$solutionString:'') ?></p>
                                <div class="edit-question">
                                    <div class="form-group">
                                        <?php
                                        switch($type){
                                            case 'CheckBoxes':
                                                echo '<label>Please Select Answer</label>';
                                                $data = $possibleSolutions->data;
                                                echo '<div class="form-group">';
                                                if(isset($providedSolution['selectedCheckBoxes']) and !empty($providedSolution['selectedCheckBoxes'])){
                                                    $selectedCheckBoxes = $providedSolution['selectedCheckBoxes'];
                                                }
                                                foreach($data as $checkbox){
                                                    if(isset($selectedCheckBoxes) and in_array_r($checkbox->id,$selectedCheckBoxes) and in_array_r($checkbox->name,$selectedCheckBoxes)){
                                                        $checked = 'checked="checked"';
                                                    }else{
                                                        $checked = '';
                                                    }
                                                    ?>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="<?=$checkbox->name?>" id="<?=$checkbox->id?>" <?=$checked?>>
                                                            <?=$checkbox->text?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                                echo '</div>';
                                                break;
                                            case 'SelectBox':
                                                if(empty($possibleSolutions->textBoxText)){
                                                    echo '<label>Please Select Answer</label>';
                                                }else{
                                                    echo '<label>'.$possibleSolutions->textBoxText.'</label>';
                                                }
                                                $data = $possibleSolutions->data;

                                                if(isset($possibleSolutions->isDynamic) and !empty($possibleSolutions->isDynamic) and  $possibleSolutions->isDynamic=== 'Yes'){
                                                    $class='isDynamic';
                                                }elseif(isset($possibleSolutions->isMulti) and !empty($possibleSolutions->isMulti) and  $possibleSolutions->isMulti=== 'Yes'){
                                                    $class='customSelect2';
                                                }else{
                                                    $class='';
                                                }
                                                ?>
                                                <select class="form-control <?=$class?>" <?=((isset($possibleSolutions->isMulti) && $possibleSolutions->isMulti === 'Yes')?'multiple="multiple"':'')?> style="width:100%">
                                                    <?php
                                                    if(!empty($data)){
                                                        $mayBeProvidedSolution = array();
                                                        if(is_array($providedSolution['selectedSelectValue'])){
                                                            foreach($providedSolution['selectedSelectValue'] as $key => $selectedanswers){
                                                                if(isset($selectedanswers['selectedValues'])){
                                                                   $selectedValue = $selectedanswers['selectedValues'];
                                                                   array_push($mayBeProvidedSolution, $selectedValue);
                                                               }
                                                            }
                                                        }
                                                        foreach($data as $key => $selectOption){
                                                            if(in_array($selectOption->value,$providedSolution['selectedSelectValue'])){
                                                                $selected='selected="selected"';
                                                            }elseif(in_array($selectOption->value,$mayBeProvidedSolution)){
                                                                $selected='selected="selected"';
                                                            }else{
                                                                $selected = '';
                                                            }

                                                            echo '<option value="'.$selectOption->value.'" '.(isset($selected)?$selected:'').'>'.$selectOption->text.'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                                break;
                                            case 'radios':
                                                echo '<label>Please Select Answer</label>';
                                                $data = $possibleSolutions->data;
                                                echo '<div class="form-group">';
                                                if(isset($providedSolution['type']) and $providedSolution['type'] === 'radio'){
                                                    $selectedValue=$providedSolution['selectedValue'];
                                                    $selectedRadioID=$providedSolution['selectedRadioID'];
                                                }
                                                $radioSelectedKey=null;
                                                if(!empty($data)){ //if(!empty($data)){
                                                    foreach($data as $key=>$radioButton){
                                                        if(isset($selectedRadioID) && ($radioButton->id === $selectedRadioID) && ($selectedValue=== $radioButton->value)){
                                                            $checked = 'checked="checked"';
                                                            $radioSelectedKey=$key;
                                                        }else{
                                                            $checked = '';
                                                        }
                                                        ?>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="radio_<?=$value['questionID']?>" id="<?=$radioButton->id?>" value="<?=$radioButton->value?>" <?=$checked?>>
                                                                <?=$radioButton->text?>
                                                            </label>
                                                        </div>
                                                        <?php
                                                    }
                                                }else{
                                                    echo '<pre>';
                                                    echo 'No Answers Yet have been created for this Question.';
                                                    echo '</pre>';
                                                }

                                                echo '</div>';
                                                break;
                                            case 'textBoxes':
                                                $data = $possibleSolutions->data;
                                                if(!empty($data)){
                                                    echo '<div class=row>';
                                                    $providedText = $providedSolution['textboxes'];
                                                    foreach($data as $key=>$textBox){
                                                        ?>
                                                        <div class="form-group <?= isset($textBox->grid->grid_size)?'col-md-'.$textBox->grid->grid_size:'' ?>">
                                                            <label for="<?=$textBox->labelTextBox->textBoxID?>"><?= $textBox->labelTextBox->label ?></label>
                                                            <input type="text" id="<?=$textBox->labelTextBox->textBoxName?>" name="<?=$textBox->labelTextBox->textBoxName?>" class="form-control" value="<?=(!empty($providedText[$key]['changedValue'])?$providedText[$key]['changedValue']:'')?>">
                                                        </div>
                                                        <?php
                                                    }//End of Foreach
                                                    echo '</div>';
                                                }//End of If not empty data
                                                break;
                                        }
                                        ?>
                                    </div>
                                    <?php if(!empty($hasChildren) and !empty($data)):?>
                                    <div class="subQuestionListingDiv">

                                        <?php

                                        switch ($type){

                                            case 'radios':

                                                if($radioSelectedKey !== null){
                                                    if(is_array($data)){
                                                        if(isset($data[$radioSelectedKey]->subItems) and !empty($data[$radioSelectedKey]->subItems)){
                                                            $subItems = $data[$radioSelectedKey]->subItems;
                                                        }
                                                    }
                                                    if(is_object($data)){
                                                        if(isset($data->$radioSelectedKey->subItems) and !empty($data->$radioSelectedKey->subItems)){
                                                            $subItems = $data->$radioSelectedKey->subItems;
                                                        }
                                                    }
                                                    if(isset($subItems) &&!empty($subItems)){
                                                        echo '<div class="box box-solid">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Sub - Questions</h3>
                                                    </div><!-- /.box-header -->';
                                                        foreach($subItems as $item){
                                                            switch($item->type){
                                                                case 'pre-populatedList':
                                                                    $this->data['Multi'] = $item->multi;
                                                                    $this->data['prePopulated'] = fetchPrePopulatedSubQuestion($item->itemID);
                                                                    $this->data['listTypeID'] = $item->itemID;

                                                                    if(isset($item->customEntry)){
                                                                        $this->data['customEntry'] = $item->customEntry;
                                                                       if(!in_array($item->itemID,$neededModals)){
                                                                           array_push($neededModals,$item->itemID);
                                                                       }
                                                                    }else{
                                                                        $this->data['customEntry'] = NULL;
                                                                    }

                                                                    //We Need the Provided Solution As Well.
                                                                    if(isset($providedSolution['prePopulatedItems'])){
                                                                        $this->data['prePopulated']['providedSolution'] = $providedSolution['prePopulatedItems'];
                                                                    }
                                                                    BackEndPrePopulatedItemsView($this,$this->data);
                                                                    break;
                                                                case 'subQuestion':
                                                                    $this->data['subQuestion'] = fetchQuestionAnswers($item->itemID);
                                                                    $this->data['listingTypeID'] = $this->QuestionListingID;
                                                                    $this->data['parentQuestionID'] = $value['questionID'];
                                                                    BackEndSubQuestionView($this,$this->data);
                                                                    break;
                                                            }
                                                            //$this->load->view('admin/questions/templates/subQuestion',$this->data);
                                                        }//End of Foreach
                                                        echo '<!-- /.box-body -->
                                                        </div>';
                                                    }
                                                }
                                                break;
                                        }
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php }//End of Foreach Loop.
                }
                       if(!empty($neededModals)){
                           loadPrePopulatedSelectModals($this, $neededModals);
                       }

                    }//End of If Statement
                    ?>