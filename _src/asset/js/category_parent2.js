//@prepros-prepend common.js
//@prepros-prepend swiper.min.js
//@prepros-prepend sticky.min.js

/*#########################################################

画面解析後のイベント

#########################################################*/
document.addEventListener("DOMContentLoaded", function(event) {


	/* ========================================================
	メインビジュアルスライダー
	=========================================================*/
	var swiper = new Swiper('.swiper-container', {
		autoplay: {
			delay: 6000
		},
		speed: 1500,
		loop: true,
		resizeReInit: true,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		slidesPerView: "auto",
		centeredSlides: true,
		spaceBetween: 100,
		// observer: true,
		// observeParents: true
	});
	// swiper.on('init', function () {
	// 	document.querySelector(".mv01").classList.add("active");
	// });
	// swiper.on('slideChange', function () {
	// 	document.querySelector(".mv02").classList.add("active");
	// });
	// swiper.init();
});

/*#########################################################

画像などすべての要素を読み込んだ後のイベント

#########################################################*/
window.addEventListener("load", function(event) {

	var sticky = new Sticky('[data-sticky]', {});
console.log(sticky);

});


