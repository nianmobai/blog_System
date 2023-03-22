//element model
//
const Retrieval_model = '<div class="retrieval-model flex flex-direction-row border"><div class="pic border"><img src=""></div><div class="context flex flex-direction-column"> <div class="headline border flex"></div><div class="other-data border"></div></div></div > ';
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
            console.log('Intro框的宽度为' + width_contamp);
            Virtualize(Virtualize_param);
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
        url: Intro_Interface,
        async: false,
        success: function (data, status) {
            let result = JSON.parse(data);
            $('#head_img').css('backgorund-image', "url(" + result['headpic_path'] + ")");
        }
    })
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
