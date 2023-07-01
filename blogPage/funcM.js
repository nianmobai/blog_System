//element model
//
const Retrieval_model = '<div class="retrieval-model flex flex-direction-row border"><div class="pic border"><img src=""></div><div class="context flex flex-direction-column"> <div class="headline border flex"></div><div class="other-data border"></div></div></div > ';
const Tag_model = '<div class="tag-label flex-direction-row"><div class="triangle" ></div><div class="tag-text flex flex-center"><p>PHP</p></div></div>';
const nullContentModle = "";
//
//Interface
//
const Intro_Interface = '';
const Article_Interface = '';
//
//const Value
//
const Virtualize_param = 3;
const None_Virtualize_param = 0;
//

//main project
Adjust_bodyHeight();

/**
 * to get the element we need
 */
let button = document.getElementById('function-button');
let talking_button = document.getElementById('talking-button');
let javascript_button = document.getElementById('javascript-button');
let php_button = document.getElementById('php-button');
let works_button = document.getElementById('works-button');
let galgame_button = document.getElementById('galgame-button');
let head_img = document.getElementById('head_img');
let negative_button = document.getElementById('navigate-button');
let Intro_frame = document.getElementById('Bloghster-Intro');
/**
 * function:add event listener to make the function part and Intro part to hide 
 */
talking_button.addEventListener('touchstart', function () {
    if (!$('#talking').is(':visible')) {
        $('#content>div').hide();
        $('#talking').fadeIn(300);
    }
})
javascript_button.addEventListener('touchstart', function () {
    if (!$('#javascript').is(':visible')) {
        $('#content>div').hide();
        $('#javascript').fadeIn(300);
    }
})
php_button.addEventListener('touchstart', function () {
    if (!$('#php').is(':visible')) {
        $('#content>div').hide();
        $('#php').fadeIn(300);
    }
})
works_button.addEventListener('touchstart', function () {
    if (!$('#works').is(':visible')) {
        $('#content>div').hide();
        $('#works').fadeIn(300);
    }
})
galgame_button.addEventListener('touchstart', function () {
    if (!$('#galgame').is(':visible')) {
        $('#content>div').hide();
        $('#galgame').fadeIn(300);
    }
})
//target的使用
document.addEventListener('touchstart', function (event) {
    let parent = [];
    parent = Get_AllParentNode(event.target);
    if (!$('#navigate-button').is(':visible') && !$('#Bloghster-Intro').is(':visible')) {//Intro-part 
        if (event.target == button || parent.includes(button)) {
            $('#navigate-button').css('display', 'flex').fadeIn(200);
        }
        if (event.target == head_img || parent.includes(head_img)) {
            let width_contamp = $('#Bloghster-Intro').width();
            $('#Bloghster-Intro').show().animate({ right: '-=' + width_contamp + 'px' }, 200);
        }
    }
    else if ($('#navigate-button').is(':visible') && !$('#Bloghster-Intro').is(':visible')) {//Intro-part disappear and navigate-button appear
        if (event.target != button && !parent.includes(negative_button) && $('#navigate-button').is(':visible')) {
            $('#navigate-button').hide();
        }
    }
    else if ($('#Bloghster-Intro').is(':visible') && !$('#navigate-button').is(':visible')) {//Intro-part appear and navigate-button disappear
        if (event.target != Intro_frame && !parent.includes(Intro_frame)) {
            $('#Bloghster-Intro').hide().css('right', '100%');// back to the position before
            Virtualize(None_Virtualize_param);
        }
    }
    else {//avoid the the Intro-part and the navugate button appear at the same time but in theroy this circumstance will not appear
        $('#Bloghster-Intro').hide().css('right', '100%');
        //virtualize the background Image and top and the content
        Virtualize(None_Virtualize_param);
        $('#navigate-button').hide();
    }
})

/**
 * function:adjust the height of body and content
 */
function Adjust_bodyHeight() {
    $('body').css('height', 'max-content');
    let body_height = $('body').height();
    let view_height = $(document).height();
    if (body_height < view_height) {
        $('body').height(view_height);
    }
}

