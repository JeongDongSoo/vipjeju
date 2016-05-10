var src_height; // 대표, 실과, 복지정보, 읍면 상세검색 높이값 반응형 적용
jQuery(function(){
    $("#lnb #top1menu > li:last-child").addClass("part_info");
    $("#lnb #top1menu > li:last-child ul.depth2 > li").each(function(index){
        $(this).addClass("part_icon"+index);
    });
    //$("#lnb #top1menu > li:last-child ul li ul").remove();//3차메뉴 삭제
});

if(navigator.userAgent.indexOf("MSIE 7") > 0) {
} else if(navigator.userAgent.indexOf("MSIE 8") > 0) {
} else {
  $("document").ready(function(){
    if ( $(window).width() > 1024){
    } else if ($(window).width() > 640 && $(window).width() < 1024){
      $("#lnb #top1menu ")
    } else {
    }
  });
  $(window).resize(function() { 
    if ( $(window).width() > 1024){
    } else if ($(window).width() > 640 && $(window).width() < 1024){
    } else {
    }
  }) 
}