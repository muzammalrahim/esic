<?php
    if(isset($questionID) and isset($totalCurrentDivs)){
        $textBoxID = $questionID.'_'.(intval($totalCurrentDivs)+1);
    }elseif(isset($question_ID)){
        //Means its Being Loaded for the First Time.
        $textBoxID = $question_ID.'_1';
    }



    //If there are already been Added TextBoxes. Just Display Them as they are.
//For That we need to look if there already a solution json.
if(isset($Solution) and !empty($Solution)){
    //If Not Empty then json decode it.
    $Solution = json_decode($Solution->Solution);
    $SolutionData = $Solution->data;
    $count = 1;
    if(!empty($SolutionData)){
        foreach($SolutionData as $textBox){
?>
        <div class="row textBoxDiv" data-id="<?=$textBox->divID?>">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="labelTextBox_<?=$textBox->divID?>">Label For Textbox</label>
                    <input type="text" class="form-control tBox" id="labelTextBox_<?=$textBox->divID?>" placeholder="Enter text for label for textbox" value="<?=(isset($textBox->labelTextBox)?$textBox->labelTextBox->label:'')?>">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="grid_size_<?=$textBox->divID?>">Grid Size</label>
                    <input type="text" class="form-control tBox" id="grid_size_<?=$textBox->divID?>" placeholder="e-g 6" value="<?=(isset($textBox->grid)?$textBox->grid->grid_size:'')?>">
                </div>
            </div>
            <div class="col-lg-1">
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                    <div class="btn-group btn-group-sm" role="group">
                        <button style="margin-top: 25px;" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);"><i class="fa fa-calendar"></i>Date Picker</a></li>
<!--                            <li><a href="javascript:void(0);"><i class="fa fa-clock-o"></i> Time Picker</a></li>-->
                        </ul>
                    </div>
<!--                    <a style="margin-top: 25px;" href="javascript:void(0)" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i></a>-->
                    <a style="margin-top: 25px;" href="javascript:void(0)" class="btn btn-danger trashTextBox"><i class="fa fa-trash"></i></a>
                </div>
                </div>
            </div>
<?php
        $count++;
        }//End of Foreach
    }
    $textBoxID = $question_ID.'_'.$count;
}//End of If Solution JSON exist.
?>



<div class="row textBoxDiv" data-id="<?=$textBoxID?>">
    <div class="col-lg-8">
        <div class="form-group">
            <label for="labelTextBox_<?=$textBoxID?>">Label For Textbox</label>
            <input type="text" class="form-control tBox" id="labelTextBox_<?=$textBoxID?>" placeholder="Enter text for label for textbox">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="grid_size_<?=$textBoxID?>">Grid Size</label>
            <input type="text" class="form-control tBox" id="grid_size_<?=$textBoxID?>" placeholder="e-g 6">
        </div>
    </div>
    <div class="col-lg-1">
        <a style="margin-top: 25px;" href="javascript:void(0)" id="addMoreTextBox" class="btn btn-primary btn-block"><i class="fa fa-plus"></i></a>
    </div>
</div>