/**
 * function：get the intro of bloghoster then put them in the right div
 */
function Get_BloghosterIntro() {
    $.ajax({
        type: 'GET',
        url: Intro_Interface,
        async: false,
        success: function (data, status) {
            let result = JSON.parse(data);
            $('#head_img').css('backgorund-image', "url(" + result['headpic_path'] + ")");//add head picture
            $('#Introframe-name').html(data['name']);//add name
            Import_Tag(data['tag']);//add tag
            $('#contact-way').text(data['contact_Way']);//rewrite the content in the contact way box 
        },
        error: function () {
            alert("unknown error happen when getting blohoster intro");
        }
    })
}

function GetArticle() {
    $.ajax({
        type: 'POST',
        url: Article_Interface,
        data: "data",
        dataType: "dataType",
        success: function (response, status) {
            //deal with the data
            let data = JSON.parse(response);
            if (reponse != null) Import_ArticleIntro(data);
        },
        error: function () {
            alert("unkown error happen when getting the article intro");
        }
    });
}

/**
 * function: Get all the parent Node
 * @param {Element} node 
 * @returns {Array} parent:all the  parent Node of this element
 */
function Get_AllParentNode(node) {
    let parent = [];
    let content = node;
    for (; content != null;) {
        parent.push(content);
        content = content.parentElement;
    }
    return parent;
}

/**
 * function:adjust the opcity of top and content and body's backgroun-image
 * @param {int} opcity_param opcity the background when open the IntroFrame
 */
function Virtualize(opcity_param) {
    $('#top').css('filter', 'blur(' + opcity_param + 'px)');
    $('body').css('backdrop-filter', 'blur(' + opcity_param + 'px)');
    $('#content').css('filter', 'blur(' + opcity_param + 'px)');
}

/**
 * function:Import the tags from back side,put it into the tag element
 * @param {Array} array_tag 
 * return:none
 */
function Import_Tag(array_tag) {
    array_tag.forEach(element => {
        $('#tag').prepend(Tag_model);//add tag-lable element
        $('#tag> :firstchild>.triangle>.tag-text>p').text(element);
    });
}

/**
 * 
 * @param {arrary} array_art
 */
function Import_ArticleIntro(array_art) {
    let count;
    count['talking'] = 0;
    count['javascript'] = 0;
    count['php'] = 0;
    count['works'] = 0;
    count['galgame'] = 0;
    array_art.forEach(element => {
        Add_Retrieval(element);
        switch (element.sort) {
            case "talking":
                count['talking'] += 1;
                break;
            case "javascript":
                count['javascript'] += 1;
                break;
            case "php":
                count['php'] += 1;
                break;
            case "works":
                count['works'] += 1;
                break;
            case "galgame":
                count['galgame'] += 1;
                break;
            default:
                break;
        }
    });
    //check the part is "none article"
    if (count['talking'] == 0) NullContentShow('talking');
    if (count['javascript'] == 0) NullContentShow('javascript');
    if (count['php'] == 0) NullContentShow('php');
    if (count['works'] == 0) NullContentShow('works');
    if (count['galgame'] == 0) NullContentShow('galgame');
    //The elements of different subscripts in the array are equal to the number of articles in the corresponding category
    //then check it and mark it if there is no article
}

function Add_Retrieval(art) {//depend on art's sort put it in corresponding div
    $('#' + art.sort).prepend(Retrieval_model);
    let element_new = $('#' + art.sort + '>:firstchild');//new element
    if (element_new != null) {
        element_new.attr("id", art.art_id);//add article's id to the new retrieval we just created
        element_new.find('.pic').css('background-image', "url('" + art['essaypic_path'] + "')");
        element_new.find('.headline').text(art['headline']).bind('touchstart', TurnToEssayPage(art['id']));
        element_new.find('.other-data').text(art['time']);
    }
    else console.log("error when getting the node element newed,return null");
}


/**
 * function:tmport the special module when te part(id)  have no essay
 * @param {string} part_name
 */
function NullContentShow(part_name) {
    $('#' + part_name).html(nullContentModle);
}