const Retrieval_model = '<div class="article-Retrieval border flex"><div class="article-pic border" ><img></div><div class="article-Intro flex-direction-column flex border"><div class="headline flex border"></div><div class="briefIntro border"></div><div class="time border flex"></div></div></div> ';
const first_child_Element = '>.article-Retrieval:eq{0}';
const tag_model = " <div class='tag-label flex-direction-row'><div class='triangle'></div ><div class='tag-text flex flex-center'>tagContent</div></div>";
const nullContentModle = " <div class='null-Content'>T.T 本版块没有内容</div>";
//console.log("导入成功");
$(document).ready(Adjust_Size());
/**
 * function: adjust the site of blogbody
 */
function Adjust_Size() {
    $('#blogbody').css('height', 'max-content');
    $('#mainPart').css('height', 'max-content');
    let blog_bodyPosition = $('#blogbody').offset();
    let blog_bodyHeight = $('#blogbody').height();
    // console.log("blogbody的高度" + blog_bodyHeight);
    //  console.log("blogbody的偏移" + blog_bodyPosition['top']);
    let view_areaHeight = $(document).height();
    //console.log("文档的高度" + view_areaHeight);
    if ((blog_bodyHeight + blog_bodyPosition['top']) < view_areaHeight) {
        $('#blogbody').height(view_areaHeight - blog_bodyPosition['top']);
        $('#mainPart').height(blog_bodyPosition['top'] + $('#blogbody').height());
        //console.log("变更成功");
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
    let content = partId.replace('-button', '');
    $('#content > div').hide();
    $('#' + content).fadeIn(200);
    Adjust_Size();
})

Get_ArticleIntro();
Get_BloghosterInto();

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
            let count;
            count['talking'] = 0;
            count['javascript'] = 0;
            count['php'] = 0;
            count['works'] = 0;
            count['galgame'] = 0;
            result.forEach((element, index) => {
                switch (element.sort) {
                    case "talking":
                        Add_Retrieval(element);
                        count['talking'] = 1;
                        break;
                    case "javascript":
                        Add_Retrieval(element);
                        count['javascript'] = 1;
                        break;
                    case "php":
                        Add_Retrieval(element);
                        count['php'] = 1;
                        break;
                    case "works":
                        Add_Retrieval(element);
                        count['works'] = 1;
                        break;
                    case "galgame":
                        Add_Retrieval(element);
                        count['galgame'] = 1;
                        break;
                    default:
                        break;
                }
            });
            if (count['talking'] == 0) NullContentShow('talking');
            if (count['javascript'] == 0) NullContentShow('javascript');
            if (count['php'] == 0) NullContentShow('php');
            if (count['works'] == 0) NullContentShow('works');
            if (count['galgame'] == 0) NullContentShow('galgame');
        }
    })
}
function Get_BloghosterInto() {
    $.ajax({
        url: '',
        type: 'GET',
        contentType: 'json',
        async: false,
        success: function (data, status) {
            let result = JSON.parse(data);
            $('#name').text(result['name']);
            $('#headpic').css('background-image', 'url(' + result['headpic_path'] + ")");
            for (let index = 0; index < result['tag'].length && index < 6; index++) {
                let element = result['tag'][index];
                $('#tag').prpend(tag_model);
                $('#tag>.tag-label:eq{0}>.tag-text').text(element);
            }
            $('#QQ-number').text("QQ号：" + result['contact_Way'].QQ);
            $('#BliBliLink>a').href(result['contact_Way'].blibli);
            $('#e-mail').text(result['contact_Way'].mail);
        }
    })
}
/**
 * function: show an icon when there is no essay in this part
 * @param {String} partname 
 */
function NullContentShow(partname) {
    $("#" + partname).html(nullContentModle);
}