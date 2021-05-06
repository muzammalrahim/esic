<?php ?>
<style type="text/css">
    .filters{
        margin-top:15px;
    }
    .searchBox{
        color:#000;
        margin: 0px;
        border-radius: 5px;
    }
    .module{
        margin-left:0px;
        width: auto;
    }
    #filter{
        width: 100%;
     }
    .btn-group{
        margin-top:15px;
    }
    @media (max-width: 1024px){
        .module .module-section {
            max-width: 100% !important;
            width: 100% !important;
        }
        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
        .item-name {
            text-align: center;
        }
    }
    @media (max-width: 480px){
        section.listing .list .list-item {
            width: 100% !important;
        }
    }
    @media (min-width: 481px) and (max-width: 700px){
        section.listing .list .list-item {
            width: 47% !important;
        }
    }

</style>
<div class="clearfix"></div>
<div class="filters">
    <div class="module" id="foo" style="display: block;">
        <div class="module-section">
            <form class="filterForm" method="post" action="<?=base_url() . $this->uri->segment(1); ?>">
            <div class="col-md-10">
                <div class="form">
                    <div class="filter3 row" id="filter">
                        <div class="col-lg-4 col-md-4">
                            <?php
                                if(isset($postedValues['searchBox']) and !empty($postedValues['searchBox'])){
                                    $searchBoxValue = $postedValues['searchBox'];
                                }
                            ?>
                             <input type="text" name="searchBox" id="searchbox" class="searchBox ac_input" placeholder="Name, website" autocomplete="off" value="<?=isset($searchBoxValue)?$searchBoxValue:'';?>">
                        </div>
                        <div class="location col-lg-4 col-md-4">
                            <select id="locationSelect" name="locationSelect[]" class="customMultiSelect2 form-control" data-placeholder="Select Location" multiple="multiple">
                                <?php
                                if(isset($filters['Locations'])){
                                    if(!empty($filters['Locations']['states'])){
                                        echo '<optgroup label="State">';
                                        foreach($filters['Locations']['states'] as $state){
                                            if(isset($postedValues['locationSelect']) and !empty($postedValues['locationSelect'])){
                                                if(!empty($state->name) and in_array(strtolower($state->name),$postedValues['locationSelect'])){
                                                    $selected = 'selected="selected"';
                                                }else{
                                                    $selected = '';
                                                }
                                            }
                                            if(!empty($state->name)){
                                                echo '<option value="'.strtolower($state->name).'" '.$selected.' >'.$state->name.'</option>';
                                            }
                                        }//End of Foreach
                                        echo '</optgroup>';
                                    }
                                    if(!empty($filters['Locations']['towns'])){
                                        echo '<optgroup label="Town">';
                                        foreach($filters['Locations']['towns'] as $town){
                                            if(isset($postedValues['locationSelect']) and !empty($postedValues['locationSelect'])){
                                                if(!empty($town->name) and in_array(strtolower($town->name),$postedValues['locationSelect'])){
                                                    $selected = 'selected="selected"';
                                                }else{
                                                    $selected = '';
                                                }
                                            }
                                            if(!empty($town->name)){
                                                echo '<option value="'.strtolower($town->name).'" '.$selected.' >'.$town->name.'</option>';
                                            }
                                        }
                                        echo '</optgroup>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="orderByFilter col-lg-4 col-md-4">
                            <select id="orderByFilter" name="orderByFilter" class="customSelect2 form-control" data-placeholder="Order List By">
                                <option value="0" <?= (isset($postedValues['orderByFilter']) and $postedValues['orderByFilter']== "0")? 'selected="selected"':''; ?>>Order List By</option>
                                <option value="ASC" <?= (isset($postedValues['orderByFilter']) and $postedValues['orderByFilter']== "ASC")? 'selected="selected"':''; ?>>Ascending</option>
                                <option value="DESC" <?= (isset($postedValues['orderByFilter']) and $postedValues['orderByFilter']== "DESC")? 'selected="selected"':''; ?>>Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div id="filter_submit_listing" class="btn-group">
                    <button type="button" id="filter_search" class="btn btn-primary" value="Search Now" data-val="0">Search</button>
                    <button type="button" id="filter_reset" class="btn btn-primary" value="Reset" data-val="0">Reset</button>
                </div>
            </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>

<section class="listing">
		<div class="container">
			<div class="list">

			<?php
             $logoDefaultImage =  getDefaultLogoUrl();
            if(!empty($return)):
            foreach ($return as $key => $item) {
				  $item->alias 		 = getAlias($item->name); 
				  $short_description = trimString($item->short_description);
				    if(isset($item->Status_Label)){
					  switch ($item->Status_Label) {
					  	case 'Published':
					  		$label = 'green';
					  		$bgcolor = 'grey';
					  		break;
					  	case 'Feature':
					  		$label = 'aqua';
					  		$bgcolor = 'black';
					  		break;
					  	case 'Private':
					  		$label = 'orange';
					  		$bgcolor = 'Orange';
					  		break;
					  	default:
					  		break;
					  }
				    }

                   $logoImage = $item->logo;
                if(!empty($logoImage) && is_file(FCPATH.'/'.$logoImage)){
                    $logoImage =  base_url().$logoImage;
                }else{
                    $logoImage = $logoDefaultImage;
                }
				?>
				<div class="list-item" data-item="<?= $key ;?>">
					<div class="item-image">
						<a href="<?= base_url().$ListingName.'/'.$item->alias; ?>" class="permalink" data-link= "<?= $item->id;?>">
							<div class="img-container">
								<span>
									<img src="<?= $logoImage; ?>" alt="<?= $item->name; ?>" class="item-logo"/>
								</span>
							</div>
						</a>
					</div>	
					<div class="item-detail">
						<div class="item-name">
			        		<a href="<?= base_url().$ListingName.'/'.$item->alias; ?>" class="permalink" data-link= "<?= $item->id;?>">
			        			<h4><?= $item->name; ?></h4>
			        		</a>
						</div>
						<?php if(isset($item->Status_Label)){ ?>
						<div class="item-status">
							<span class="label label-<?= $label?>" style=" background-color:<?=$bgcolor?> ">
								<?= $item->Status_Label; ?>
							</span>
						</div>
						<?php } ?>
						<div class="clear"></div>
						<div class="item-brief-detail">
						     <div class="description">
			                    <p><?= substr($short_description, 0, 165); ?> ....</p>
			                 </div>
						</div>
					</div>
				</div>
				<?php }//End of foreach
            else:
            echo '<p style="text-align: center;margin-top: 10px;"> No Record Found for the Filtered Query</p>';
            endif;
            // ?>
			</div>
		</div>
</section>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() { //Load after the page is fully loaded.
        $(function () {
            $('#filter_search').on('click', function (e) {
                submitSearchForm(e, this);
            });
            $(document).on('keyup','#searchbox', function(e){
                if(e.which == 13)
                    submitSearchForm(e, this);
            })
            function submitSearchForm(e, ele){
                e.preventDefault();
                var form = $(ele).parents('form');
                form.submit();
            }
            //When Reset is Pressed
            $('#filter_reset').on('click', function (e) {
                e.preventDefault();
                var form = $(this).parents('form');
                form[0].reset();
                $('.customSelect2, .customMultiSelect2').val(null).trigger('change');
                form.submit();
            });

            $('.customSelect2').select2();
            $('.customMultiSelect2').select2({
                closeOnSelect: false
            });
        });
    });
</script>
