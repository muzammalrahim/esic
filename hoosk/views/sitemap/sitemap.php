
<?php  /*  '<?xml version="1.0" encoding="UTF-8" ?>' */ ?>


<urlset  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc><?= base_url();?></loc>

    </url>


    <?php
    if(!empty($data)){
        foreach($data as $url) {   ?>
            <?php
            $dateformat = explode(" ", $url['pageUpdated']);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            ?>
            <url>
                <loc><?= base_url().$url['pageURL']  ?></loc>
                <lastmod> <?= $lastmod  ?> </lastmod>
            </url>

        <?php  }
    } ?>

    <url>
        <loc><?= base_url().'esic-database1.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'calculator.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'search';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'innovators-237983.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'esic_database/searchDatabaseListing';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'accelerator_database/searchAccelerator';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'lawyer_database/searchLawyer';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'rndpartner_database/searchRNDpartner';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'taxadvisors_database/searchtaxadvisors';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'rndconsultant_database/searchrndconsultant';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>
        <loc><?= base_url().'grantconsultant_database/searchgrantconsultant';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>

        <loc><?= base_url().'innovators1.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>

        <loc><?= base_url().'home.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>

        <loc><?= base_url().'databaseold.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>

        <loc><?= base_url().'all-about-innovation';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>

        <loc><?= base_url().'index.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <url>

        <loc><?= base_url().'investors.html';?></loc>
        <lastmod> <?=date('Y-m-d\Th:m:s+00:00'); ?> </lastmod>
    </url>
    <?php
    if(!empty($company)){
        foreach($company as $company_url) {  ?>
            <?php
            $dateformat = explode(" ", $company_url->date_updated);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            ?>
            <url>
                <?php if(!empty($company_url->slug)){?>
                    <loc><?= base_url()."Esic/".$company_url->slug ; ?></loc>
                    <lastmod> <?= $lastmod ?> </lastmod>
                <?php } ?>
            </url>
        <?php }} ?>
    <?php
    if(!empty($Lawyer)){
        foreach($Lawyer as $Lawyer_url) { ?>
            <?php
            $dateformat = explode(" ", $Lawyer_url['date_updated']);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            ?>
            <?php if(!empty($Lawyer_url['slug'])) { ?>
                <url>
                    <loc><?= base_url()."Lawyer/".$Lawyer_url['slug'] ; ?></loc>
                    <lastmod> <?= $lastmod ?> </lastmod>
                </url>
            <?php } }   } ?>
    <?php
    if(!empty($RndConsultant)){
        foreach($RndConsultant as $RndConsultant_url) { ?>
            <?php
            $dateformat = explode(" ", $RndConsultant_url['date_updated']);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            ?>
            <?php if(!empty($RndConsultant_url['slug'])) { ?>
                <url>
                    <loc><?= base_url()."RndConsultant/".$RndConsultant_url['slug'] ; ?></loc>
                    <lastmod> <?= $lastmod ?> </lastmod>
                </url>
            <?php } }   } ?>
    <?php
    if(!empty($GrantConsultant)){
        foreach($GrantConsultant as $GrantConsultant_url) { ?>
            <?php
            $dateformat = explode(" ", $GrantConsultant_url['date_updated']);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            ?>
            <?php if(!empty($GrantConsultant_url['slug'])) { ?>
                <url>
                    <loc><?= base_url()."GrantConsultant/".$GrantConsultant_url['slug'] ; ?></loc>
                    <lastmod> <?= $lastmod ?> </lastmod>
                </url>
            <?php } }   } ?>
    <?php
    if(!empty($Accelerator)){
        foreach($Accelerator as $Accelerator_url) { ?>
            <?php
            $dateformat = explode(" ", $Accelerator_url['date_updated']);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            ?>
            <?php if(!empty($Accelerator_url['slug'])) { ?>
                <url>
                    <loc><?= base_url()."Accelerator/".$Accelerator_url['slug'] ; ?></loc>
                    <lastmod> <?= $lastmod ?> </lastmod>
                </url>
            <?php } }   } ?>
    <?php
    if(!empty($blog)){
        foreach($blog as $blog_url) {
            $dateformat = explode(" ", $blog_url['date']);
            $lastmod = date($dateformat[0]."\T".$dateformat[1]."+00:00");
            if(!empty($blog_url['slug'])) { ?>
                <url>
                    <loc><?= base_url().'all-about-innovation/'.$blog_url['slug'];?></loc>
                    <lastmod> <?= $lastmod ?> </lastmod>
                </url>
            <?php } } }    ?>





</urlset>