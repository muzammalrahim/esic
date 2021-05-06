
<script>
    jQuery(document).ready(function () {
        if(jQuery('.twitter-widget').length > 2){
            twttr.widgets.load(jQuery('.twitter-widget'));
        }
    });
</script>
<script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<script src="<?=base_url()?>assets/js/jquery.redirect.js"></script>
<script src='<?= base_url();?>assets/js/customJs.js'></script>
</body>
</html>
