$(function(){
    "use strict";

    console.log("hello front");




    //function to live preview


    $('.create-ad form input').keyup(function(){
        $('.'+$(this).data("class")).text($(this).val());
    });

    $('input[type="file"]').change(function(e){

        console.log($(`.${$(this).data('class')}`));

       // $(`.${$(this).data('class')}`).attr('src',$(this).val());
 
       $(this).val().clone()

   })



    //function to toggle betwwen forms

    $('.login-page h1 span').click(function(){
        $(this).addClass("selected").siblings().removeClass("selected");
        $('.'+$(this).siblings().data('class')).hide();
        $('.'+$(this).data('class')).fadeIn();
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



    //function to show confirmation message

    $(".confirm").click(function(){
        "use strict"; 
        return confirm("Are You Sure You Want To Delete!?")

    });



});