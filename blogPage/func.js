const Retrieval_model = '<div class="article-Retrieval border flex"><div class="article-pic border" ><img></div><div class="article-Intro flex-direction-column flex border"><div class="headline flex border"></div><div class="briefIntro border"></div><div class="time border flex"></div></div></div> ';
const first_child_Element = '>.article-Retrieval:eq{0}';
const tag_model = '<div class="tag-label"></div>'
console.log("导入成功");
$(document).ready(Adjust_Size());
function Adjust_Size() {
    let blog_bodyPosition = $('#blogbody').offset();
    let blog_bodyHeight = $('#blogbody').height();
    console.log(blog_bodyHeight)
    console.log(blog_bodyPosition['top']);
    let view_areaHeight = $(document).height()
    if ((blog_bodyHeight + blog_bodyPosition['top']) != view_areaHeight) {
        $('#blogbody').height(view_areaHeight - blog_bodyPosition['top']);
        $('#mainPart').height(blog_bodyPosition['top'] + $('#blogbody').height());
    }
}
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
    $('#content > div').hide();
    $('#' + content).fadeIn(200);
})

//Get_ArticleIntro();

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

/**
 * function: add the entance to login, also add a special effect to headpic
 */
$('#headpic').hover(
    function () {
        $(this).css('transform', 'scale(1.02)');
    },
    function () {
        $(this).css('transform', 'scale(1)');
    }).bind('click', function () {
        window.location.href = '../login/signIn.html';
        $.ajax({
            url: '../index.php',
            async: false,
            /*test:
            sucess: function (data) {
                console.log(data);
            },*/
            error: function () {
                console.log('link error')
            }
        })
    }).mousedown(function () {
        $(this).css('transform', 'scale(1.01)');
    }).mouseup(
        function () {
            $(this).css('transform', 'scale(1.02)');
        })

/**
 * function: receive an object of an article with all the data including sort,headline and so on
 * @param {object} article an object with all the data of article
 */
function Add_Retrieval(article) {
    $('#' + article.sort).prepend(Retrieval_model);
    $('#' + article.sort + first_child_Element + ' .article-pic').css('background-image', 'url(' + article.essaypic_path + ')');
    $('#' + article.sort + first_child_Element + ' .headline').text(article.headline).bind('click', function () {
        // window.location.href = article.essay_path;
    });
    $('#' + article.sort + first_child_Element + ' .briefIntro').text(article.briefIntro);
    $('#' + article.sort + first_child_Element + ' .time').text(article.time);
}
/**
 * function: get all data of article if it is exist
 */
function Get_ArticleIntro() {
    $.ajax({
        url: '',
        type: 'POST',
        async: false,
        dataType: 'json',
        success: function (data, sttus) {
            let result = JSON.parse(data);
            result.forEach((element, index) => {
                Add_Retrieval(element);
            });
        }
    })
}