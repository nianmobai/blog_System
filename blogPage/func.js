console.log("导入成功");
$(document).ready(function () {
    let blog_bodyPosition = $('#blogbody').offset();
    let blog_bodyHeight = $('#blogbody').height();
    console.log(blog_bodyHeight)
    console.log(blog_bodyPosition['top']);
    let view_areaHeight = $(window).height()
    if ((blog_bodyHeight + blog_bodyPosition['top']) < view_areaHeight) {
        $('#blogbody').height(view_areaHeight - blog_bodyPosition['top']);
    }
})