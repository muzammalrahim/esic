    <li class="<?= active_link('Esic','');?>"><a href="<?=base_url('admin/manage_esic')?>"><i class="fa fa-list"></i> Esic</a></li>
    <li class="<?= active_link('Investor','');?>"><a href="<?=base_url('admin/manage_investor')?>"><i class="fa fa-list"></i> Investor</a></li>
    <li class="treeview <?= active_link('Lawyer','');?> <?= active_link('RndPartner','');?>
<?= active_link('RndConsultant','');?> <?= active_link('GrantConsultant','');?> <?= active_link('Accelerator','');?> <?= active_link('TaxAdvisors','');?>">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Listings (on own account) </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Lawyer','') || active_link('RndPartner','') ||
              active_link('RndConsultant','')||active_link('GrantConsultant','') || active_link('Accelerator','')|| active_link('TaxAdvisors','') ? 'down': 'left' ;?> pull-right"></i>
            </span>
        </a>

        <ul class="treeview-menu">
            <li class="<?= active_link('Lawyer','');?>"><a href="<?=base_url('admin/manage_lawyer')?>"><i class="fa fa-circle-o"></i> Lawyers</a></li>

            <li class="<?= active_link('RndPartner','');?>"><a href="<?=base_url('admin/manage_rndpartner')?>"><i class="fa fa-circle-o"></i> R&D Partners</a></li>

            <li class="<?= active_link('RndConsultant',''); ?>"><a href="<?=base_url('admin/manage_rndconsultant')?>"><i class="fa fa-circle-o"></i> R&D Consultants</a></li>
            <li class="<?= active_link('TaxAdvisors',''); ?>"><a href="<?=base_url('admin/manage_taxadvisors')?>"><i class="fa fa-circle-o"></i> Tax Advisers</a></li>

            <li class="<?= active_link('GrantConsultant',''); ?>"><a href="<?=base_url('admin/manage_grantconsultant')?>"><i class="fa fa-circle-o"></i> Grant Consultants</a></li>

            <li class="<?= active_link('Accelerator','');?>"><a href="<?=base_url('admin/manage_accelerator')?>"><i class="fa fa-circle-o"></i> Accelerators</a></li>

<!--            <li class="--><?php //if ($class == "AcceleratingCommercialisation") { echo "active"; } ?><!--"><a href="--><?//=base_url('admin/manage_acceleratingcommercialisation')?><!--"><i class="fa fa-circle-o"></i> Accelerating Commercialisation</a></li>-->

        </ul>
    </li>
