
$(document).on('ready', function(){
    $modal = $('.modal-frame');
    $overlay = $('.modal-overlay');

    /* Need this to clear out the keyframe classes so they dont clash with each other between ener/leave. Cheers. */
    $modal.bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e){
        if($modal.hasClass('state-leave')) {
            $modal.removeClass('state-leave');
        }
    });

    $(document).on('click','.close,.close_btn', function(){
        $overlay.removeClass('state-show');
        $modal.removeClass('state-appear').addClass('state-leave');

        setTimeout(
            function()
            {
                $overlay.remove();
            }, 200);
        $modal.remove();

    });

    //$('.open').on('click', function(){
    //    $overlay.addClass('state-show');
    //    $modal.removeClass('state-leave').addClass('state-appear');
    //});

});



$.blockUI  = function() {
    var $dv ='',$append = '';
    $dv = '<div class="blockUI blockOverlay">' +
    '<div class="blockUI blockMsg blockElement" style="display: block;">' +
    '<div class="spinner-wrapper">' +
    '<span class="spinner-text">LOADING</span>' +
    '<span class="spinner"></span>' +
    '</div>' +
    '</div>'+
    '</div> ';
    $append = $($dv);

    $($append).appendTo('.wrapper');
    $($append).fadeIn(300);


};

$.unblockUI = function(opt) {  install(window,opt); };

function install(el, opts) {
    var opt = opts,
        $msg = 'You have successfully done.',
        $login = false,
        $join = false,
        $fadeOut = 1000,
        $remove = 2000,
        $su = '';



    if(typeof opt !== 'undefined'){

        if(typeof opt.msg != 'undefined'){
            $msg = opt.msg;

            $su = '<div class="success">'+$msg+'</div>';
            $(".blockUI.blockMsg.blockElement").html($su);

        }
        if(typeof opt.join != 'undefined' && opt.join == true){
            $join = opt.join;
            $fadeOut = 13000;
            $remove = 15000;

            $su = '<div class="success">'+$msg+'</div>';
            $(".blockUI.blockMsg.blockElement").html($su);

        }
        if(typeof opt.login != 'undefined' && opt.login == true){
            $login = opt.login;

        }

    }else{

        $su = '<div class="success">'+$msg+'</div>';
        $(".blockUI.blockMsg.blockElement").html($su);

    }

    fadeOut($fadeOut,$remove);





}


function fadeOut(out,rem){

    var $this = $(".blockUI.blockOverlay");

    setTimeout(function(){
        $this.fadeOut(300);
    }, out);
    setTimeout(function(){
        $this.remove();
    }, rem);


}

///////////////////////////////////////////////////   popup  ///////////////////////////////////////////////////




$.confirmBlock  = function(opts) {
    var opt = opts,
        $msg = 'Are you really <strong>really</strong> sure that you want to exit this awesome application?',
        $btn_1 = 'Confirm',
        $btn_2 = 'Cancel',
        $title = '',
        $fadeOut = 1000,
        $remove = 2000;




    if(typeof opt !== 'undefined'){

        if(typeof opt.msg != 'undefined'){
            $msg = opt.msg;
        }
        if(typeof opt.btn1 != 'undefined'){
            $btn_1 = opt.btn1;
        }
        if(typeof opt.btn2 != 'undefined'){
            $btn_2 = opt.btn2;
        }
        if(typeof opt.title != 'undefined' && opt.title == true){
            $title = opt.title;
            //$fadeOut = 13000;
            //$remove = 15000;
            //
            //$su = '<div class="success">'+$msg+'</div>';
            //$(".blockUI.blockMsg.blockElement").html($su);

        }

    }
    //else{
    //
    //    $su = '<div class="success">'+$msg+'</div>';
    //    $(".blockUI.blockMsg.blockElement").html($su);
    //
    //}

    var $dv ='',$append = '';

    $dv = '<div class="modal-frame">' +
                '<div class="modal model-confirm">' +
                    '<div class="button close"><i class="fa fa-close"></i></div>' +

                    '<h1 class="handle">Confirm your action</h1>' +
                    '<p>'+$msg+'</p>' +
                    '<button id="confirm_action">'+$btn_1+'</button>' +
                    '<button class="close_btn">'+$btn_2+'</button>' +

                '</div>' +
            '</div>' +
    '<div class="modal-overlay"></div>';



    $append = $($dv);
    $($append).appendTo('.body');

    $modal = $('.modal-frame');
    $overlay = $('.modal-overlay');
    setTimeout(
        function()
        {
            $overlay.addClass('state-show');
            $modal.removeClass('state-leave').addClass('state-appear');
        }, 50);


    $(document).on('click','#confirm_action', function(){
        alert('a');
    });
    //$('.model-confirm').draggable({
    //    handle:'.handle'
    //});


};














///////////////////////////////////////////////////   end popup  ///////////////////////////////////////////////////
