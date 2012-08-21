function WaitShadowClass(options)
{
    if ('undefined' == typeof(options))
        options = {};

    var block = null;

    var parent = ( 'undefined' == typeof(options.parent) ? $(document) : options.parent );
    
    function WaitShadowObject() {

        var _this = this;

        var block = $('<div>');
        block.css('background', 'url(images/shadow.png) top left repeat');
        block.css('position', 'absolute');
        block.css('zIndex', '1000');
        block.hide();
        _this.block = block;

        _this.show = function() {
            setPosition(_this, parent);
            /*setTimeout(function(){
                setPosition(_this, parent);
            }, 100);*/
        }

        _this.hide = function() {
            _this.block.hide();
            _this.block.remove();
        }

    }

    function setPosition(shadowObj, parentObj)
    {
        if (parentObj.get(0).nodeName == '#document')
        {
            shadowObj.block.css('left', 0);
            shadowObj.block.css('top', 0);
        }
        else
        {
            var _pos = parentObj.offset();
            shadowObj.block.css('left', _pos.left);
            shadowObj.block.css('top', _pos.top);
        }
        shadowObj.block.css('width', parentObj.width());
        shadowObj.block.css('height', parentObj.height());
        $(document.body).append(shadowObj.block);
        shadowObj.block.show();
    }

    return new WaitShadowObject();
}

function ModalWindowClass(options)
{
    if ('undefined' == typeof(options))
        options = {};

    var block = null;

    //var content = ( 'undefined' == typeof(options.content) ? '' : options.content );

    function ModalWindowObject() {

        var _this = this;

        var block = $('<div>');
        block.addClass('modal-window');
        block.hide();

        var contentBlock = $('<div>');
        contentBlock.addClass('modal-content');
        var closeBtn = $('<a>');
        closeBtn.addClass('modal-close');
        (function(btn, mw) {
            btn.click(function(){mw.close();});
        })(closeBtn, _this);

        block.append(closeBtn);
        block.append(contentBlock);
        
        _this.block = block;
        _this.contentBlock = contentBlock;


        _this.sh = WaitShadowClass();

        _this.show = function(content, shadow) {
            var shadow = ( 'undefined' == typeof(shadow) ? true : shadow );
            if (shadow)
            {
                _this.sh.show();
            }

            _this.setContent(content);
            $(document.body).append(_this.block);
            _this.updatePosition();
            _this.block.show();
            //useCuSel();
        }

        _this.close = function() {
            _this.block.hide();
            _this.block.remove();
            _this.sh.hide();
        }

        _this.updatePosition = function() {
            var windowObject = $(window);
            var left = (windowObject.width() / 2) - (_this.block.width() / 2);
            var top = (windowObject.scrollTop() + windowObject.height() / 2) - (_this.block.height() / 2);
            _this.block.css('left', left);
            _this.block.css('top', top);
        }

        _this.setContent = function(data) {
            _this.contentBlock.html(data);
        }

    }

    return new ModalWindowObject();
}

/*var waitWindow = null;
var waitShadow = null;
var modalWindow = null;*/

$(function() {


    /*var gg = WaitShadowClass();
    gg.show();

    var gg = ModalWindowClass();
    gg.show('dfdfh');*/
    /*setTimeout(function(){gg.hide();}, 1000);
    setTimeout(function(){gg.show();}, 2000);
    setTimeout(function(){gg.hide();}, 3000);*/
    

/*

    var shadowBlock = document.createElement('div');
    waitShadow = $(shadowBlock);
    waitShadow.css('background', 'url(/images/shadow.png) top left repeat');
    waitShadow.css('position', 'absolute');
    waitShadow.css('left', '0');
    waitShadow.css('top', '0');
    waitShadow.css('zIndex', '1100');
    var documentObject = $(document);
    waitShadow.css('width', documentObject.width());
    waitShadow.css('height', documentObject.height());
    $(document.body).append(waitShadow);
    waitShadow.hide();

    //waitShadow = WaitShadowClass();


    var loaderBlock = document.createElement('div');
    loaderBlock.innerHTML = '<img src="/images/loaders/wait-loader.gif" width="168" height="40" title="" /><br>' +
            '<span id="wait-window-text"></span>';

    waitWindow = $(loaderBlock);
    waitWindow.css('border', '1px solid #A6C9E2');
    waitWindow.css('backgroundColor', '#fff');
    waitWindow.css('padding', '60px 100px');
    waitWindow.css('zIndex', '1200');
    waitWindow.css('font-family', 'Tahoma, Verdana, sans-serif');
    waitWindow.css('font-size', '13px');
    waitWindow.css('color', '#336899');
    waitWindow.css('text-align', 'center');
    waitWindow.css('font-weight', 'bold');

    $(document.body).append(waitWindow);
    waitWindow.hide();

    var modalBlock = document.createElement('div');
    modalWindow = $(modalBlock);
    modalWindow.css('border', '1px solid #A6C9E2');
    modalWindow.css('backgroundColor', '#fff');
    modalWindow.css('padding', '50px');
    modalWindow.css('zIndex', '1200');
    modalWindow.css('font-family', 'Tahoma, Verdana, sans-serif');
    modalWindow.css('font-size', '13px');
    modalWindow.css('color', '#336899');
    modalWindow.css('text-align', 'center');
    $(document.body).append(modalWindow);
    modalWindow.hide();*/
});
/*

function showWaitWindow(text, shadow)
{
    if (typeof shadow == 'undefined')
        shadow = true;

    if (shadow)
    {
        waitShadow.css('width', $(document).width());
        waitShadow.css('height', $(document).height());
        waitShadow.show();
    }

    $('#wait-window-text').text(text);
    var windowObject = $(window);
    waitWindow.css('position', 'absolute');
    waitWindow.css('left', ((windowObject.width() / 2) - (waitWindow.width() / 2) - 100));
    waitWindow.css('top', (windowObject.scrollTop() + windowObject.height() / 2) - (waitWindow.height() / 2) - 60);
    waitWindow.show();
}
function closeWaitWindow()
{
    $('#wait-window-text').text('');
    waitWindow.hide();
    waitShadow.hide();
}

function showModalWindow(html, shadow)
{
    if (typeof shadow == 'undefined')
        shadow = true;

    if (shadow)
    {
        waitShadow.css('width', $(document).width());
        waitShadow.css('height', $(document).height());
        waitShadow.show();
    }

    modalWindow.html(html);
    
    var windowObject = $(window);
    modalWindow.css('position', 'absolute');
    modalWindow.css('left', ((windowObject.width() / 2) - (modalWindow.width() / 2) - 100));
    modalWindow.css('top', (windowObject.scrollTop() + windowObject.height() / 2) - (modalWindow.height() / 2) - 60);
    modalWindow.show();
}
function closeModalWindow()
{
    modalWindow.html('');
    modalWindow.hide();
    waitShadow.hide();
}*/
