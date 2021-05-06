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
                        <div class="filter3" id="filter">
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <?php
                                    if(isset($postedValues['searchBox']) and !empty($postedValues['searchBox'])){
                                        $searchBoxValue = $postedValues['searchBox'];
                                    }
                                    ?>
                                    <input type="text" name="searchBox" id="searchbox" class="searchBox ac_input" placeholder="Institution Name" autocomplete="off" value="<?=isset($searchBoxValue)?$searchBoxValue:'';?>">
                                </div>
                                <div class="location col-lg-6 col-md-6">
                                    <?php
                                    if(isset($postedValues['locationSelect']) and !empty($postedValues['locationSelect'])){
                                        if(in_array('ny',$postedValues['locationSelect'])){
                                        }
                                    }
                                    ?>
                                    <select id="locationSelect" name="locationSelect[]" class="customSelect2 form-control" data-placeholder="Select Location" multiple="multiple">
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
                                <div class="orderByFilter col-lg-3 col-md-3">
                                    <select id="contactNameFilter" name="contactNameFilter" class="customSelect2 form-control" data-placeholder="Contact Name">
                                        <?php
                                        if(isset($filters['contacts']) and !empty($filters['contacts'])){
                                            echo '<option value="0">Select Contact Name</option>';
                                            foreach($filters['contacts'] as $contact){
                                                echo '<option value="'.strtolower($contact->name).'">'.$contact->name.'</option>';
                                            }//End of foreach
                                        }//End of if Statement
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="location col-lg-9 col-md-9">
                                    <?php
                                    if(isset($postedValues['locationSelect']) and !empty($postedValues['locationSelect'])){
                                        if(in_array('ny',$postedValues['locationSelect'])){
                                        }
                                    }
                                    ?>
                                    <select id="roleDepartment_select" name="roleDepartment_select[]" class="customSelect2 form-control" data-placeholder="Select Role/Department" multiple="multiple">
                                        <?php
                                        if(isset($filters['roleDepartment'])){
                                            if(!empty($filters['roleDepartment'])){
                                                foreach($filters['roleDepartment'] as $roleDepartment){
                                                    if(isset($postedValues['roleDepartment_select']) and !empty($postedValues['roleDepartment_select'])){
                                                        if(!empty($roleDepartment->name) and in_array(strtolower($roleDepartment->name),$postedValues['roleDepartment_select'])){
                                                            $selected = 'selected="selected"';
                                                        }else{
                                                            $selected = '';
                                                        }
                                                    }
                                                    if(!empty($roleDepartment->name)){
                                                        echo '<option value="'.strtolower($roleDepartment->name).'" '.$selected.' >'.$roleDepartment->name.'</option>';
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
				  $item->alias 		 = getAlias($item->institution); 
				  $short_description = trimString($item->programDescription);
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
									<img src="<?= $item->logo; ?>" alt="" class="item-logo"/>
                                    <img src="<?= $logoImage; ?>" alt="" class="item-logo"/>
								</span>
							</div>
						</a>
					</div>	
					<div class="item-detail">
						<div class="item-name">
			        		<a href="<?= base_url().$ListingName.'/'.$item->alias; ?>" class="permalink" data-link= "<?= $item->id;?>">
			        			<h4><?= $item->institution; ?></h4>
			        		</a>
						</div>
						<?php if(isset($item->state)){ ?>
						<div class="item-state">
							<span>
								<?= $item->state; ?>
							</span>
						</div>
						<?php } ?>
						<div class="clear"></div>
						<div class="item-brief-detail">
						     <div class="description">
			                    <p><?=   substr($short_description, 0, 165); ?> ....</p>
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
                e.preventDefault();
                var form = $(this).parents('form');
                form.submit();
            });

            //When Reset is Pressed
            $('#filter_reset').on('click', function (e) {
                e.preventDefault();
                var form = $(this).parents('form');
                form[0].reset();
                $('.customSelect2').val(null).trigger('change');
                form.submit();
            });

            $('.customSelect2').select2();
        });
    });
</script>
