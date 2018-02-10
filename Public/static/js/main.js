$(document).ready(function(){

    var num=10;

    var stop=true;//触发开关，防止多次调用事件  
    $(window).scroll(function() {    
        //当内容滚动到底部时加载新的内容 100当距离最底部100个像素时开始加载.  
        if ($(this).scrollTop() + $(window).height() + 100 >= $(document).height() && $(this).scrollTop() > 100) {
            if(stop==true){
                // alert( num );
                stop=false;
                canshu="?limit="+num+",10&cat=" + $("#cat_id").val();
                //加载提示信息
                $(".center-content").append("<li class='ajaxtips'><div style='font-size:2em'>Loding.....</div></li>");
                $.get("/index.php/home/index/index_more"+canshu,function(data){
                // $.get(".//index.php/home/index/index_more"+canshu,function(data){
                    $(".ajaxtips").hide();
                    
                    var htmlList = '';
                    // textarea中的模板HTML
                    htmlTemp = $("div.center_list1_template")[0].innerHTML.replace(/_tplt/gi, "").replace(/&lt;/gi, "<").replace(/&gt;/gi, ">");
                    // alert( htmlTemp );

                    data.forEach(function(object) {
                        htmlList += htmlTemp.temp(object);
                    });
                    $(".center-content").append( htmlList );//把新的内容加载到内容的后面
                    // $(".center-content").append("<h1>"+data[0]["title"]+"</h1>");//把新的内容加载到内容的后面
                    stop=true;
                })
                num=num+10;//当前要加载的页码
                // stop=true;
            }
        }
    });
    
    // template that replace with var from php
    String.prototype.temp = function(obj) {
        return this.replace(/\$\w+\$/gi, function(matchs) {
            var returns = obj[matchs.replace(/\$/g, "")];       
            return (returns + "") == "undefined"? "": returns;
        });
    };

    // Activate the slide
    setTimeout('$("span.glyphicon-chevron-right").click()', 3);
});