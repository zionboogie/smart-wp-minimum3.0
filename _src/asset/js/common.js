var ua = navigator.userAgent;
var device = "pc";
// スマホの場合
if (
	ua.indexOf("iPhone") > 0 ||
	ua.indexOf("iPod") > 0 ||
	(ua.indexOf("Android") > 0 && ua.indexOf("Mobile") > 0)
) {
	device = "sp";
	// PC・タブレット表示の場合
} else {
}

/*#########################################################

画面解析後のイベント

#########################################################*/
document.addEventListener("DOMContentLoaded", function (event) {});

/*#########################################################

画像などすべての要素を読み込んだ後のイベント

#########################################################*/
window.addEventListener("load", function (event) {});
