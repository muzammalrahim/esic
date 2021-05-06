
<style>
    .btn {
        padding: 7px 0;
        min-width: 100px;
    }
    .nextquestion .containers {
        width: 110px !important;
        margin: 0;
        padding: 6px 0 7px 36px;
    }
    .btn-group li {
        display: inline-block;
    }
    .btn-group{
        text-align: center;
        width: 100%;
        padding: 0;
    }
    .nextquestion.form {
        margin-left: 40px;
    }
    @media(max-width: 792px){
        .nextquestion.form {
            margin-left: 0;
        }
    }
    @media(max-width: 700px){
        .nextquestion.form {
            margin-left: 0;
        }
        .btn-group li {
            display: inline-block;
            display: grid;
            width: 50%;
            display: grid;
            margin: 8px auto;
        }
        .nextquestion .containers {
            width: 100% !important;
            margin: 0;
            padding: 6px 0 7px 36px;
        }
    }
    @media(max-width: 400px){
        .nextquestion.form {
            margin-left: 0;
        }
        .btn-group li {
            display: inline-block;
            display: grid;
            width: 90%;
            display: grid;
            margin: 8px auto;
        }
        .nextquestion .containers {
            width: 100% !important;
            margin: 0;
            padding: 6px 0 7px 36px;
        }
    }



</style>
<?php
    $uri =  $this->uri->segment_array();
    $last_url= end($uri);
    $points = strstr($last_url, 'points');
    $principal = strstr($last_url, 'principal');
    $best = strstr($last_url, 'best');
    $alternate = strstr($last_url, 'alternate');
    $fall = strstr($last_url, 'fall');

?>
         <ul class="btn-group">
             <li>
                <a class="btn toogle_me <?= $best ? 'btn-primary' :'btn-info' ?>" data-id="best">Best</a>
            </li>
             <li>
                <a class="btn toogle_me <?= $alternate ? 'btn-primary' :'btn-info' ?>"" data-id="alternate">Alternate</a>
             </li>
             <li>
                <a class="btn toogle_me <?= $fall ? 'btn-primary' :'btn-info' ?>"" data-id="fall">Fall-back</a>
             </li>
             <li>

                <div class="nextquestion form">
                    <label class="containers">Principals
                        <input type="radio" name="selected_options" value="principal" <?= $principal ? 'checked': '' .$last_url  ?> >
                        <span class="checkmark"></span>
                    </label>
                </div>
             </li>
             <li>
                <div class="nextquestion">
                    <label class="containers">Points
                        <input type="radio" name="selected_options" value="points" <?= $points ? 'checked': '' ?> >
                        <span class="checkmark"></span>
                    </label>
                </div>
             </li>
         </ul>


