//@prepros-prepend common.js
//@prepros-prepend swiper.min.js

/*#########################################################

画面解析後のイベント

#########################################################*/
document.addEventListener("DOMContentLoaded", function(event) {

	/* ========================================================
	モーダルの表示
	=========================================================*/
	function setModal(NAME){
		NAME = NAME ? NAME : "";
		var modal = document.querySelector('.--js-modal'+NAME);	// モーダルウインドウ
		var openModal = document.querySelectorAll('.--js-openmodal'+NAME);	// モーダル呼び出しボタン
		var closeModal = document.querySelectorAll('.--js-closemodal'+NAME);	// 閉じるボタン
		var name;

		if ( openModal && modal ){
			for (var i = 0; i < openModal.length; i++) {
				// モーダルを開くボタンをクリック
				openModal[i].addEventListener('click', function(e){
					e.preventDefault();
					// Musicの場合
					if ( name = this.dataset.name ){
						document.querySelector(".--js-youtube-modal").innerHTML = document.querySelector(this.dataset.name).innerHTML;
						var name = ".--js-youtube-modal .youtube-player"
						document.querySelector(name).setAttribute("src", document.querySelector(name).getAttribute("data-src"));
					}

					modal.classList.add('--js-show-modal');
					// スクロール禁止
					document.querySelector('html, body').style.overflow = 'hidden';
				});
			}
			for (var i = 0; i < closeModal.length; i++) {
				// モーダルを閉じるボタンをクリック
				closeModal[i].addEventListener('click', function(){
					modal.classList.remove('--js-show-modal');
					// スクロール解除
					document.querySelector('html, body').style.overflow = 'auto';
				});
			}
		}
	}

	if ( device == "sp" ){
		// var youtube = document.querySelectorAll('.sp .youtube-player');
		// if ( youtube ){
		// 	for (var i = 0; i < youtube.length; i++) {
		// 		youtube[i].setAttribute("src", youtube[i].getAttribute("data-src"));
		// 	}
		// }

		/* ========================================================
		youtube動画の遅延読み込み
		=========================================================*/
		var lazyImages = [].slice.call( document.querySelectorAll(".sp .youtube-player") );
		if ( "IntersectionObserver" in window ) {
			var lazyImageObserver = new IntersectionObserver(function(entries, observer) {
				entries.forEach(function(entry) {
					if ( entry.isIntersecting ) {
						var lazyImage = entry.target;
						lazyImage.src = lazyImage.dataset.src;
						if (typeof lazyImage.dataset.srcset !== "undefined") {
							lazyImage.srcset = lazyImage.dataset.srcset;
						}
						lazyImage.classList.add("lazyloaded");
						lazyImageObserver.unobserve(lazyImage);
					}
				});
			});

			lazyImages.forEach(function(lazyImage) {
				lazyImageObserver.observe(lazyImage);
			});
		}

	}

	/* ========================================================
	PC/SP画像切り替え（Swiper用）
	=========================================================*/
	function swiperLazySup(){
		var windowWidth = window.innerWidth;
		var elm = document.querySelectorAll('img.swiper-lazy');
		if( windowWidth < 767 ){
			for (var i = 0; i < elm.length; i++) {
				var str = elm[i].getAttribute('data-src');
				if ( str ){
					var src = elm[i].getAttribute('data-src').replace('.jpg','_sp.jpg');
					elm[i].setAttribute("data-src", src);
				}
			}
		} else {
			for (var i = 0; i < elm.length; i++) {
				var str = elm[i].getAttribute('data-src');
				if ( str ){
					var src = elm[i].getAttribute('data-src').replace('_sp.jpg','.jpg');
					elm[i].setAttribute("data-src", src);
				}
			}
		}
	}
	swiperLazySup();


	/* ========================================================
	メインビジュアルスライダー
	=========================================================*/
	var swiper = new Swiper('.--js-swiper1', {
		effect: 'fade',
		init: false,
		fadeEffect: {
			crossFade: true
		},
		autoplay: {
			delay: 8000
		},
		speed: 1500,
		resizeReInit: true,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		preloadImages: false,
		lazy: {
			loadPrevNext: true
		},
		// observer: true,
		// observeParents: true
	});
	swiper.on('init', function () {
		document.querySelector(".-mv01").classList.add("active");
	});
	swiper.on('slideChange', function () {
		document.querySelector(".-mv02").classList.add("active");
	});
	swiper.init();

	/* ========================================================
	カテゴリスライダー
	=========================================================*/
	var swiper2 = new Swiper('.--js-swiper2', {
		autoplay: {
			delay: 5000
		},
		speed: 1500,
		loop: true,
		slidesPerView: "auto",
		spaceBetween: 30,
		navigation: {
			nextEl: '.swiper-button-next2',
			prevEl: '.swiper-button-prev2',
		},
		pagination: {
			el: '.swiper-pagination2',
			clickable: true,
		},
	});
	var swiper3 = new Swiper('.--js-swiper3', {
		autoplay: {
			delay: 6000
		},
		speed: 1500,
		loop: true,
		slidesPerView: "auto",
		spaceBetween: 30,
		navigation: {
			nextEl: '.swiper-button-next3',
			prevEl: '.swiper-button-prev3',
		},
		pagination: {
			el: '.swiper-pagination3',
			clickable: true,
		},
	});

	/* ========================================================
	Musicスライダー
	=========================================================*/
	var swiper4 = new Swiper('.--js-swiper4', {
		autoplay: {
			delay: 5000
		},
		speed: 1000,
		loop: true,
		slidesPerView: "auto",
		// spaceBetween: 10,
		navigation: {
			nextEl: '.swiper-button-next4',
			prevEl: '.swiper-button-prev4',
		},
		pagination: {
			el: '.swiper-pagination4',
			clickable: true,
		},
		on: {
			init: function () {
				// Music
				setModal("music");
			},
		},
	});
});