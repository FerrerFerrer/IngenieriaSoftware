(function () { var require = undefined; var module = undefined; var exports = undefined; var define = undefined;(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

function getFieldValues(form, fieldName, evt) {
  var values = [];
  var inputs = form.querySelectorAll('input[name="' + fieldName + '"], select[name="' + fieldName + '"], textarea[name="' + fieldName + '"], button[name="' + fieldName + '"]');

  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    var type = input.type.toLowerCase();

    if ((type === 'radio' || type === 'checkbox') && !input.checked) {
      continue;
    } // ignore buttons which are not clicked (in case there's more than one button with same name)


    if (type === 'button' || type === 'submit' || input.tagName === 'BUTTON') {
      if ((!evt || evt.target !== input) && form.dataset[fieldName] !== input.value) {
        continue;
      }

      form.dataset[fieldName] = input.value;
    }

    values.push(input.value);
  } // default to an empty string
  // can be used to show or hide an element when a field is empty or has not been set
  // Usage: data-show-if="FIELDNAME:"


  if (values.length === 0) {
    values.push('');
  }

  return values;
}

function findForm(element) {
  var bubbleElement = element;

  while (bubbleElement.parentElement) {
    bubbleElement = bubbleElement.parentElement;

    if (bubbleElement.tagName === 'FORM') {
      return bubbleElement;
    }
  }

  return null;
}

function toggleElement(el, evt) {
  var show = !!el.getAttribute('data-show-if');
  var conditions = show ? el.getAttribute('data-show-if').split(':') : el.getAttribute('data-hide-if').split(':');
  var fieldName = conditions[0];
  var expectedValues = (conditions.length > 1 ? conditions[1] : '*').split('|');
  var form = findForm(el);
  var values = getFieldValues(form, fieldName, evt); // determine whether condition is met

  var conditionMet = false;

  for (var i = 0; i < values.length; i++) {
    var value = values[i]; // condition is met when value is in array of expected values OR expected values contains a wildcard and value is not empty

    conditionMet = expectedValues.indexOf(value) > -1 || expectedValues.indexOf('*') > -1 && value.length > 0;

    if (conditionMet) {
      break;
    }
  } // toggle element display


  if (show) {
    el.style.display = conditionMet ? '' : 'none';
  } else {
    el.style.display = conditionMet ? 'none' : '';
  } // find all inputs inside this element and toggle [required] attr (to prevent HTML5 validation on hidden elements)


  var inputs = el.querySelectorAll('input, select, textarea');
  [].forEach.call(inputs, function (el) {
    if ((conditionMet || show) && el.getAttribute('data-was-required')) {
      el.required = true;
      el.removeAttribute('data-was-required');
    }

    if ((!conditionMet || !show) && el.required) {
      el.setAttribute('data-was-required', 'true');
      el.required = false;
    }
  });
} // evaluate conditional elements globally


function evaluate() {
  var elements = document.querySelectorAll('.hf-form [data-show-if], .hf-form [data-hide-if]');
  [].forEach.call(elements, toggleElement);
} // re-evaluate conditional elements for change events on forms


function handleInputEvent(evt) {
  if (!evt.target || !evt.target.form || evt.target.form.className.indexOf('hf-form') < 0) {
    return;
  }

  var form = evt.target.form;
  var elements = form.querySelectorAll('[data-show-if], [data-hide-if]');
  [].forEach.call(elements, function (el) {
    return toggleElement(el, evt);
  });
}

var _default = {
  init: function init() {
    document.addEventListener('click', handleInputEvent, true);
    document.addEventListener('keyup', handleInputEvent, true);
    document.addEventListener('change', handleInputEvent, true);
    document.addEventListener('hf-refresh', evaluate, true);
    window.addEventListener('load', evaluate);
    evaluate();
  }
};
exports["default"] = _default;

},{}],2:[function(require,module,exports){
'use strict';

function getButtonText(button) {
  return button.innerHTML ? button.innerHTML : button.value;
}

function setButtonText(button, text) {
  button.innerHTML ? button.innerHTML = text : button.value = text;
}

function Loader(formElement) {
  this.form = formElement;
  this.button = formElement.querySelector('input[type="submit"], button[type="submit"]');
  this.loadingInterval = 0;
  this.character = "\xB7";

  if (this.button) {
    this.originalButton = this.button.cloneNode(true);
  }
}

Loader.prototype.setCharacter = function (c) {
  this.character = c;
};

Loader.prototype.start = function () {
  if (this.button) {
    // loading text
    var loadingText = this.button.getAttribute('data-loading-text');

    if (loadingText) {
      setButtonText(this.button, loadingText);
      return;
    } // Show AJAX loader


    var styles = window.getComputedStyle(this.button);
    this.button.style.width = styles.width;
    setButtonText(this.button, this.character);
    this.loadingInterval = window.setInterval(this.tick.bind(this), 500);
  } else {
    this.form.style.opacity = '0.5';
  }
};

Loader.prototype.tick = function () {
  // count chars, start over at 5
  var text = getButtonText(this.button);
  var loadingChar = this.character;
  setButtonText(this.button, text.length >= 5 ? loadingChar : text + ' ' + loadingChar);
};

Loader.prototype.stop = function () {
  if (this.button) {
    this.button.style.width = this.originalButton.style.width;
    var text = getButtonText(this.originalButton);
    setButtonText(this.button, text);
    window.clearInterval(this.loadingInterval);
  } else {
    this.form.style.opacity = '';
  }
};

module.exports = Loader;

},{}],3:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

