<?php echo $header; ?>
    <style>
        .container-fluid {
            background: #fff;
        }
    </style>
<!-- JUMBOTRON 
=================================-->
<div class="jumbotron text-center <?php if (($page['enableJumbotron'] == 1) && ($page['enableSlider'] == 1)) { echo "carouselpadding"; } elseif (($page['enableJumbotron'] == 1) && ($page['enableSlider'] == 0)) { echo "errorpadding"; } elseif (($page['enableJumbotron'] == 0) && ($page['enableSlider'] == 1)) { echo "slider-padding"; } ?>">
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

    <div class="container">
      <div class="row">
            <?php if ($page['enableJumbotron'] == 1) { echo $page['jumbotronHTML']; } ?>        
        </div>
      </div>
    </div> 
</div>
<!-- /JUMBOTRON container-->
<br>
<br>
<br>
<div class="container">
    <h3><?php echo $page['pageContentHTML']; ?></h3>
    <hr>
</div>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() { //Load after the page is fully loaded.
        $(function () {
            $('div.leftsidebar a').click(function () {
                var alink = $(this).attr('href');
                var result = alink.substring(alink.lastIndexOf("#") + 1);
                var ID = "#" + result;
                $('html, body').animate({scrollTop: $(ID).offset().top - 80}, 2000);
            });
        });
    });
</script>
<?php echo $footer; ?>
