<?php echo $header; ?>
<!-- JUMBOTRON 
=================================-->

<div class="jumbotron text-center errorpadding">
<br><br><br><br><br>
    <div class="container">
      <div class="row">
        <div class="col col-lg-12 col-sm-12">
        <img src="<?php echo ADMIN_THEME; ?>/images/large_logo.png" />
        <h1>Oops, there has been an error.</h1>
        <?php if(isset($message) && !empty($message)){ ?>
          <p><?=$message;?></p>
        <?php }else{ ?>
          <p>Sorry this page is currently unavailable.</p>
        <?php } ?>
        </div>
      </div>
    </div> 
<br><br><br>
</div>

<?php echo $footer; ?>