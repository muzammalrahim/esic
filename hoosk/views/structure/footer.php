<div class="container-fluid footer footer-wraper">
    <?php  // Search local service Providers Widget   
        if($this->data['page']['search_widget'] == 1){
    ?>
    <div class="local_service_provider_search">
        <button class="open-button" id="local_postheading" onclick="openlocal_postcodeForm()">SEARCH LOCAL SERVICE PROVIDERS</button>
        <div class="chat-popup" id="local_postcodeForm">
            <form action="<?=base_url()?>search_local_providers" class="local_postcode_form-container" method="POST">
                <h3>SEARCH YOUR LOCAL PROVIDERS </h3>
                <!-- label for="msg"> Enter Postcode</label-->
                <input type="text" name="local_postcode" id="local_postcode" placeholder="Enter Your PostCode" required class="form-control">
                <button type="submit" class="btn">Search</button>
                <button type="button" class="btn cancel" onclick="closelocal_postcodeForm()">Cancel</button>
            </form>
        </div>
        <script>
            function openlocal_postcodeForm() {
                document.getElementById("local_postcodeForm").style.display = "block";
                document.getElementById("local_postheading").style.display  = "none";
            }
            function closelocal_postcodeForm() {
                document.getElementById("local_postcodeForm").style.display = "none";
                document.getElementById("local_postheading").style.display  = "block";
            }
        </script>
    </div>
<?php } ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 footermenu">
                <h4>Popular Links</h4>
                <?php hooskNav('footer'); ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 footermenu">
                <h4>Support</h4>
                <?php hooskNav('footer-cen'); ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 social footermenu">
                <h4>Contact Us</h4>
                <?php hooskNav('footer-rit'); ?>
                <ul class="socials">
                    <li><strong>Contact number: </strong><?= $settings_footer[0]['contact']?></li>
                    <li>​<strong>Email:</strong><?= $settings_footer[0]['siteEmail']?></li>
                </ul>
                ​<div class="paragraph_footer"><p><?= $settings_footer[0]['footer_text']?></p></div>
                <div class="social_links">
                    <button class="btn btn-sm SUBSCRIBE "> SUBSCRIBE OUR NEWS LETTER</button>
                    <?php  getSocial(); ?>
                </div>
            </div>
        </div>
    </div>
    <!--commit added by hamid testing-->
    <div class="row">
        <?= $settings_footer[0]['footer_bottom_text']?>
    </div>



</div>

<div class="hidden">
    <?php
    $user_name_pop = $this->session->userdata('userName');
    $guide_popups = $this->session->userdata('guide_popups');
          if( !empty(trim($user_name_pop)) &&  trim($guide_popups)  === ''){?>
             <p class="user_name_pop" id="<?= $user_name_pop ?>">ok</p>
              <?php $this->session->set_userdata('guide_popups', 'pop up viewd') ;
           }else{?>
              <p class="user_name_pop"  id="<?= $guide_popup ?>">no</p>
          <?php }
    ?>
</div>

<div id="tosModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Terms and Conditions</h4>
            </div>
            <div class="modal-body">
                <p id="tosContent"></p>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <span id="timerFooter" style="display: inline-block;margin-top: 8px;vertical-align: bottom;">Disappearing in : <strong></strong>
                  Seconds</span>


                <button   type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button id="agreeAndAccept" type="button" class="btn btn-success pull-right" data-dismiss="modal">Agree and Accept</button>
                <a class="btn btn-info pull-right"  href="javascript:printDiv('tosContent')">Print</a>

                <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
            </div> <!--  -->
        </div>
    </div>
</div>
<div id="subscribe" class="modal fade">
    <div class="modal-dialog modal-newsletter">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h4>Join Our Newsletter</h4>
                    <button type="button" class="close_subscribe close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <p>Subscribe our newsletter to receive the latest news and exclusive offers.</p>
                    <div class="form-group">
                        <input type="email" name="email2" id="email" class="hidden">
                        <input type="email" name="email" id="sub_email" class="form-control" placeholder="Enter your email" required>
                        <input type="submit" class="subscribe btn btn-primary btn-block" value="Subscribe">
                    </div>
                    <div class="close_subscribe footer-link"><a href="#" data-dismiss="modal" aria-hidden="true">No Thanks</a></div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="user_guide_Modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="closed pull-right" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align: center;">  </h4>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <a class="btn btn-info closed"  href="<?=base_url()?>listing.html">View ESIC listing guide! </a>
            </div>
        </div>
    </div>
