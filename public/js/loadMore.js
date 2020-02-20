/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/loadMore.js":
/*!*****************************************!*\
  !*** ./resources/assets/js/loadMore.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var _throttleTimer = null;
var _throttleDelay = 100;
var $window = $(window);
var $document = $(document);
$document.ready(function () {
  $window.off('scroll', ScrollHandler).on('scroll', ScrollHandler);
});
var page = 1; //track user scroll as page number, right now page number is 1

var urlParams = new URLSearchParams(window.location.search);
var query = urlParams.get('query');
var video = urlParams.get('v');
var genre = urlParams.get('g');
load_more(page); //initial content load

function ScrollHandler(e) {
  //throttle event:
  clearTimeout(_throttleTimer);
  _throttleTimer = setTimeout(function () {
    if ($(window).scrollTop() + $(window).height() + 1200 >= getDocHeight()) {
      page++; //page number increment

      load_more(page); //load content   
    }
  }, _throttleDelay);
}

function getDocHeight() {
  var D = document;
  return Math.max(D.body.scrollHeight, D.documentElement.scrollHeight, D.body.offsetHeight, D.documentElement.offsetHeight, D.body.clientHeight, D.documentElement.clientHeight);
}

function load_more(page) {
  $.ajax({
    url: '?v=' + video + '&g=' + genre + '&page=' + page + '&query=' + query,
    type: "get",
    datatype: "html",
    beforeSend: function beforeSend() {
      $('.ajax-loading').show();
    }
  }).done(function (data) {
    if (data.length == 0) {
      console.log(data.length);
      $('.ajax-loading').html(" ");
      return;
    }

    $('.ajax-loading').hide(); //hide loading animation once data is received

    newDivName = "d" + String(new Date().valueOf());
    var $newhtml = $("<div id='" + newDivName + "'>" + data + "</div>");
    $('#sidebar-results').append($newhtml);
    $('#' + newDivName + ' h5').each(function (index) {
      rank = index + 1 + (page - 1) * 10;

      if (rank < 10) {
        $(this).html('<span style="color:white; background-color:pink; padding: 3px 10px; border-radius:3px;">' + rank + '</span>');
      } else {
        $(this).html('<span style="color:white; background-color:pink; padding: 3px 6px; border-radius:3px;">' + rank + '</span>');
      }
    });
  }).fail(function (jqXHR, ajaxOptions, thrownError) {});
}

/***/ }),

/***/ 3:
/*!***********************************************!*\
  !*** multi ./resources/assets/js/loadMore.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/Justin/twobayjobs/resources/assets/js/loadMore.js */"./resources/assets/js/loadMore.js");


/***/ })

/******/ });