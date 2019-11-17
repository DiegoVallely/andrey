/*
    Elfsight WhatsApp Chat
    Version: 1.1.0
    Release date: Fri Aug 23 2019

    https://elfsight.com

    Copyright (c) 2019 Elfsight, LLC. ALL RIGHTS RESERVED
*/

(function(window){"use strict";!function(e){var t={};function i(r){if(t[r])return t[r].exports;var n=t[r]={i:r,l:!1,exports:{}};return e[r].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=t,i.d=function(e,t,r){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},i.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(r,n,function(t){return e[t]}.bind(null,n));return r},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="",i(i.s=0)}([function(e,t){(window.eapps=window.eapps||{}).observer=function(e){e.$watch("widget.data.picture",function(t){e.setPropertyVisibility("pictureLibrary","library"===t),e.setPropertyVisibility("pictureCustom","custom"===t)}),e.$watch("widget.data.whereToDisplayChat",function(t){e.setPropertyVisibility("excludedPages","excludedPages"===t),e.setPropertyVisibility("specificPages","specificPages"===t)}),e.$watch("widget.data.nameCaptionType",function(t){e.setPropertyVisibility("nameCaptionReplyTime","replyTime"===t),e.setPropertyVisibility("nameCaptionCustom","custom"===t)}),e.$watch("widget.data.timeSchedule",function(t){e.setPropertyVisibility("displayStartTime",t),e.setPropertyVisibility("displayEndTime",t)})}}]);})(window)