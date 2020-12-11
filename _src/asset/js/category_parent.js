//@prepros-prepend common.js
//@prepros-prepend swiper.min.js

/*#########################################################

画面解析後のイベント

#########################################################*/
document.addEventListener("DOMContentLoaded", function(event) {

	/* ========================================================
	メインビジュアルスライダー
	=========================================================*/
	var swiper = new Swiper('.swiper-container', {
		// effect: 'fade',
		// init: false,
		// fadeEffect: {
		// 	crossFade: true
		// },
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
		// preloadImages: false,
		// lazy: {
		// 	loadPrevNext: true
		// },
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

