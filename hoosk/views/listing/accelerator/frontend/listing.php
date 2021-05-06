<style type="text/css">
    .filters{
        margin-top:15px;
    }
    .searchBox{
        color:#000;
        margin: 0px;
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
</style>
<div class="clearfix"></div>
<div class="filters">
    <div class="module" id="foo" style="display: block;">
        <div class="module-section">
            <form class="filterForm" method="post" action="<?=base_url() . $this->uri->segment(1); ?>">
                <div class="col-md-10">
                    <div class="form">
                        <div class="filter3 row" id="filter">
                            <div class="col-lg-3 col-md-3">
                                <?php
                                if(isset($postedValues['searchBox']) and !empty($postedValues['searchBox'])){
                                    $searchBoxValue = $postedValues['searchBox'];
                                }
                                ?>
                                <input type="text" name="searchBox" id="searchbox" class="searchBox ac_input" placeholder="Name, website" autocomplete="off" value="<?=isset($searchBoxValue)?$searchBoxValue:'';?>">
                            </div>
                            <div class="location col-lg-3 col-md-3">
                                <?php
                                if(isset($postedValues['locationSelect']) and !empty($postedValues['locationSelect'])){
                                    if(in_array('ny',$postedValues['locationSelect'])){
                                    }
                                }
                                ?>
                                <select id="locationSelect" name="locationSelect[]" class="customMultiSelect2 form-control" data-placeholder="Select Location" multiple="multiple">
                                    <?php
                                    if(isset($filters['Locations'])){
                                        if(!empty($filters['Locations']['addresses'])){
                                            foreach($filters['Locations']['addresses'] as $address){
                                                if(isset($postedValues['locationSelect']) and !empty($postedValues['locationSelect'])){
                                                    if(!empty($address->name) and in_array(strtolower($address->name),$postedValues['locationSelect'])){
                                                        $selected = 'selected="selected"';
                                                    }else{
                                                        $selected = '';
                                                    }
                                                }
                                                if(!empty($address->name)){
                                                    echo '<option value="'.strtolower($address->name).'" '.$selected.' >'.$address->name.'</option>';
                                                }
                                            }//End of Foreach Statement
                                        }//End of If Statement, If Addresses do exist.
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="CriteriaSelect" name="Criteria[]" class="customSelect2 form-control" data-placeholder="Select Criteria" multiple="multiple">
                                <?php
                                if(isset($filters['Criteria'])){
                                    if(!empty($filters['Criteria'])){
                                        foreach($filters['Criteria'] as $criteria){
                                            if(isset($postedValues['Criteria']) and !empty($postedValues['Criteria'])){
                                                if(!empty($criteria->name) and in_array(strtolower($criteria->name),$postedValues['Criteria'])){
                                                    $selectedCriteria = 'selected="selected"';
                                                }else{
                                                    $selectedCriteria = '';
                                                }
                                            }
                                            if(!empty($criteria->name)){
                                                echo '<option value="'.strtolower($criteria->name).'" '.$selectedCriteria.' >'.$criteria->name.'</option>';
                                            }
                                        }//End of Foreach Statement
                                    }//End of If Statement, If Addresses do exist.
                                }
                                ?>
                                </select>
                            </div>
                            <div class="orderByFilter col-lg-3 col-md-3">
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
            if(!empty($return)):
            foreach ($return as $key => $item) {
				  $item->alias 		 = getAlias($item->name); 
				  $short_description = substr(trimString($item->Program_Summary), 0, 165);
				  $statusText = '';
				    if(isset($item->AcceleratorStatus)){
					  switch ($item->AcceleratorStatus) {
					  	case 'Pending':
					  		$label = 'green';
					  		$bgcolor = 'black';
					  		$statusText = 'Pending';
					  		break;
					  	case 'Eligible':
					  		$label = 'aqua';
					  		$bgcolor = 'green';
					  		$statusText = 'Eligible';
					  		break;
					  	default:
					  		$label = 'green';
					  		$bgcolor = 'black';
					  		$statusText = 'Pending';
					  		break;
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
						<?php if(isset($item->AcceleratorStatus)){ ?>
						<div class="item-status">
							<span class="label label-<?= $label?>" style=" background-color:<?=$bgcolor?> ">
								<?= $statusText; ?>
							</span>
						</div>
						<?php } ?>
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
			                    <p><?=  $short_description; ?> ....</p>
			                 </div>
						</div>
					</div>
				</div>
				<?php }
            else:
                echo '<p style="text-align: center;margin-top: 10px;"> No Record Found for the Filtered Query</p>';
            endif;
				?>
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
