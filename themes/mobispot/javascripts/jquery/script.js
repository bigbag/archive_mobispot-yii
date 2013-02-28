var toggleOpen = function (element) {
	$(element).toggleClass('open');
}

var addActive = function () {
	$(this).addClass('active').siblings().removeClass('active');
}
var toggleActive = function () {
	$(this).toggleClass('active');
}


$(window).load(function() {
	$('.add-active > *').click(addActive);
	$('.toggle-active > *').click(toggleActive);
	$('.store-items__close').click(function(){
		$(this).parents('tr').remove();
	});

});
