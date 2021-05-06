if(typeof(tosJSON) != "undefined" && tosJSON !== null) {
    var data_array = JSON.parse(tosJSON);
}else{
    var data_array = '';
}
$(function(){

    var trigger = jQuery('.hamburger'),
        overlay = jQuery('.overlay'),
        isClosed = false;
    trigger.click(function () {
        hamburger_cross();
    });
    jQuery('#add-listing-dropdown').click(function(event) {
        jQuery('#add-listing-dropdown').toggleClass('open');
    });
    function hamburger_cross() {
        if (isClosed == true) {
            overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        }else{
            jQuery('img-responsive_logo').addClass('responsive_logo_hide');
            overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }
    jQuery('[data-toggle="offcanvas"]').click(function () {
        jQuery('#wrapper').toggleClass('toggled');
    });
    jQuery('#navbar-toggle-button').click(function(){
        jQuery('#navbar-collapse-main').slsideToggle( "slow");
    });
    if(jQuery('.twitter-widget').length > 2){
        twttr.widgets.load(jQuery('.twitter-widget'));
    }



    if(typeof(tosJSON) != "undefined" && tosJSON !== null) {
        var data_array = JSON.parse(tosJSON);
    }else{
        var data_array = '';
    }
    //For Header.
    $.each(data_array, function(key, value){
        var menuRef = value.menu;
        var enabledTos = value.navTos;
        var tos = value.text;

        //Hamid Named it right sidebar but it is actually top navigation bar
        var topNavigationBar = $('div.right_sidebar');
//            var menu = topNavigationBar.find('a[href="'+menuRef+'"]');
        var url = "<?=BASE_URL?>/"+menuRef;
        var menu = topNavigationBar.find('a[href="'+url+'"]');
        //if Menu Matched and tos has been enabled then we can let the user show the tos.
        if(menu.length > 0 && parseInt(enabledTos)==1){
            //This means have founded the menu..
            menu.on('click',function(e){
                e.preventDefault();
                var modal = $('#tosModal');
                modal.find('#tosContent').html(tos);
                $('#tosModal').modal('show');

               var sec = 25;
                var timer = setInterval(function() {
                    $('#timerFooter strong').text(sec--);
                    if (sec == -1) {
                        modal.modal('hide');
                        clearInterval(timer);
                    }
                }, 1000);


                modal.find('#agreeAndAccept').on('click',function(e){
                    e.stopPropagation();
                    window.location.href = url;
                });
            });
        }
    });
});





