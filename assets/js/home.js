// $('div.leftsidebar a').click(function(){
//     var alink = $(this).attr('href');
//     var result = alink.substring(alink.lastIndexOf("#") + 1);
//     var ID = "#"+result;
//     $('html, body').animate({
//             scrollTop: $(ID).offset().top -80}
//         , 2000);
// });

function init() {
    var vidDefer = document.getElementsByTagName('iframe');
    for (var i=0; i<vidDefer.length; i++) {
        if(vidDefer[i].getAttribute('data-src')) {
            vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
        } } }
window.onload = init;