</div>
<link type="text/css" href="<?= base_url()?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet"/>
<script defer="defer" type="text/javascript" src="<?=base_url()?>assets/js/structureFooter.js"></script>
<?php
// this is set in my_site_helper line 284
if( isset($_SESSION['pageHasSlider']) && $_SESSION['pageHasSlider'] == true ){?>
    <link rel="stylesheet" href="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/css/owl.carousel.css" />
    <link rel="stylesheet" href="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/css/owl.theme.default.min.css" />
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.carousel.min.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.animate.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.autoheight.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.autoplay.min.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.autorefresh.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.hash.min.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.navigation.min.js"></script>
    <script defer="defer" src="<?php echo ADMIN_THEME; ?>/js/owlcarousel2/js/owl.support.js"></script>
<?php }
$_SESSION['pageHasSlider'] = false;
if($this->router->fetch_method() === 'Listing' || ($this->router->fetch_method() === 'FrontForm' /*and $this->Name === 'Investor'*/)){
    echo '<script defer="defer" src="'.base_url().'assets/js/listing.js"></script>';
    ?>
    <script>


        window.addEventListener('DOMContentLoaded', function() { // structure / footer.php
            jQuery(document).ready(function (e) {
                var $state = $('#address_state').val();
                var $postCodesURL = '<?= base_url('get_post_codes')?>';
                var $selector = $('#address_post_code');
                $selector.select2();
                getPostCodes($selector, $postCodesURL, $state);
                $('#address_state').on('select2:select', function (e) {
                    var $state = $(this).val();
                    getPostCodes($selector, $postCodesURL, $state);
                });
            })
        })

    </script>

    <?php
}
?>
<script>
    printDivCSS = new String ('<link href="myprintstyle.css" rel="stylesheet" type="text/css">')
    function printDiv(divId) {
        window.frames["print_frame"].document.body.innerHTML=printDivCSS + document.getElementById(divId).innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
</script>


<!-- google Analytics addded from Weebly -->

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-85987530-1', 'auto');
    ga('send', 'pageview');

</script>
<!--<script type="text/javascript">-->
<!--    var _gaq = _gaq || [];-->
<!--    _gaq.push(['_setAccount', 'UA-7870337-1']);-->
<!--    _gaq.push(['_setDomainName', 'none']);-->
<!--    _gaq.push(['_setAllowLinker', true]);-->
<!---->
<!--    (function() {-->
<!--        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;-->
<!--        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';-->
<!--        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);-->
<!--    })();-->
<!---->
<!--    _W.Analytics = _W.Analytics || {'trackers': {}};-->
<!--    _W.Analytics.trackers.wGA = '_gaq';-->
<!--</script>-->
<!---->
<!--<script type="text/javascript" async=1>-->
<!--    ;(function(p,l,o,w,i,n,g){if(!p[i]){p.GlobalSnowplowNamespace=p.GlobalSnowplowNamespace||[];-->
<!--        p.GlobalSnowplowNamespace.push(i);p[i]=function(){(p[i].q=p[i].q||[]).push(arguments)-->
<!--        };p[i].q=p[i].q||[];n=l.createElement(o);g=l.getElementsByTagName(o)[0];n.async=1;-->
<!--        n.src=w;g.parentNode.insertBefore(n,g)}}(window,document,'script','//cdn2.editmysite.com/js/wsnbn/snowday262.js','snowday'));-->
<!---->
<!--    var r = [99, 104, 101, 99, 107, 111, 117, 116, 46, 40, 119, 101, 101, 98, 108, 121, 124, 101, 100, 105, 116, 109, 121, 115, 105, 116, 101, 41, 46, 99, 111, 109];-->
<!--    var snPlObR = function(arr) {-->
<!--        var s = '';-->
<!--        for (var i = 0 ; i < arr.length ; i++){-->
<!--            s = s + String.fromCharCode(arr[i]);-->
<!--        }-->
<!--        return s;-->
<!--    };-->
<!--    var s = snPlObR(r);-->
<!---->
<!--    var regEx = new RegExp(s);-->
<!---->
<!--    _W.Analytics = _W.Analytics || {'trackers': {}};-->
<!--    _W.Analytics.trackers.wSP = 'snowday';-->
<!--    _W.Analytics.user_id = '84367404';-->
<!--    _W.Analytics.site_id = '227146356324044362';-->
<!---->
<!--    // Setting do not track if the GDPR cookie is not present. This is then checked by the snowday initializer-->
<!--    // to set tracking decisions. https://github.com/snowplow/snowplow-javascript-tracker/blob/2.6.2/src/js/tracker.js#L1509-->
<!--    window.doNotTrack = document.cookie.indexOf('gdpr-kb') === -1 ? 'yes' : null;-->
<!---->
<!---->
<!--    (function(app_id, ec_hostname, discover_root_domain) {-->
<!--        var track = window[_W.Analytics.trackers.wSP];-->
<!--        if (!track) return;-->
<!--        track('newTracker', app_id, ec_hostname, {-->
<!--            appId: app_id,-->
<!--            post: true,-->
<!--            platform: 'web',-->
<!--            discoverRootDomain: discover_root_domain,-->
<!--            cookieName: '_snow_',-->
<!--            contexts: {-->
<!--                webPage: true,-->
<!--                performanceTiming: true,-->
<!--                gaCookies: true-->
<!--            },-->
<!--            crossDomainLinker: function (linkElement) {-->
<!--                return regEx.test(linkElement.href);-->
<!--            },-->
<!--            respectDoNotTrack: document.cookie.indexOf('gdpr-kb') === -1-->
<!--        });-->
<!--        track('trackPageView', _W.Analytics.user_id+':'+_W.Analytics.site_id);-->
<!--        track('crossDomainLinker', function (linkElement) {-->
<!--            return regEx.test(linkElement.href);-->
<!--        });-->
<!--    })(-->
<!--        '_wn',-->
<!--        'ec.editmysite.com',-->
<!--        true-->
<!--    );-->
<!--</script>-->

