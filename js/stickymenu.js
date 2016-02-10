/*Sticky Menu*/
$(window).scroll(function(){
	var y = $(this).scrollTop();
	console.log(y);
	if (y>43) {
		$('header').addClass('fixed');
	}else{
		$('header').removeClass('fixed');
	};
});