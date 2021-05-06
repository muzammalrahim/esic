<?php echo $header; ?>
<!-- JUMBOTRON
=================================-->
<!--<script defer="defer" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script defer="defer" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

<?php
$background = '';
if ($page['enableJumbotron'] == 1) {
    $background =$page['jumbotronHTML'];
    $doc = new DOMDocument();
    $doc->loadHTML($background);
    $xml = simplexml_import_dom($doc); // just to make xpath more simple
    $images = $xml->xpath('//img');
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

    <div class="container">
        <?php if ($page['enableJumbotron'] == 0) { ?><div class="row bimage headerstyle jumbotron"></div><?php } else{?>
            <div class="row bimage banner_image">
                <?php // if ($page['enableJumbotron'] == 1) { echo $page['jumbotronHTML']; } ?>
            </div>
        <?php } ?>
        <div class="header_search logotext">
            <div class="row">
                <h3>Your search for early stage innovation opportunities ends here</h3>
            </div>
            <hr class="custom-line">
            <div class="row custom-row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <form pre-action="investor_database" action="esic_database" method="post" accept-charset="utf-8" id="investor_header_search">
                        <input type="text" name="searchBox" class="form-control" placeholder="Investors">
                        <input type="hidden" name="resultsFor" value="innovators">
                        <button type="submit" class="form-control submit-icon search-input-button">
                          <span class="search-icon-span">
                            <i class="fa fa-search" aria-hidden="true"></i>
                          </span>
                        </button>
                    </form>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <form action="<?=base_url()?>services/search" method="POST" accept-charset="utf-8">
                        <input type="search" name="searchKey" class="form-control" placeholder="Innovators">
                        <input type="hidden" name="resultsFor" value="innovators">
                        <button type="submit" class="form-control submit-icon search-input-button">
                          <span class="search-icon-span">
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                          </span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="dropdown">
                        <a  class="btn dropdown-toggle  btn-primary" data-toggle="dropdown" href="#">
                            Add listing
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= BASE_URL ?>/esic">ESIC</a></li>
                            <li><a href="<?= BASE_URL ?>/investor">Investor</a></li>
                            <li><a href="<?= BASE_URL ?>/accelerator">Accelerator</a></li>
                            <li><a href="<?= BASE_URL ?>/rndpartner">Research Partner</a></li>
                            <li><a href="<?= BASE_URL ?>/rndconsultant">R&D Consultant</a></li>
                            <li><a href="<?= BASE_URL ?>/taxadvisers">Tax Advisers</a></li>
                            <li><a href="<?= BASE_URL ?>/lawyer">Lawyer</a></li>
                            <li><a href="<?= BASE_URL ?>/grantconsultant">Grant Consultant</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <a  class="btn dropdown-toggle  btn-primary"  href="<?= BASE_URL ?>/calculator.html/">ESIC Calculator</a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>


            </div>
        </div>
    </div>
</div>
</div>
<!-- /JUMBOTRON container-->
<!-- CONTENT =================================-->
<div class="container">
    <?php echo $page['pageContentHTML'];
    // for users percnetage
    $total = $page['IP_Protection']+$page['CoDevelopment']+$page['RandD']+$page['advisers'];
    $IP_Protection = $page['IP_Protection'];
    $IP_Protection = $IP_Protection/$total*100;
    $IP_Protection = (int) $IP_Protection;
    $CoDevelopment = $page['CoDevelopment'];
    $CoDevelopment = $CoDevelopment/$total*100;
    $CoDevelopment = (int) $CoDevelopment;
    $RandD = $page['RandD'];
    $RandD = $RandD/$total*100;
    $RandD = (int)$RandD;
    $advisers = $page['advisers'];
    $advisers =  $advisers/$total*100;
    $advisers =  (int) $advisers;
    $esic =  (int) $page['esic'];
    ?>
<!--    <div id="users_chart">-->
<!--        <a href="search" target="_blank">-->
<!--            <div id="chart">-->
<!--            </div>-->
<!--        </a>-->
<!--    </div>-->

    <hr>


</div>

<!-- /CONTENT ============-->
<?php echo $footer; ?>

<div style="display:none;padding-left: 15px;"id="chartpopup" >Hi</div>
<style>
    .apexcharts-series-0 {
        position: absolute !important;
        display: inline-block !important;
        border-bottom: 1px dotted black !important;
    }

    .apexcharts-series-0 path{
        visibility: hidden !important;
        width: 120px !important;
        background-color: black !important;
        color: #fff !important;
        text-align: center !important;
        border-radius: 6px !important;
        padding: 5px 0 !important;
        position: absolute !important;
        z-index: 5 !important;
    }
    </style>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
<script>
    // create usign page builder <p id="replacewithgraph">Graph</p> and replace with chart div to show it in a specific area
    $('#replacewithgraph').replaceWith( " <div id='users_chart'> <a href='search' target='_blank'><div id='chart'></div></a></div>" );
    jQuery(document).ready(function($){

    var options = {
        chart: {
            height: 350,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                offsetY: -30,
                startAngle: 0,
                endAngle: 270,
                hollow: {
                    margin: 5,
                    size: '30%',
                    background: 'transparent',
                    image: undefined,
                },
                dataLabels: {
                    name: {
                        show: false,
                    },
                    value: {
                        show: false,
                    }
                }
            }
        },
        colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5'],
        series: [ <?= $IP_Protection ?>,<?= $CoDevelopment ?>,<?= $RandD ?>,<?= $advisers ?>,<?= $esic ?>],
        labels: ['IP Protection', 'Co-Development', 'R&D', 'Advisory','ESIC'],
        legend: {
            show: true,
            floating: true,
            fontSize: '14px',
            position: 'left',
            offsetX: 170,
            offsetY: 10,
            labels: {
                useSeriesColors: true,
            },
            markers: {
                size: 0
            },
            formatter: function(seriesName, opts) {
                if(seriesName == 'ESIC'){
                    return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                }else{
                    return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex] + "%"
                }
            },
            itemMargin: {
                horizontal: 1,
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    show: true // show or hide on mobile
                }
            }
        }]
    }
    var chart = new ApexCharts(
        document.querySelector("#chart"),
        options
    );
    chart.render();
        $( "path" ).hover(
            function() {
                var datavalue = $(this).attr("data:value");
                if ( datavalue !== undefined ) {
                    $(this).css('visibility', 'visible');
                    $(this).text('Tooltip text');
                    $('#chartpopup').css('left', event.pageX);      // <<< use pageX and pageY
                    $('#chartpopup').css('top', event.pageY);
                    $('#chartpopup').css('display', 'inline');
                    $("#chartpopup").css("position", "absolute");
                    var divid = $(this).attr("id");
                    var divid = Number(divid[divid.length - 1]);
                    var textt = '';
                    switch (Number(divid)) {
                        case 4:
                            textt = 'IP Protection: ';
                            break;
                        case 6:
                            textt = 'Co-Development: ';
                            break;
                        case 8:
                            textt = 'R&D: ';
                            break;
                        case 0:
                            textt = 'Advisory: ';
                            break;
                        case 2:
                            textt = 'ESIC: ';
                            break;
                        default:
                            textt = 'empty';
                    }
                    $("#chartpopup").text(textt + datavalue + '%');
                }
            },
            function () {
                setTimeout(function(){ $("#chartpopup").css('display', 'none'); }, 15000);
            }
        );
    });
    </script>