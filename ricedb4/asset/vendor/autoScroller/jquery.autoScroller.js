function autoScroller(contentDiv, speed,$everyTime)
{
    contentDiv = "#"+contentDiv;
    var scrollSpeed = (speed==null) ? 5 : parseInt(speed);

    // double make sure the autoScroller-container has the correct css position and overflow property
    $(contentDiv).parent().css({position:'relative',overflow:'hidden'});

    // set contentDiv style
    var $heightScreen = parseInt(screen.height - 150);

    $(contentDiv).css({position:'absolute',top:$heightScreen});
    // get contentDiv height
    contentDivHeight = $(contentDiv).height();

    // call periodical
    $(contentDiv).everyTime($everyTime, function(i){
        if (parseInt($(this).css('top'))>(contentDivHeight*(-1)+8))
        {
            // move scroller upwards
            offset = parseInt($(this).css('top'))-scrollSpeed+"px";
            $(this).css({'top':offset});
        }
        // reset to original position
        else
        {
            // reset to original position
            offset = parseInt($(this).parent().height())+8+"px";
            $(this).css({'top':offset});
        }
    });

    // on mouse over event, pause the scroller
    $(contentDiv).mouseover(function ()
    {
        speed = scrollSpeed;
        scrollSpeed = 0;
    });

    // on mouse out event, start the scroller
    $(contentDiv).mouseout(function ()
    {
        scrollSpeed = speed;
    });


    $('.up-speed').click(function ()
    {
        speed = scrollSpeed;
        scrollSpeed = (speed+1);
        $(".span_speed").removeClass('collapse').html(scrollSpeed+'x');
        setTimeout(function() { $(".span_speed").addClass('collapse'); }, 5000);

    });
    $('.down-speed').click(function ()
    {
        speed = scrollSpeed;
        scrollSpeed = (speed-1);
        $(".span_speed").removeClass('collapse').html(scrollSpeed+'x');
        setTimeout(function() { $(".span_speed").addClass('collapse'); }, 5000);
    });


    $(document).keydown(function(e) {
        if (e.keyCode == 39 && e.ctrlKey) {
            speed = scrollSpeed;
            scrollSpeed = (speed+1);
            $(".span_speed").removeClass('collapse').html(scrollSpeed+'x');
            setTimeout(function() { $(".span_speed").addClass('collapse'); }, 5000);
        }
    });


    $(document).keydown(function(e) {
        if (e.keyCode == 37 && e.ctrlKey) {
            speed = scrollSpeed;
            scrollSpeed = (speed-1);
            $(".span_speed").removeClass('collapse').html(scrollSpeed+'x');
            setTimeout(function() { $(".span_speed").addClass('collapse'); }, 5000);
        }
    });

}


