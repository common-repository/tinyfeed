/*
 * TinyFeed v2.0.1
 * http://jpiche.com/tinyfeed/
 * Copyright (c) 2009 Joseph Piché
 * Licensed under the GPLv2
 */
jQuery(document).ready(function($) {
    function indexOf(a,v){
        for(var i=0;i<a.length;i+=1){
            if(a[i]==v){
                return i;
            }
        }
    }

    $(".widget_tinyfeed .tinyfeed-data").each(function(){
        var m=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        tf = $(this),
        user = tf.attr('data-user'),
        count = tf.attr('data-count'),
        srv = tf.attr('data-service'),
        url = tf.attr('data-url');

        $.get(url,{count:count,screen_name:user,trim_user:0,include_entities:0}, function(data){
            $.each(data, function(i, v) {
                var p = v.created_at.split(" "),
                t = p[3].split(":"),
                d = new Date(Date.UTC(p[5], indexOf(m,p[1]), p[2], t[0], t[1], t[2])),
                dt =d.getDate()+" "+m[d.getMonth()]+" "+d.getFullYear();//+" "+d.getHours()+":"+d.getMinutes();

                if(srv==="identi.ca") {
                    l="http://identi.ca/notice/"+v.id;
                } else {
                    l="http://twitter.com/"+v.user.screen_name+"/status/"+v.id_str;
                }
                tf.append('<li class="entry"><a href="'+l+'" class="tinyfeed-date" target="_blank">'+dt+'</a> '+v.text+'</li>');
            });
            tf.parent().slideDown("fast");
        },"jsonp");
    });
});
