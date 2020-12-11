//@prepros-prepend anime.min.js
//@prepros-prepend intersection-observer.js

var ua = navigator.userAgent;
var device = "pc";
// スマホの場合
if((ua.indexOf('iPhone') > 0) || ua.indexOf('iPod') > 0 || (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0)){
	device = "sp";
// PC・タブレット表示の場合
} else {
}

/*#########################################################

画面解析後のイベント

#########################################################*/
document.addEventListener("DOMContentLoaded", function(event) {

	/* ========================================================
	anime.jsを使ったスムーズスクロール
	=========================================================*/
	var links = document.querySelectorAll('a[href*="#"]');  //#がリンクに含まれているアンカータグを全て取得
	for (var i = 0; i < links.length; i++) {
		links[i].addEventListener('click', function (e) {
	//		anime.remove("html, body");

			var href = e.currentTarget.getAttribute('href');   //href取得

			if ( target_id = href.split('#')[1] ){	// ターゲット名の取得
				var target = document.getElementById(target_id);    //リンク先の要素（ターゲット）取得
				var targetRect = target.getBoundingClientRect();   //ターゲットの座標取得
				anime({
					targets: "html, body",
					scrollTop: targetRect.top,
					dulation: 600,
					easing: 'easeOutCubic',
				});
			}
			return false;

		});
	}


	/* ========================================================
	ハンバーガーメニュー
	=========================================================*/

	// ハンバーガーボタン
	var btm_menu = ".--js-menu-button";

	// アコーディオンメニュー：テキストを囲うボックス
	var acbutton_class = "--js-category-title";
	// アコーディオンメニュー：アコーディオン領域
	var acbox_class = "--js-category-menu";

	// テキストアニメーション：テキストを囲うボックス
	var char_class = "--js-charanimation";
	// テキストアニメーション：テキストの下のライン
	var line = "--js-textunderline";
	// テキストアニメーション：テキストを囲うボックスの取得（複数可能）
	var item_anime = document.querySelectorAll("." + char_class);
	// テキストアニメーション：ボックス毎の処理
	for (var i = 0; i < item_anime.length; i++) {
		// 文字の分割
		item_anime[i].innerHTML = item_anime[i].innerText.replace(/[^\x00-\x80]|(\w)/g, "<span class='" + char_class + "'>$&</span>");
	}

	// ハンバーガーボタンのクリックイベントリスナー
	document.querySelector( btm_menu ).addEventListener( "click", function(e){
		e.preventDefault();

		// メニューアイコン（3本線）のトグル処理
		this.classList.toggle( "active" );
		// メニュー背景のトグル処理
		document.querySelector( this.dataset.overlay ).classList.toggle( "active" );


		// メニューを開く
		if( this.classList.contains( "active" ) ){

			// テキストアニメーション：メニュー内のカテゴリリンクの下線アニメーション
			var delay = 50;
			anime.timeline({})
				.add({
					targets: '.' + line,
					scaleX: [0,1],
					opacity: [0.5,1],
					easing: "easeInOutExpo",
					delay: delay,
					duration: 900,
				}).add({
					targets: '.' + char_class,
					opacity: [0,1],
					translateX: [40,0],
					translateZ: 0,
					scaleX: [0.3, 1],
					easing: "easeOutExpo",
					delay: function(el, i) {
						return 25 * i;
					},
					duration: 400,
					offset: '-=400',
				});

			// メニュー背景のアニメーション
			anime({
				targets: this.dataset.bg,
				scale: [0.2, 3],
				opacity: [0.2, 1],
				easing: "easeInCubic",
				duration: 300,
			});
			anime({
				targets: this.dataset.overlay,
				opacity: [0, 1],
				delay: 200,
				easing: "easeInOutExpo",
				duration: 200
			});

		// メニューを閉じる
		} else {

			// メニュー背景のアニメーション
			anime({
				targets: this.dataset.bg,
				scale: [4, 0],
				easing: "easeInExpo",
				duration: 400,
			});
			anime({
				targets: this.dataset.overlay,
				opacity: [1, 0],
				easing: "easeInOutExpo",
				duration: 200
			});

		}

	});
	/* /ハンバーガーメニュー */


	/* ========================================================
	アコーディオン用関数
	=========================================================*/
	// アコーディオン：メニューアイテムの初期化
	var toggleBox = document.getElementsByClassName(acbox_class);
	var togglebox_height = {};
	for (var i = 0; i < toggleBox.length; i++) {
		var name = toggleBox[i].getAttribute("id");
		// 高さを取得
		toggleBox[i].style.height = 'auto';
		// トグルボタンの高さを配列で記録
		togglebox_height[name] = toggleBox[i].clientHeight + 60;

		// トグル要素の非表示対応
		toggleBox[i].style.height = '0px';
		toggleBox[i].style.opacity = 1;
	}

	// アコーディオン：メニューのアコーディオントグル
	var toggleButton = document.getElementsByClassName(acbutton_class);
	for (var i = 0; i < toggleButton.length; i++) {
		// トグル用ボタンをロールオーバーしたときのイベントリスナー
		toggleButton[i].addEventListener('mouseover', function() {

			// メニューの全カテゴリを閉じる
			closeMenuItem(acbox_class);

			// 必要な項目のみ開く
			var tgbox = document.getElementById( this.dataset.id );
			tgbox.style.height = togglebox_height[this.dataset.id] + 40 + 'px';

		});
	}

	// アコーディオン：全メニューアイテムを閉じる
	function closeMenuItem(NAME){
		var toggleBox = document.getElementsByClassName(NAME);
		for (var i = 0; i < toggleBox.length; i++) {
			toggleBox[i].style.height = '0px'
		}
	}


	/* ========================================================
	posts:画像のランダム読み込み
	=========================================================*/
	var array = [];
	for( var i=1; i<=5; i++ ){
		array[i-1] = Math.floor( Math.random() * 27 ) + 1;
		// 重複チェック
		while ( existsSameValue(array) ){
			array[i-1] = Math.floor( Math.random() * 27 ) + 1;
		}

		var type = "v";
		if ( i == 2 ) {
			type = "h";
		} else if( i == 4 ){
			var random = Math.random();
			if (random>0.5){
				type = "h";
			}

		}
		if ( elm = document.querySelector(".post"+i) ) elm.setAttribute("data-src", "/common/img/post/p"+type+array[i-1]+".jpg")
	}
	/** 配列内で値が重複してないか調べる **/
	function existsSameValue(a){
		var s = new Set(a);
		return s.size != a.length;
	}

	/* ========================================================
	posts:画像の遅延読み込み
	=========================================================*/
	var lazyImages = [].slice.call( document.querySelectorAll("img.lazy") );
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



	// 高さ揃え
	setHeightBox();
	if ( device == "pc" ){
		// if ( document.querySelector(".js_fix_title") ){
		// 	setHeightBox("js_fix_title");
		// }
	}

	/* ========================================================
	rhythmfactory.jpへの動線
	=========================================================*/
	// テキストを囲うボックスの取得（複数可能）
	var btn_slide = document.querySelectorAll(".--js-slidebutton");
	// ボックス毎の処理
	for (var i = 0; i < btn_slide.length; i++) {

		// 文字の分割
		btn_slide[i].addEventListener("mouseenter",function(e){
			// console.log(this);
			this.classList.add( "active" );
		});
		btn_slide[i].addEventListener("mouseleave",function(e){
			this.classList.remove( "active" );
		});
	}

});

