$(function(){
    "use strict";

    console.log("hello");



    //function to hover delete button at sub category

    $('.sub-cat').hover(function(){
        $(this).find('.show-delete').fadeIn(400);
    },function(){
        $(this).find('.show-delete').fadeOut(400);

    });

    //function to toggle latest information

    $(".toggle-info").click(function (){
        "use strict";

        $(this).toggleClass('select').parent().next(".panel-body").fadeToggle();

        if($(this).hasClass("select")){
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }
        else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>');

        }
    });
    
	// Trigger The Selectboxit

	$("select").selectBoxIt({

		autoWidth: false

	});

    //function to hide placholder text

    $("[placeholder]").focus(function(){
        "use strict";
        $(this).attr("data-text",$(this).attr("placeholder"));
        $(this).attr("placeholder","");
    }).blur(function(){
        $(this).attr("placeholder",$(this).attr("data-text"));
    });


    //function to add asterix to input

    $("input").each(function(){
        "use strict";
        
        if($(this).attr("required") === "required"){
            $(this).after("<span class='asterix'>*</span>")
        }
    });


    //function to show password

    var pass=$('.password');

    $('.show-password').hover(function(){
        "use strict";

        pass.attr("type","text");
    },function(){
        "use strict";

        pass.attr("type","password");
    });



    //function to show confirmation message

    $(".confirm").click(function(){
        "use strict"; 
        return confirm("Are You Sure You Want To Delete!?")

    });



    /*
    **function to toggle category's information
    */


    $('.cat h3').click(function () {
        "use strict";

        $(this).next(".full-view").fadeToggle(100);
    });

    $('.option span').click(function(){
        "use strict";

        $(this).addClass("active").siblings("span").removeClass("active");

        if($(this).data("value") == "full"){
            $('.full-view').fadeIn();
        }
        else{
            $('.full-view').fadeOut();
        }
    });

});