<!---End Google Analytics From Weebly site ------>





<script defer="defer" src='<?= base_url();?>assets/js/customJs.min.js'></script>
<script src="https://esic.directory/theme/admin/js/jquery-1.12.4.js"></script>
<script src="https://esic.directory/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<!--Script-->
<script type="text/javascript" language="javascript"
        src="<?php echo base_url('assets/js/steps/jquery.steps.js') ?>"></script>


<script type="text/javascript">           /* after register page on add listing page */
    jQuery(document).ready(function($) {
        $("#ajax-sign-in").on("click", function () {
            userLoginProcess();
        }); //End of Yes Approve Function

        $("#esic-audit-assistant-wiz").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true
        });

        $(document).on('keyup','#password', function(e){
            if(e.which == 13)
                userLoginProcess();
        })
        function userLoginProcess(){
            var username = $('#username').val();
            var password = $('#password').val();
            var postData = {
                'username':username,
                'password':password,
            }
            $.ajax({
                url: "<?= base_url().'login/loginCheckeds';?>",
                data: postData,
                type: "POST",
                success: function (output){
                    console.log(output);
                    var data = output.trim().split("::");
                    if (data[0].split(' ').join('') == 'OK') {
                        var uSerid = data[1];
                        $("#userIDHidden").val(uSerid);
                        $("#ajax-sign-in").hide();
                        $(".next-bnutton").show();
                        // console.log(data[1]);
                        // location.href = data[1];
                    }
                }
            });
        }
    });
</script>



<!--<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>-->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>-->
<!--<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>-->




<script defer="defer" src='<?= base_url();?>assets/js/custom.js'></script>





</body>
</html>
