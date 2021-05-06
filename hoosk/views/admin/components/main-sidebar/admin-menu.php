
    <li class="treeview <?= active_link('Pages','');?>">
        <a href="#">
            <i class="fa fa-file"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Pages','')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li class="<?= active_link('Pages','index');?>"><a href="<?php echo BASE_URL ; ?>/admin/pages"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('nav_pages_all'); ?></a></li>
            <li class="<?= active_link('Pages','addPage');?>"><a href="<?php echo BASE_URL ; ?>/admin/pages/new"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('nav_pages_new'); ?></a></li>
        </ul>
    </li>
    <li class="treeview <?= active_link('Blog','');?>">
        <a href="#">
            <i class="fa fa-file"></i> <span>Blogs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Blog','')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li class="<?= active_link('Blog','index');?>"><a href="<?php echo BASE_URL ; ?>/admin/blog"><i class="fa fa-circle-o"></i>All Blogs</a>
            <li class="<?= active_link('Blog','add_blog');?>"><a href="<?php echo BASE_URL ; ?>/admin/blog/add_blog"><i class="fa fa-circle-o"></i>New Blog</a></li>
        </ul>
    </li>
    <li class="treeview <?= active_link('Question','');?>">
        <a href="#">
            <i class="fa fa-user"></i>
            <span>Questions</span>
            <span class="pull-right-container">
                 <i class="fa fa-angle-<?= active_link('Question','')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li  class="Questions <?= active_link('Question','index');?>"><a href="<?=base_url('admin/questions/index')?>"><i class="fa fa-circle-o"></i>
                    <?= $this->lang->line('nav_questions_answers'); ?></a>
            </li>
            <li class="<?= active_link('Question','order');?>">
                <a href="<?=base_url('admin/questions/ordering')?>"><i class="fa fa-circle-o"></i><?= $this->lang->line('nav_questions_sorting'); ?></a>
            </li>
        </ul>
    </li>

    <li class="treeview <?= active_link('Users','index');?> <?= active_link('Users','addUser');?>">
        <a href="#">
            <i class="fa fa-user"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Users','')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li  class=" <?= active_link('Users','index');?>"><a href="<?= base_url('admin/users')?>">
                    <i class="fa fa-circle-o"></i><?= $this->lang->line('nav_users_all'); ?></a>
            </li>
            <li class=" <?= active_link('Users','addUser');?>">
                <a href="<?= base_url('admin/users/new')?>">
                    <i class="fa fa-circle-o"></i>
                    <?= $this->lang->line('nav_users_new'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview  <?= active_link('Navigation','');?>">
        <a href="#">
            <i class="fa fa-list-alt"></i> <span>Navigation</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-<?= active_link('Navigation','')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li class=" <?= active_link('Navigation','index');?>">
                <a href="<?= base_url('admin/navigation')?>">
                    <i class="fa fa-circle-o"></i>
                    <?= $this->lang->line('nav_navigation_all'); ?>
                </a>
            </li>
            <li class="<?= active_link('Navigation','newNav');?>">
                <a href="<?= base_url('admin/navigation/new')?>">
                    <i class="fa fa-circle-o"></i>
                    <?= $this->lang->line('nav_navigation_new'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview  <?= active_link('Slider','');?>">
        <a href="#">
            <i class="fa fa-list-alt"></i> <span>Sliders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Slider','')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
           <li class="  <?= active_link('Slider','');?>">
                <a href="<?= base_url('admin/slider/new')?>">
                    <i class="fa fa-circle-o"></i>
                    <?= $this->lang->line('nav_sliders_new'); ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="treeview <?= active_link('Users','email');?> <?= active_link('Users','sent');?> <?= active_link('contact','index')?> <?= active_link('Users','subscribe_list')?>">
        <a href="#">
            <i class="fa fa-envelope-o"></i>
            <span>Mailbox</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Users','email')=='active' || active_link('Users','sent')=='active' || active_link('contact','index')=='active' || active_link('Users','subscribe_list')=='active' ? 'down':'left' ?>  pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li class="<?= active_link('Users','email');?>" >
                <a href="<?= base_url('admin/users/email')?>">
                    <i class="fa fa-envelope-o"></i>
                    Compose Email
                </a>
            </li>
            <li class="<?= active_link('Users','sent');?>">
                <a href="<?= base_url('admin/users/sent')?>">
                    <i class="fa fa-envelope-o"></i>
                    Sent
                </a>
            </li>
            <li class="<?= active_link('contact','index');?>">
                <a href="<?= BASE_URL ; ?>/admin/contact/manage_contact">
                    <i class="fa fa-envelope-o"></i>
                    Contact Us
                </a>
            </li>
            <li class="<?= active_link('Users','subscribe_list');?>">
                <a href="<?= BASE_URL ; ?>/admin/subscriptions">
                    <i class="fa fa-envelope-o"></i>
                    Subscriptions
                </a>
            </li>

        </ul>
    </li>
    <li class=" <?= active_link('Admin','social');?>">
        <a href="<?= BASE_URL ; ?>/admin/social">
            <i class="fa fa-share-alt"></i>
            <span>
                <?= $this->lang->line('nav_social'); ?>
            </span>
        </a>
    </li>
    <li class="treeview  <?= active_link('Admin','settings');?>
  <?= active_link('Admin','manage_appstatus');?>  <?= active_link('Admin','manage_status');?> <?= active_link('Admin','manage_sectors');?> <?= active_link('University','Manage');?> <?= active_link('Services','AdminSetting');?> <?= active_link('University','Manage');?>
">
        <a href="<?= BASE_URL ; ?>/admin/settings">
            <i class="fa fa-cogs"></i>
            <span>
                <?= $this->lang->line('nav_settings'); ?>
            </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-<?= active_link('Admin','manage_appstatus')=='active' || active_link('Admin','settings')=='active' || active_link('Services','AdminSetting')=='active' || active_link('Admin','manage_sectors')=='active'|| active_link('University','Manage')=='active'|| active_link('Admin','manage_status')=='active' ? 'down':'left' ?> pull-right"></i>
            </span>
        </a>
        <ul  class="treeview-menu">
            <li class="<?= active_link('Services','AdminSetting');?>">
                <a href="<?=base_url('admin/setting/services')?>">
                    <i class="fa fa-circle-o"></i>
                    Services Color
                </a>
            </li>
            <li class=" <?= active_link('University','Manage');?>">
                <a href="<?=base_url('admin/manage_university')?>">
                    <i class="fa fa-circle-o"></i>
                    Universities
                </a>
            </li>
            <li class=" <?= active_link('Admin','manage_sectors');?>">
                <a href="<?=base_url('admin/manage_sectors')?>">
                    <i class="fa fa-circle-o"></i>
                    Sectors
                </a>
            </li>
            <li class=" <?= active_link('Admin','manage_status');?>">
                <a href="<?=base_url('admin/manage_status')?>">
                    <i class="fa fa-circle-o"></i>
                    Status
                </a>
            </li>
            <li class=" <?= active_link('Admin','manage_appstatus');?>">
                <a href="<?=base_url('admin/manage_appstatus')?>">
                <i class="fa fa-circle-o"></i>
                ABR Status</a>
            </li>
            <li class="<?= active_link('Admin','settings');?>">
                <a href="<?=base_url('admin/settings')?>">
                <i class="fa fa-circle-o"></i>
                Site Settings</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="<?= BASE_URL ; ?>/sitemap.xml" target="_blank">
            <i class="fa fa-sitemap"></i>
            <span>
                Sitemap
            </span>
        </a>
   </li>
