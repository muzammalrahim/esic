<?php
/**
 * Created by PhpStorm.
 * User: hc
 * Date: 9/12/2017
 * Time: 12:20 PM
 */
    foreach($listings as $listing){
        //if($tbl) $listing->esic_investors = $tbl;
        switch($listing->esic_investors){
            case 'esic_investors':
                $href = 'Investor';
                break;
            case 'esic_accelerators':
                $href = 'Accelerator';
                break;
            case 'esic_grantconsultant':
                $href = 'GrantConsultant';
                break;
            case 'esic_lawyers':
                $href = 'Lawyer';
                break;
            case 'esic_rndconsultant':
                $href = 'RndConsultant';
                break;
            case 'esic_rndpartner':
                $href = 'RndPartner';
                break;

        }
        ?>
        <tr>
            <td class=""><?=$listing->ID?></td>
            <td class=""><?=$listing->Name?></td>
            <td class=""><?=$listing->Website?></td>
            <td class=""><?=$href?></td>
            <td class=""><a href="<?=base_url($href.'/Edit/'.$listing->ID)?>"><span aria-hidden="true" class="glyphicon glyphicon-edit text-green "></span></a></td>
        </tr>
    <?php }
//echo $pagination;

?>