/* ========================================================
ヘッダのサイズ変更
スクロールでトップに戻るボタンを表示
=========================================================*/
// スクロールして何ピクセルでアニメーションさせるか
var px_change = 300;
// スクロールのイベントハンドラを登録
window.addEventListener('scroll', function(e) {
	// 変化するポイントまでスクロールしたらクラスを追加
	var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	if ( scrollTop > px_change ) {
		addSmaller();
		document.querySelector( ".--js-backtotop-button" ).classList.add( "fadein" );

	// 変化するポイント以前であればクラスを削除
	} else {
		removeSmaller();
		document.querySelector( ".--js-backtotop-button" ).classList.remove( "fadein" );
	}
});



// リサイズ時に縮小ヘッダ用クラスを追加・削除する
var x = 970;
function checkResize(){
	var w = window.innerWidth;
	if (w <= x) {
		addSmaller();
		sp	= true;
	} else {
		removeSmaller();
		sp	= false;
	}
}
window.onresize = function () {
	checkResize();
};
checkResize();

// 縮小ヘッダ用クラスの追加
function addSmaller(){
	document.querySelector( ".site-header" ).classList.add( "is-small" );
	// document.querySelector( ".site_logo" ).classList.remove( "sprite_logo" );
	// document.querySelector( ".site_logo" ).classList.add( "sprite_logo_s" );
}
// 縮小ヘッダ用クラスの削除
function removeSmaller(){
	document.querySelector( ".site-header" ).classList.remove( "is-small" );
	// document.querySelector( ".site_logo" ).classList.add( "sprite_logo" );
	// document.querySelector( ".site_logo" ).classList.remove( "sprite_logo_s" );
}



/*#########################################################

画像などすべての要素を読み込んだ後のイベント

#########################################################*/
window.addEventListener("load", function(event) {

});



/* ========================================================
要素の高さ揃え
=========================================================*/
function setHeightBox(NAME){
	NAME = NAME ? NAME : "js-fix";
	// 高さ揃え
	var elem = document.getElementsByClassName(NAME);
	var h_list = getHeight(elem);
	h_list = Math.max.apply(null, h_list);
	setHeight(elem,h_list);
}
function setHeight(target,h){
	for(var h_i = 0;h_i<target.length;h_i++){
		target[h_i].style.height = h+"px";
	}
}
function getHeight(target){
	var h = [];
	for(var h_n = 0;h_n<target.length;h_n++){
		h[h_n] = target[h_n].clientHeight;
	}
	return h;
}