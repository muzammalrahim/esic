<?php echo $header; ?>
<!-- JUMBOTRON
=================================-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<?php
$background = '';
if ($page['enableJumbotron'] == 1) {
     $background =$page['jumbotronHTML'];
   $doc=new DOMDocument();
     $doc->loadHTML($background);
   $xml=simplexml_import_dom($doc); // just to make xpath more simple
    $images=$xml->xpath('//img');
    foreach ($images as $img) {
      $background = $img['src'];
   }
 }

?>
<div class="jumbotron full-screen text-center <?php if (($page['enableJumbotron'] == 1) && ($page['enableSlider'] == 1)) { echo "carouselpadding"; } elseif (($page['enableJumbotron'] == 1) && ($page['enableSlider'] == 0)) { echo "errorpadding"; } elseif (($page['enableJumbotron'] == 0) && ($page['enableSlider'] == 1)) { echo "slider-padding"; } ?>"
     style="background: url(<?=$background; ?>) no-repeat">
    <?php if ($page['enableSlider'] == 1) { ?>
        <div id="carousel" class="carousel slide " data-ride="carousel">
            <?php getCarousel($page['pageID']); ?>
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    <?php } ?>

    <div class="container top_investor">
        <?php if ($page['enableJumbotron'] == 0) { ?><div class="row bimage headerstyle jumbotron"></div><?php } else{?>
            <div class="row bimage banner_image">
                <?php // if ($page['enableJumbotron'] == 1) { echo $page['jumbotronHTML']; } ?>
            </div>
         <?php } ?>
        <div class="header_search logotext investor">
            <div class="row">
                <h3> Investor Search </h3>
            </div>
            <hr class="investor_custom-line">
           <div class="row investor_custom-row">
            <!--  <form pre-action="results_investors" action="results_innovators" method="post" accept-charset="utf-8"> -->
            <form pre-action="results_investors" action="esic_database/searchDatabaseListing" method="post" accept-charset="utf-8">
              <input type="text" name="keyword" class="form-control" placeholder="Investors">
              <input type="hidden" name="resultsFor" value="investors">
              <button type="submit" class="form-control submit-icon search-input-button">
                  <span class="search-icon-span">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </span>
              </button>
             </form>
           </div>
           <div class=" row investor_row">
             <div class="col-md-6 col-sm-6 col-xs-12">
                   <a type="button" href="#learn_more" class="btn btn-sm btn-primary">Learn More</a>
              </div>
               <div class="col-md-6 col-sm-6 col-xs-12">
                 <a type="button" href="#investor_eligibility" class="btn btn-sm btn-primary">Investor Eligibility</a>
              </div>
           </div>
        </div>
      </div>
    </div> 
</div>
<!-- /JUMBOTRON container-->
<!-- CONTENT=================================-->
<div class="container">
    <?php echo $page['pageContentHTML']; ?>
    <hr>
</div>
<!-- /CONTENT ============-->
<?php echo $footer; ?>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        $(function () {
            $('div.leftsidebar a').click(function () {

                var alink = $(this).attr('href');
                var result = alink.substring(alink.lastIndexOf("#") + 1);
                var ID = "#" + result;
                $('html, body').animate({
                    scrollTop: $(ID).offset().top - 80
                }, 2000);
            });
        });
    });
</script>
