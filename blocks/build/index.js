/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["ReactJSXRuntime"];

/***/ }),

/***/ "@wordpress/html-entities":
/*!**************************************!*\
  !*** external ["wp","htmlEntities"] ***!
  \**************************************/
/***/ ((module) => {

module.exports = window["wp"]["htmlEntities"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_html_entities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/html-entities */ "@wordpress/html-entities");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");



const {
  registerPaymentMethod
} = window.wc.wcBlocksRegistry;
const {
  getSetting
} = window.wc.wcSettings;
const settings = getSetting('other_payment_data', {});
const label = (0,_wordpress_html_entities__WEBPACK_IMPORTED_MODULE_0__.decodeEntities)(settings.title);
function Content(props) {
  const [paymentData, setPaymentData] = react__WEBPACK_IMPORTED_MODULE_1__.useState({});
  const {
    eventRegistration,
    emitResponse
  } = props;
  const {
    onPaymentProcessing
  } = eventRegistration;
  react__WEBPACK_IMPORTED_MODULE_1__.useEffect(() => {
    const unsubscribe = onPaymentProcessing(async () => {
      // Here we can do any processing we need, and then emit a response.
      // For example, we might validate a custom field, or perform an AJAX request, and then emit a response indicating it is valid or not.
      const myGatewayCustomData = '12345';
      const customDataIsValid = !!myGatewayCustomData.length;
      if (customDataIsValid) {
        return {
          type: emitResponse.responseTypes.SUCCESS,
          meta: {
            paymentMethodData: {
              ...paymentData
            }
          }
        };
      }
      return {
        type: emitResponse.responseTypes.ERROR,
        message: 'There was an error'
      };
    });
    // Unsubscribes when this component is unmounted.
    return () => {
      unsubscribe();
    };
  }, [emitResponse.responseTypes.ERROR, emitResponse.responseTypes.SUCCESS, onPaymentProcessing, paymentData]);
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.Fragment, {
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Textarea, {
      props: {
        setPaymentData,
        paymentData
      }
    })
  });
}
const Textarea = attr => {
  const isRequired = settings.is_required === 'yes';
  const hideTextBox = settings.hide_text_box === 'yes';
  function setContent(e) {
    const key = 'other_payment-admin-note';
    attr.props.paymentData[key] = e.target.value;
    attr.props.setPaymentData(attr.props.paymentData);
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.Fragment, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
      style: {
        'margin-bottom': 0,
        'margin-top': 0
      },
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("small", {
        style: {
          color: '#9ca3af'
        },
        children: settings.description
      })
    }), !hideTextBox ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("textarea", {
      style: {
        'margin': '5px 0 5px 0'
      },
      className: 'wc-block-components-textarea',
      id: 'other_payment-admin-note',
      name: 'other_payment-admin-note',
      required: isRequired,
      onInput: setContent,
      rows: "2",
      spellCheck: "false"
    }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.Fragment, {})]
  });
};
const Label = props => {
  const {
    PaymentMethodLabel
  } = props.components;
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(PaymentMethodLabel, {
    text: label
  });
};
registerPaymentMethod({
  name: "other_payment",
  label: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Label, {}),
  content: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Content, {}),
  edit: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Content, {}),
  canMakePayment: () => true,
  ariaLabel: label,
  supports: {
    features: settings.supports
  }
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map