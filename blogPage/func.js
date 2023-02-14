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
$(document).ready(function () {
    $('.Navigate-button').hover(
        function () {
            $(this).css('background-color', 'rgba(0, 0, 0, 0.4)');
        },
        function () {
            $(this).css('background-color', 'rgba(255, 255, 255, 0.8)');
        }
    )
})
$('.Navigate-button').bind('click', function () {
    let partId = $(this).attr('id');
    console.log(partId);
    let content = partId.replace('-button', '');
    console.log(content);
    $('#content div').hide();
    $('#' + content).fadeIn(300);
})

/**
 * function: check if  the path is exist 
 * @param {string} url the path of a file
 * @returns true if the path is exist ,else return false
 */
function FileExist(url) {
    let exist;
    $.ajax({
        type: 'HEAD',
        url: url,
        async: false,
        success: function () {
            exist = true;
        },
        error: function () {
            exist = false;
        }
    })
    return exist;
}