var populate = require('populate.js'); // parse ?query=string with array support. no nesting.


function parseUrlParams(q) {
  var params = new URLSearchParams(q);
  var obj = {};
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = params.entries()[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var _step$value = _slicedToArray(_step.value, 2),
          name = _step$value[0],
          value = _step$value[1];

      if (name.substr(name.length - 2) === '[]') {
        var arrName = name.substr(0, name.length - 2);
        obj[arrName] = obj[arrName] || [];
        obj[arrName].push(value);
      } else {
        obj[name] = value;
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator["return"] != null) {
        _iterator["return"]();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  return obj;
}

function init() {
  if (!window.URLSearchParams) {
    return;
  } // only act on form elements outputted by HTML Forms


  var forms = [].filter.call(document.forms, function (f) {
    return f.className.indexOf('hf-form') > -1;
  });

  if (!forms) {
    return;
  } // fill each form with data from URL params


  var data = parseUrlParams(window.location.search);
  forms.forEach(function (f) {
    populate(f, data);
  });
}

var _default = {
  init: init
};
exports["default"] = _default;

},{"populate.js":6}],4:[function(require,module,exports){
"use strict";

/* window.CustomEvent polyfill for IE */
(function () {
  if (typeof window.CustomEvent === 'function') return false;

  function CustomEvent(event, params) {
    params = params || {
      bubbles: false,
      cancelable: false,
      detail: undefined
    };
    var evt = document.createEvent('CustomEvent');
    evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
    return evt;
  }

  CustomEvent.prototype = window.Event.prototype;
  window.CustomEvent = CustomEvent;
})();

},{}],5:[function(require,module,exports){
"use strict";

var _formPrefiller = _interopRequireDefault(require("./form-prefiller.js"));

var _conditionality = _interopRequireDefault(require("./conditionality.js"));

require("./polyfills/custom-event.js");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var Loader = require('./form-loading-indicator.js');

var vars = window.hf_js_vars || {
  ajax_url: window.location.href
};

var EventEmitter = require('wolfy87-eventemitter');

var events = new EventEmitter();

function cleanFormMessages(formEl) {
  var messageElements = formEl.querySelectorAll('.hf-message');
  [].forEach.call(messageElements, function (el) {
    el.parentNode.removeChild(el);
  });
}

function addFormMessage(formEl, message) {
  var txtElement = document.createElement('p');
  txtElement.className = 'hf-message hf-message-' + message.type;
  txtElement.innerHTML = message.text; // uses innerHTML because we allow some HTML strings in the message settings

  txtElement.role = 'alert';
  var wrapperElement = formEl.querySelector('.hf-messages') || formEl;
  wrapperElement.appendChild(txtElement);
}

function handleSubmitEvents(e) {
  var formEl = e.target;

  if (formEl.className.indexOf('hf-form') < 0) {
    return;
  } // always prevent default (because regular submit doesn't work for HTML Forms)


  e.preventDefault();
  submitForm(formEl);
}

function submitForm(formEl) {
  cleanFormMessages(formEl);
  emitEvent('submit', formEl);
  var formData = new FormData(formEl);
  [].forEach.call(formEl.querySelectorAll('[data-was-required=true]'), function (el) {
    formData.append('_was_required[]', el.getAttribute('name'));
  });
  var request = new XMLHttpRequest();
  request.onreadystatechange = createRequestHandler(formEl);
  request.open('POST', vars.ajax_url, true);
  request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  request.send(formData);
  request = null;
}

function emitEvent(eventName, element) {
  // browser event API: formElement.on('hf-success', ..)
  element.dispatchEvent(new CustomEvent('hf-' + eventName)); // custom events API: html_forms.on('success', ..)

  events.emit(eventName, [element]);
}

function createRequestHandler(formEl) {
  var loader = new Loader(formEl);
  loader.start();
  return function () {
    // are we done?
    if (this.readyState === 4) {
      var response;
      loader.stop();

      if (this.status >= 200 && this.status < 400) {
        try {
          response = JSON.parse(this.responseText);
        } catch (error) {
          console.log('HTML Forms: failed to parse AJAX response.\n\nError: "' + error + '"');
          return;
        }

        emitEvent('submitted', formEl);

        if (response.error) {
          emitEvent('error', formEl);
        } else {
          emitEvent('success', formEl);
        } // Show form message


        if (response.message) {
          addFormMessage(formEl, response.message);
          emitEvent('message', formEl);
        } // Should we hide form?


        if (response.hide_form) {
          formEl.querySelector('.hf-fields-wrap').style.display = 'none';
        } // Should we redirect?


        if (response.redirect_url) {
          window.location = response.redirect_url;
        } // clear form


        if (!response.error) {
          formEl.reset();
        }
      } else {
        // Server error :(
        console.log(this.responseText);
      }
    }
  };
}

document.addEventListener('submit', handleSubmitEvents, false); // useCapture=false to ensure we bubble upwards (and thus can cancel propagation)

_conditionality["default"].init();

_formPrefiller["default"].init();

window.html_forms = {
  on: events.on.bind(events),
  submit: submitForm
};

},{"./conditionality.js":1,"./form-loading-indicator.js":2,"./form-prefiller.js":3,"./polyfills/custom-event.js":4,"wolfy87-eventemitter":7}],6:[function(require,module,exports){
/*! populate.js v1.0.2 by @dannyvankooten | MIT license */
;(function(root) {

	/**
	 * Populate form fields from a JSON object.
	 *
	 * @param form object The form element containing your input fields.
	 * @param data array JSON data to populate the fields with.
	 * @param basename string Optional basename which is added to `name` attributes
	 */
	var populate = function( form, data, basename) {

		for(var key in data) {

			if( ! data.hasOwnProperty( key ) ) {
				continue;
			}

			var name = key;
			var value = data[key];

                        if ('undefined' === typeof value) {
                            value = '';
                        }

                        if (null === value) {
                            value = '';
                        }

			// handle array name attributes
			if(typeof(basename) !== "undefined") {
				name = basename + "[" + key + "]";
			}

			if(value.constructor === Array) {
				name += '[]';
			} else if(typeof value == "object") {
				populate( form, value, name);
				continue;
			}

			// only proceed if element is set
			var element = form.elements.namedItem( name );
			if( ! element ) {
				continue;
			}

			var type = element.type || element[0].type;

			switch(type ) {
				default:
					element.value = value;
					break;

				case 'radio':
				case 'checkbox':
					for( var j=0; j < element.length; j++ ) {
						element[j].checked = ( value.indexOf(element[j].value) > -1 );
					}
					break;

				case 'select-multiple':
					var values = value.constructor == Array ? value : [value];

					for(var k = 0; k < element.options.length; k++) {
						element.options[k].selected |= (values.indexOf(element.options[k].value) > -1 );
					}
					break;

				case 'select':
				case 'select-one':
					element.value = value.toString() || value;
					break;
				case 'date':
          				element.value = new Date(value).toISOString().split('T')[0];	
					break;
			}

		}

	};

	// Play nice with AMD, CommonJS or a plain global object.
	if ( typeof define == 'function' && typeof define.amd == 'object' && define.amd ) {
		define(function() {
			return populate;
		});
	}	else if ( typeof module !== 'undefined' && module.exports ) {
		module.exports = populate;
	} else {
		root.populate = populate;
	}

}(this));

},{}],7:[function(require,module,exports){
/*!
 * EventEmitter v5.2.6 - git.io/ee
 * Unlicense - http://unlicense.org/
 * Oliver Caldwell - https://oli.me.uk/
 * @preserve
 */

;(function (exports) {
    'use strict';

    /**
     * Class for managing events.
     * Can be extended to provide event functionality in other classes.
     *
     * @class EventEmitter Manages event registering and emitting.
     */
    function EventEmitter() {}

    // Shortcuts to improve speed and size
    var proto = EventEmitter.prototype;
    var originalGlobalValue = exports.EventEmitter;

    /**
     * Finds the index of the listener for the event in its storage array.
     *
     * @param {Function[]} listeners Array of listeners to search through.
     * @param {Function} listener Method to look for.
     * @return {Number} Index of the specified listener, -1 if not found
     * @api private
     */
    function indexOfListener(listeners, listener) {
        var i = listeners.length;
        while (i--) {
            if (listeners[i].listener === listener) {
                return i;
            }
        }

        return -1;
    }

    /**
     * Alias a method while keeping the context correct, to allow for overwriting of target method.
     *
     * @param {String} name The name of the target method.
     * @return {Function} The aliased method
     * @api private
     */
    function alias(name) {
        return function aliasClosure() {
            return this[name].apply(this, arguments);
        };
    }

    /**
     * Returns the listener array for the specified event.
     * Will initialise the event object and listener arrays if required.
     * Will return an object if you use a regex search. The object contains keys for each matched event. So /ba[rz]/ might return an object containing bar and baz. But only if you have either defined them with defineEvent or added some listeners to them.
     * Each property in the object response is an array of listener functions.
     *
     * @param {String|RegExp} evt Name of the event to return the listeners from.
     * @return {Function[]|Object} All listener functions for the event.
     */
    proto.getListeners = function getListeners(evt) {
        var events = this._getEvents();
        var response;
        var key;

        // Return a concatenated array of all matching events if
        // the selector is a regular expression.
        if (evt instanceof RegExp) {
            response = {};
            for (key in events) {
                if (events.hasOwnProperty(key) && evt.test(key)) {
                    response[key] = events[key];
                }
            }
        }
        else {
            response = events[evt] || (events[evt] = []);
        }

        return response;
    };

    /**
     * Takes a list of listener objects and flattens it into a list of listener functions.
     *
     * @param {Object[]} listeners Raw listener objects.
     * @return {Function[]} Just the listener functions.
     */
    proto.flattenListeners = function flattenListeners(listeners) {
        var flatListeners = [];
        var i;

        for (i = 0; i < listeners.length; i += 1) {
            flatListeners.push(listeners[i].listener);
        }

        return flatListeners;
    };

    /**
     * Fetches the requested listeners via getListeners but will always return the results inside an object. This is mainly for internal use but others may find it useful.
     *
     * @param {String|RegExp} evt Name of the event to return the listeners from.
     * @return {Object} All listener functions for an event in an object.
     */
    proto.getListenersAsObject = function getListenersAsObject(evt) {
        var listeners = this.getListeners(evt);
        var response;

        if (listeners instanceof Array) {
            response = {};
            response[evt] = listeners;
        }

        return response || listeners;
    };

    function isValidListener (listener) {
        if (typeof listener === 'function' || listener instanceof RegExp) {
            return true
        } else if (listener && typeof listener === 'object') {
            return isValidListener(listener.listener)
        } else {
            return false
        }
    }

    /**
     * Adds a listener function to the specified event.
     * The listener will not be added if it is a duplicate.
     * If the listener returns true then it will be removed after it is called.
     * If you pass a regular expression as the event name then the listener will be added to all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to attach the listener to.
     * @param {Function} listener Method to be called when the event is emitted. If the function returns true then it will be removed after calling.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.addListener = function addListener(evt, listener) {
        if (!isValidListener(listener)) {
            throw new TypeError('listener must be a function');
        }

        var listeners = this.getListenersAsObject(evt);
        var listenerIsWrapped = typeof listener === 'object';
        var key;

        for (key in listeners) {
            if (listeners.hasOwnProperty(key) && indexOfListener(listeners[key], listener) === -1) {
                listeners[key].push(listenerIsWrapped ? listener : {
                    listener: listener,
                    once: false
                });
            }
        }

        return this;
    };

    /**
     * Alias of addListener
     */
    proto.on = alias('addListener');

    /**
     * Semi-alias of addListener. It will add a listener that will be
     * automatically removed after its first execution.
     *
     * @param {String|RegExp} evt Name of the event to attach the listener to.
     * @param {Function} listener Method to be called when the event is emitted. If the function returns true then it will be removed after calling.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.addOnceListener = function addOnceListener(evt, listener) {
        return this.addListener(evt, {
            listener: listener,
            once: true
        });
    };

    /**
     * Alias of addOnceListener.
     */
    proto.once = alias('addOnceListener');

    /**
     * Defines an event name. This is required if you want to use a regex to add a listener to multiple events at once. If you don't do this then how do you expect it to know what event to add to? Should it just add to every possible match for a regex? No. That is scary and bad.
     * You need to tell it what event names should be matched by a regex.
     *
     * @param {String} evt Name of the event to create.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.defineEvent = function defineEvent(evt) {
        this.getListeners(evt);
        return this;
    };

    /**
     * Uses defineEvent to define multiple events.
     *
     * @param {String[]} evts An array of event names to define.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.defineEvents = function defineEvents(evts) {
        for (var i = 0; i < evts.length; i += 1) {
            this.defineEvent(evts[i]);
        }
        return this;
    };

    /**
     * Removes a listener function from the specified event.
     * When passed a regular expression as the event name, it will remove the listener from all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to remove the listener from.
     * @param {Function} listener Method to remove from the event.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.removeListener = function removeListener(evt, listener) {
        var listeners = this.getListenersAsObject(evt);
        var index;
        var key;

        for (key in listeners) {
            if (listeners.hasOwnProperty(key)) {
                index = indexOfListener(listeners[key], listener);

                if (index !== -1) {
                    listeners[key].splice(index, 1);
                }
            }
        }

        return this;
    };

    /**
     * Alias of removeListener
     */
    proto.off = alias('removeListener');

    /**
     * Adds listeners in bulk using the manipulateListeners method.
     * If you pass an object as the first argument you can add to multiple events at once. The object should contain key value pairs of events and listeners or listener arrays. You can also pass it an event name and an array of listeners to be added.
     * You can also pass it a regular expression to add the array of listeners to all events that match it.
     * Yeah, this function does quite a bit. That's probably a bad thing.
     *
     * @param {String|Object|RegExp} evt An event name if you will pass an array of listeners next. An object if you wish to add to multiple events at once.
     * @param {Function[]} [listeners] An optional array of listener functions to add.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.addListeners = function addListeners(evt, listeners) {
        // Pass through to manipulateListeners
        return this.manipulateListeners(false, evt, listeners);
    };

    /**
     * Removes listeners in bulk using the manipulateListeners method.
     * If you pass an object as the first argument you can remove from multiple events at once. The object should contain key value pairs of events and listeners or listener arrays.
     * You can also pass it an event name and an array of listeners to be removed.
     * You can also pass it a regular expression to remove the listeners from all events that match it.
     *
     * @param {String|Object|RegExp} evt An event name if you will pass an array of listeners next. An object if you wish to remove from multiple events at once.
     * @param {Function[]} [listeners] An optional array of listener functions to remove.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.removeListeners = function removeListeners(evt, listeners) {
        // Pass through to manipulateListeners
        return this.manipulateListeners(true, evt, listeners);
    };

    /**
     * Edits listeners in bulk. The addListeners and removeListeners methods both use this to do their job. You should really use those instead, this is a little lower level.
     * The first argument will determine if the listeners are removed (true) or added (false).
     * If you pass an object as the second argument you can add/remove from multiple events at once. The object should contain key value pairs of events and listeners or listener arrays.
     * You can also pass it an event name and an array of listeners to be added/removed.
     * You can also pass it a regular expression to manipulate the listeners of all events that match it.
     *
     * @param {Boolean} remove True if you want to remove listeners, false if you want to add.
     * @param {String|Object|RegExp} evt An event name if you will pass an array of listeners next. An object if you wish to add/remove from multiple events at once.
     * @param {Function[]} [listeners] An optional array of listener functions to add/remove.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.manipulateListeners = function manipulateListeners(remove, evt, listeners) {
        var i;
        var value;
        var single = remove ? this.removeListener : this.addListener;
        var multiple = remove ? this.removeListeners : this.addListeners;

        // If evt is an object then pass each of its properties to this method
        if (typeof evt === 'object' && !(evt instanceof RegExp)) {
            for (i in evt) {
                if (evt.hasOwnProperty(i) && (value = evt[i])) {
                    // Pass the single listener straight through to the singular method
                    if (typeof value === 'function') {
                        single.call(this, i, value);
                    }
                    else {
                        // Otherwise pass back to the multiple function
                        multiple.call(this, i, value);
                    }
                }
            }
        }
        else {
            // So evt must be a string
            // And listeners must be an array of listeners
            // Loop over it and pass each one to the multiple method
            i = listeners.length;
            while (i--) {
                single.call(this, evt, listeners[i]);
            }
        }

        return this;
    };

    /**
     * Removes all listeners from a specified event.
     * If you do not specify an event then all listeners will be removed.
     * That means every event will be emptied.
     * You can also pass a regex to remove all events that match it.
     *
     * @param {String|RegExp} [evt] Optional name of the event to remove all listeners for. Will remove from every event if not passed.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.removeEvent = function removeEvent(evt) {
        var type = typeof evt;
        var events = this._getEvents();
        var key;

        // Remove different things depending on the state of evt
        if (type === 'string') {
            // Remove all listeners for the specified event
            delete events[evt];
        }
        else if (evt instanceof RegExp) {
            // Remove all events matching the regex.
            for (key in events) {
                if (events.hasOwnProperty(key) && evt.test(key)) {
                    delete events[key];
                }
            }
        }
        else {
            // Remove all listeners in all events
            delete this._events;
        }

        return this;
    };

    /**
     * Alias of removeEvent.
     *
     * Added to mirror the node API.
     */
    proto.removeAllListeners = alias('removeEvent');

    /**
     * Emits an event of your choice.
     * When emitted, every listener attached to that event will be executed.
     * If you pass the optional argument array then those arguments will be passed to every listener upon execution.
     * Because it uses `apply`, your array of arguments will be passed as if you wrote them out separately.
     * So they will not arrive within the array on the other side, they will be separate.
     * You can also pass a regular expression to emit to all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to emit and execute listeners for.
     * @param {Array} [args] Optional array of arguments to be passed to each listener.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.emitEvent = function emitEvent(evt, args) {
        var listenersMap = this.getListenersAsObject(evt);
        var listeners;
        var listener;
        var i;
        var key;
        var response;

        for (key in listenersMap) {
            if (listenersMap.hasOwnProperty(key)) {
                listeners = listenersMap[key].slice(0);

                for (i = 0; i < listeners.length; i++) {
                    // If the listener returns true then it shall be removed from the event
                    // The function is executed either with a basic call or an apply if there is an args array
                    listener = listeners[i];

                    if (listener.once === true) {
                        this.removeListener(evt, listener.listener);
                    }

                    response = listener.listener.apply(this, args || []);

                    if (response === this._getOnceReturnValue()) {
                        this.removeListener(evt, listener.listener);
                    }
                }
            }
        }

        return this;
    };

    /**
     * Alias of emitEvent
     */
    proto.trigger = alias('emitEvent');

    /**
     * Subtly different from emitEvent in that it will pass its arguments on to the listeners, as opposed to taking a single array of arguments to pass on.
     * As with emitEvent, you can pass a regex in place of the event name to emit to all events that match it.
     *
     * @param {String|RegExp} evt Name of the event to emit and execute listeners for.
     * @param {...*} Optional additional arguments to be passed to each listener.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.emit = function emit(evt) {
        var args = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(evt, args);
    };

    /**
     * Sets the current value to check against when executing listeners. If a
     * listeners return value matches the one set here then it will be removed
     * after execution. This value defaults to true.
     *
     * @param {*} value The new value to check for when executing listeners.
     * @return {Object} Current instance of EventEmitter for chaining.
     */
    proto.setOnceReturnValue = function setOnceReturnValue(value) {
        this._onceReturnValue = value;
        return this;
    };

    /**
     * Fetches the current value to check against when executing listeners. If
     * the listeners return value matches this one then it should be removed
     * automatically. It will return true by default.
     *
     * @return {*|Boolean} The current value to check for or the default, true.
     * @api private
     */
    proto._getOnceReturnValue = function _getOnceReturnValue() {
        if (this.hasOwnProperty('_onceReturnValue')) {
            return this._onceReturnValue;
        }
        else {
            return true;
        }
    };

    /**
     * Fetches the events object and creates one if required.
     *
     * @return {Object} The events storage object.
     * @api private
     */
    proto._getEvents = function _getEvents() {
        return this._events || (this._events = {});
    };

    /**
     * Reverts the global {@link EventEmitter} to its previous value and returns a reference to this version.
     *
     * @return {Function} Non conflicting EventEmitter class.
     */
    EventEmitter.noConflict = function noConflict() {
        exports.EventEmitter = originalGlobalValue;
        return EventEmitter;
    };

    // Expose the class either via AMD, CommonJS or the global object
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return EventEmitter;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = EventEmitter;
    }
    else {
        exports.EventEmitter = EventEmitter;
    }
}(typeof window !== 'undefined' ? window : this || {}));

},{}]},{},[5]);
; })();