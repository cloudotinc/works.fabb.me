$(function() {
    $('.postlist').infinitescroll({
        loading: {
            img: "/wp-content/themes/fabb_works/library/images/loading.gif",
            finished: function() {
                $('#infscr-loading').fadeOut();
            },
            msgText: '<em>読み込み中...</em>',
            finishedMsg: "<em>全ての記事を読み込みました</em>"
        },
        navSelector  : ".pagination",
        // selector for the paged navigation (it will be hidden)
        nextSelector : ".pagination a.next",
        // selector for the NEXT link (to page 2)
        itemSelector : ".postlist .postlist-item"
        // selector for all items you'll retrieve
    }, function (newElements, data, url) {

        $('#infscr-loading').fadeOut();
        $(newElements).hide().fadeIn(400,function() {
            /*
             try{
             FB.XFBML.parse();
             twttr.widgets.load();
             }catch(ex){}
             */
        });

    });

});