<?php


function lang($phrase){

    static $lang=array(

        //navbar link
        "home"          => "Home",
        "category"      => "Category",
        "items"         => "Items",
        "members"       => "Members",
        "comments"      => "Comments",
        "statistics"    => "Statistics",
        "logs"          => "Logs",
        "sevices"       => "Services",
        "edit profile"  => "Edit Profile",
        "setting"       => "Setting",
        "logout"        => "Logout",

    );

    return $lang[$phrase];
}




