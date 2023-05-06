"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["js_libs_GLTFExporter_js"],{

/***/ "./js/libs/GLTFExporter.js":
/*!*********************************!*\
  !*** ./js/libs/GLTFExporter.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "GLTFExporter": () => (/* binding */ GLTFExporter)
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var _require = __webpack_require__(/*! three */ "./node_modules/three/three.js"),
  BufferAttribute = _require.BufferAttribute,
  ClampToEdgeWrapping = _require.ClampToEdgeWrapping,
  DoubleSide = _require.DoubleSide,
  InterpolateDiscrete = _require.InterpolateDiscrete,
  InterpolateLinear = _require.InterpolateLinear,
  LinearEncoding = _require.LinearEncoding,
  LinearFilter = _require.LinearFilter,
  LinearMipmapLinearFilter = _require.LinearMipmapLinearFilter,
  LinearMipmapNearestFilter = _require.LinearMipmapNearestFilter,
  MathUtils = _require.MathUtils,
  Matrix4 = _require.Matrix4,
  MirroredRepeatWrapping = _require.MirroredRepeatWrapping,
  NearestFilter = _require.NearestFilter,
  NearestMipmapLinearFilter = _require.NearestMipmapLinearFilter,
  NearestMipmapNearestFilter = _require.NearestMipmapNearestFilter,
  PropertyBinding = _require.PropertyBinding,
  RGBAFormat = _require.RGBAFormat,
  RepeatWrapping = _require.RepeatWrapping,
  Scene = _require.Scene,
  Source = _require.Source,
  sRGBEncoding = _require.sRGBEncoding,
  Vector3 = _require.Vector3;
var GLTFExporter = /*#__PURE__*/function () {
  function GLTFExporter() {
    _classCallCheck(this, GLTFExporter);
    this.pluginCallbacks = [];
    this.register(function (writer) {
      return new GLTFLightExtension(writer);
    });
    this.register(function (writer) {
      return new GLTFMaterialsUnlitExtension(writer);
    });
    this.register(function (writer) {
      return new GLTFMaterialsTransmissionExtension(writer);
    });
    this.register(function (writer) {
      return new GLTFMaterialsVolumeExtension(writer);
    });
    this.register(function (writer) {
      return new GLTFMaterialsClearcoatExtension(writer);
    });
    this.register(function (writer) {
      return new GLTFMaterialsIridescenceExtension(writer);
    });
  }
  _createClass(GLTFExporter, [{
    key: "register",
    value: function register(callback) {
      if (this.pluginCallbacks.indexOf(callback) === -1) {
        this.pluginCallbacks.push(callback);
      }
      return this;
    }
  }, {
    key: "unregister",
    value: function unregister(callback) {
      if (this.pluginCallbacks.indexOf(callback) !== -1) {
        this.pluginCallbacks.splice(this.pluginCallbacks.indexOf(callback), 1);
      }
      return this;
    }

    /**
     * Parse scenes and generate GLTF output
     * @param  {Scene or [THREE.Scenes]} input   Scene or Array of THREE.Scenes
     * @param  {Function} onDone  Callback on completed
     * @param  {Function} onError  Callback on errors
     * @param  {Object} options options
     */
  }, {
    key: "parse",
    value: function parse(input, onDone, onError, options) {
      var writer = new GLTFWriter();
      var plugins = [];
      for (var i = 0, il = this.pluginCallbacks.length; i < il; i++) {
        plugins.push(this.pluginCallbacks[i](writer));
      }
      writer.setPlugins(plugins);
      writer.write(input, onDone, options)["catch"](onError);
    }
  }, {
    key: "parseAsync",
    value: function parseAsync(input, options) {
      var scope = this;
      return new Promise(function (resolve, reject) {
        scope.parse(input, resolve, reject, options);
      });
    }
  }]);
  return GLTFExporter;
}(); //------------------------------------------------------------------------------
// Constants
//------------------------------------------------------------------------------
var WEBGL_CONSTANTS = {
  POINTS: 0x0000,
  LINES: 0x0001,
  LINE_LOOP: 0x0002,
  LINE_STRIP: 0x0003,
  TRIANGLES: 0x0004,
  TRIANGLE_STRIP: 0x0005,
  TRIANGLE_FAN: 0x0006,
  UNSIGNED_BYTE: 0x1401,
  UNSIGNED_SHORT: 0x1403,
  FLOAT: 0x1406,
  UNSIGNED_INT: 0x1405,
  ARRAY_BUFFER: 0x8892,
  ELEMENT_ARRAY_BUFFER: 0x8893,
  NEAREST: 0x2600,
  LINEAR: 0x2601,
  NEAREST_MIPMAP_NEAREST: 0x2700,
  LINEAR_MIPMAP_NEAREST: 0x2701,
  NEAREST_MIPMAP_LINEAR: 0x2702,
  LINEAR_MIPMAP_LINEAR: 0x2703,
  CLAMP_TO_EDGE: 33071,
  MIRRORED_REPEAT: 33648,
  REPEAT: 10497
};
var THREE_TO_WEBGL = {};
THREE_TO_WEBGL[NearestFilter] = WEBGL_CONSTANTS.NEAREST;
THREE_TO_WEBGL[NearestMipmapNearestFilter] = WEBGL_CONSTANTS.NEAREST_MIPMAP_NEAREST;
THREE_TO_WEBGL[NearestMipmapLinearFilter] = WEBGL_CONSTANTS.NEAREST_MIPMAP_LINEAR;
THREE_TO_WEBGL[LinearFilter] = WEBGL_CONSTANTS.LINEAR;
THREE_TO_WEBGL[LinearMipmapNearestFilter] = WEBGL_CONSTANTS.LINEAR_MIPMAP_NEAREST;
THREE_TO_WEBGL[LinearMipmapLinearFilter] = WEBGL_CONSTANTS.LINEAR_MIPMAP_LINEAR;
THREE_TO_WEBGL[ClampToEdgeWrapping] = WEBGL_CONSTANTS.CLAMP_TO_EDGE;
THREE_TO_WEBGL[RepeatWrapping] = WEBGL_CONSTANTS.REPEAT;
THREE_TO_WEBGL[MirroredRepeatWrapping] = WEBGL_CONSTANTS.MIRRORED_REPEAT;
var PATH_PROPERTIES = {
  scale: 'scale',
  position: 'translation',
  quaternion: 'rotation',
  morphTargetInfluences: 'weights'
};

// GLB constants
// https://github.com/KhronosGroup/glTF/blob/master/specification/2.0/README.md#glb-file-format-specification

var GLB_HEADER_BYTES = 12;
var GLB_HEADER_MAGIC = 0x46546C67;
var GLB_VERSION = 2;
var GLB_CHUNK_PREFIX_BYTES = 8;
var GLB_CHUNK_TYPE_JSON = 0x4E4F534A;
var GLB_CHUNK_TYPE_BIN = 0x004E4942;

//------------------------------------------------------------------------------
// Utility functions
//------------------------------------------------------------------------------

/**
 * Compare two arrays
 * @param  {Array} array1 Array 1 to compare
 * @param  {Array} array2 Array 2 to compare
 * @return {Boolean}        Returns true if both arrays are equal
 */
function equalArray(array1, array2) {
  return array1.length === array2.length && array1.every(function (element, index) {
    return element === array2[index];
  });
}

/**
 * Converts a string to an ArrayBuffer.
 * @param  {string} text
 * @return {ArrayBuffer}
 */
function stringToArrayBuffer(text) {
  return new TextEncoder().encode(text).buffer;
}

/**
 * Is identity matrix
 *
 * @param {Matrix4} matrix
 * @returns {Boolean} Returns true, if parameter is identity matrix
 */
function isIdentityMatrix(matrix) {
  return equalArray(matrix.elements, [1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1]);
}

/**
 * Get the min and max vectors from the given attribute
 * @param  {BufferAttribute} attribute Attribute to find the min/max in range from start to start + count
 * @param  {Integer} start
 * @param  {Integer} count
 * @return {Object} Object containing the `min` and `max` values (As an array of attribute.itemSize components)
 */
function getMinMax(attribute, start, count) {
  var output = {
    min: new Array(attribute.itemSize).fill(Number.POSITIVE_INFINITY),
    max: new Array(attribute.itemSize).fill(Number.NEGATIVE_INFINITY)
  };
  for (var i = start; i < start + count; i++) {
    for (var a = 0; a < attribute.itemSize; a++) {
      var value = void 0;
      if (attribute.itemSize > 4) {
        // no support for interleaved data for itemSize > 4

        value = attribute.array[i * attribute.itemSize + a];
      } else {
        if (a === 0) value = attribute.getX(i);else if (a === 1) value = attribute.getY(i);else if (a === 2) value = attribute.getZ(i);else if (a === 3) value = attribute.getW(i);
        if (attribute.normalized === true) {
          value = MathUtils.normalize(value, attribute.array);
        }
      }
      output.min[a] = Math.min(output.min[a], value);
      output.max[a] = Math.max(output.max[a], value);
    }
  }
  return output;
}

/**
 * Get the required size + padding for a buffer, rounded to the next 4-byte boundary.
 * https://github.com/KhronosGroup/glTF/tree/master/specification/2.0#data-alignment
 *
 * @param {Integer} bufferSize The size the original buffer.
 * @returns {Integer} new buffer size with required padding.
 *
 */
function getPaddedBufferSize(bufferSize) {
  return Math.ceil(bufferSize / 4) * 4;
}

/**
 * Returns a buffer aligned to 4-byte boundary.
 *
 * @param {ArrayBuffer} arrayBuffer Buffer to pad
 * @param {Integer} paddingByte (Optional)
 * @returns {ArrayBuffer} The same buffer if it's already aligned to 4-byte boundary or a new buffer
 */
function getPaddedArrayBuffer(arrayBuffer) {
  var paddingByte = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
  var paddedLength = getPaddedBufferSize(arrayBuffer.byteLength);
  if (paddedLength !== arrayBuffer.byteLength) {
    var array = new Uint8Array(paddedLength);
    array.set(new Uint8Array(arrayBuffer));
    if (paddingByte !== 0) {
      for (var i = arrayBuffer.byteLength; i < paddedLength; i++) {
        array[i] = paddingByte;
      }
    }
    return array.buffer;
  }
  return arrayBuffer;
}
function getCanvas() {
  if (typeof document === 'undefined' && typeof OffscreenCanvas !== 'undefined') {
    return new OffscreenCanvas(1, 1);
  }
  return document.createElement('canvas');
}
function getToBlobPromise(canvas, mimeType) {
  if (canvas.toBlob !== undefined) {
    return new Promise(function (resolve) {
      return canvas.toBlob(resolve, mimeType);
    });
  }
  var quality;

  // Blink's implementation of convertToBlob seems to default to a quality level of 100%
  // Use the Blink default quality levels of toBlob instead so that file sizes are comparable.
  if (mimeType === 'image/jpeg') {
    quality = 0.92;
  } else if (mimeType === 'image/webp') {
    quality = 0.8;
  }
  return canvas.convertToBlob({
    type: mimeType,
    quality: quality
  });
}

/**
 * Writer
 */
var GLTFWriter = /*#__PURE__*/function () {
  function GLTFWriter() {
    _classCallCheck(this, GLTFWriter);
    this.plugins = [];
    this.options = {};
    this.pending = [];
    this.buffers = [];
    this.byteOffset = 0;
    this.buffers = [];
    this.nodeMap = new Map();
    this.skins = [];
    this.extensionsUsed = {};
    this.uids = new Map();
    this.uid = 0;
    this.json = {
      asset: {
        version: '2.0',
        generator: 'THREE.GLTFExporter'
      }
    };
    this.cache = {
      meshes: new Map(),
      attributes: new Map(),
      attributesNormalized: new Map(),
      materials: new Map(),
      textures: new Map(),
      images: new Map()
    };
  }
  _createClass(GLTFWriter, [{
    key: "setPlugins",
    value: function setPlugins(plugins) {
      this.plugins = plugins;
    }

    /**
     * Parse scenes and generate GLTF output
     * @param  {Scene or [THREE.Scenes]} input   Scene or Array of THREE.Scenes
     * @param  {Function} onDone  Callback on completed
     * @param  {Object} options options
     */
  }, {
    key: "write",
    value: function () {
      var _write = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(input, onDone) {
        var options,
          writer,
          buffers,
          json,
          extensionsUsed,
          blob,
          extensionsUsedList,
          reader,
          _reader,
          _args = arguments;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              options = _args.length > 2 && _args[2] !== undefined ? _args[2] : {};
              this.options = Object.assign({
                // default options
                binary: false,
                trs: false,
                onlyVisible: true,
                maxTextureSize: Infinity,
                animations: [],
                includeCustomExtensions: false
              }, options);
              if (this.options.animations.length > 0) {
                // Only TRS properties, and not matrices, may be targeted by animation.
                this.options.trs = true;
              }
              this.processInput(input);
              _context.next = 6;
              return Promise.all(this.pending);
            case 6:
              writer = this;
              buffers = writer.buffers;
              json = writer.json;
              options = writer.options;
              extensionsUsed = writer.extensionsUsed; // Merge buffers.
              blob = new Blob(buffers, {
                type: 'application/octet-stream'
              }); // Declare extensions.
              extensionsUsedList = Object.keys(extensionsUsed);
              if (extensionsUsedList.length > 0) json.extensionsUsed = extensionsUsedList;

              // Update bytelength of the single buffer.
              if (json.buffers && json.buffers.length > 0) json.buffers[0].byteLength = blob.size;
              if (options.binary === true) {
                // https://github.com/KhronosGroup/glTF/blob/master/specification/2.0/README.md#glb-file-format-specification
                reader = new FileReader();
                reader.readAsArrayBuffer(blob);
                reader.onloadend = function () {
                  // Binary chunk.
                  var binaryChunk = getPaddedArrayBuffer(reader.result);
                  var binaryChunkPrefix = new DataView(new ArrayBuffer(GLB_CHUNK_PREFIX_BYTES));
                  binaryChunkPrefix.setUint32(0, binaryChunk.byteLength, true);
                  binaryChunkPrefix.setUint32(4, GLB_CHUNK_TYPE_BIN, true);

                  // JSON chunk.
                  var jsonChunk = getPaddedArrayBuffer(stringToArrayBuffer(JSON.stringify(json)), 0x20);
                  var jsonChunkPrefix = new DataView(new ArrayBuffer(GLB_CHUNK_PREFIX_BYTES));
                  jsonChunkPrefix.setUint32(0, jsonChunk.byteLength, true);
                  jsonChunkPrefix.setUint32(4, GLB_CHUNK_TYPE_JSON, true);

                  // GLB header.
                  var header = new ArrayBuffer(GLB_HEADER_BYTES);
                  var headerView = new DataView(header);
                  headerView.setUint32(0, GLB_HEADER_MAGIC, true);
                  headerView.setUint32(4, GLB_VERSION, true);
                  var totalByteLength = GLB_HEADER_BYTES + jsonChunkPrefix.byteLength + jsonChunk.byteLength + binaryChunkPrefix.byteLength + binaryChunk.byteLength;
                  headerView.setUint32(8, totalByteLength, true);
                  var glbBlob = new Blob([header, jsonChunkPrefix, jsonChunk, binaryChunkPrefix, binaryChunk], {
                    type: 'application/octet-stream'
                  });
                  var glbReader = new FileReader();
                  glbReader.readAsArrayBuffer(glbBlob);
                  glbReader.onloadend = function () {
                    onDone(glbReader.result);
                  };
                };
              } else {
                if (json.buffers && json.buffers.length > 0) {
                  _reader = new FileReader();
                  _reader.readAsDataURL(blob);
                  _reader.onloadend = function () {
                    var base64data = _reader.result;
                    json.buffers[0].uri = base64data;
                    onDone(json);
                  };
                } else {
                  onDone(json);
                }
              }
            case 16:
            case "end":
              return _context.stop();
          }
        }, _callee, this);
      }));
      function write(_x, _x2) {
        return _write.apply(this, arguments);
      }
      return write;
    }()
    /**
     * Serializes a userData.
     *
     * @param {THREE.Object3D|THREE.Material} object
     * @param {Object} objectDef
     */
  }, {
    key: "serializeUserData",
    value: function serializeUserData(object, objectDef) {
      if (Object.keys(object.userData).length === 0) return;
      var options = this.options;
      var extensionsUsed = this.extensionsUsed;
      try {
        var json = JSON.parse(JSON.stringify(object.userData));
        if (options.includeCustomExtensions && json.gltfExtensions) {
          if (objectDef.extensions === undefined) objectDef.extensions = {};
          for (var extensionName in json.gltfExtensions) {
            objectDef.extensions[extensionName] = json.gltfExtensions[extensionName];
            extensionsUsed[extensionName] = true;
          }
          delete json.gltfExtensions;
        }
        if (Object.keys(json).length > 0) objectDef.extras = json;
      } catch (error) {
        console.warn('THREE.GLTFExporter: userData of \'' + object.name + '\' ' + 'won\'t be serialized because of JSON.stringify error - ' + error.message);
      }
    }

    /**
     * Returns ids for buffer attributes.
     * @param  {Object} object
     * @return {Integer}
     */
  }, {
    key: "getUID",
    value: function getUID(attribute) {
      var isRelativeCopy = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      if (this.uids.has(attribute) === false) {
        var _uids = new Map();
        _uids.set(true, this.uid++);
        _uids.set(false, this.uid++);
        this.uids.set(attribute, _uids);
      }
      var uids = this.uids.get(attribute);
      return uids.get(isRelativeCopy);
    }

    /**
     * Checks if normal attribute values are normalized.
     *
     * @param {BufferAttribute} normal
     * @returns {Boolean}
     */
  }, {
    key: "isNormalizedNormalAttribute",
    value: function isNormalizedNormalAttribute(normal) {
      var cache = this.cache;
      if (cache.attributesNormalized.has(normal)) return false;
      var v = new Vector3();
      for (var i = 0, il = normal.count; i < il; i++) {
        // 0.0005 is from glTF-validator
        if (Math.abs(v.fromBufferAttribute(normal, i).length() - 1.0) > 0.0005) return false;
      }
      return true;
    }

    /**
     * Creates normalized normal buffer attribute.
     *
     * @param {BufferAttribute} normal
     * @returns {BufferAttribute}
     *
     */
  }, {
    key: "createNormalizedNormalAttribute",
    value: function createNormalizedNormalAttribute(normal) {
      var cache = this.cache;
      if (cache.attributesNormalized.has(normal)) return cache.attributesNormalized.get(normal);
      var attribute = normal.clone();
      var v = new Vector3();
      for (var i = 0, il = attribute.count; i < il; i++) {
        v.fromBufferAttribute(attribute, i);
        if (v.x === 0 && v.y === 0 && v.z === 0) {
          // if values can't be normalized set (1, 0, 0)
          v.setX(1.0);
        } else {
          v.normalize();
        }
        attribute.setXYZ(i, v.x, v.y, v.z);
      }
      cache.attributesNormalized.set(normal, attribute);
      return attribute;
    }

    /**
     * Applies a texture transform, if present, to the map definition. Requires
     * the KHR_texture_transform extension.
     *
     * @param {Object} mapDef
     * @param {THREE.Texture} texture
     */
  }, {
    key: "applyTextureTransform",
    value: function applyTextureTransform(mapDef, texture) {
      var didTransform = false;
      var transformDef = {};
      if (texture.offset.x !== 0 || texture.offset.y !== 0) {
        transformDef.offset = texture.offset.toArray();
        didTransform = true;
      }
      if (texture.rotation !== 0) {
        transformDef.rotation = texture.rotation;
        didTransform = true;
      }
      if (texture.repeat.x !== 1 || texture.repeat.y !== 1) {
        transformDef.scale = texture.repeat.toArray();
        didTransform = true;
      }
      if (didTransform) {
        mapDef.extensions = mapDef.extensions || {};
        mapDef.extensions['KHR_texture_transform'] = transformDef;
        this.extensionsUsed['KHR_texture_transform'] = true;
      }
    }
  }, {
    key: "buildMetalRoughTexture",
    value: function buildMetalRoughTexture(metalnessMap, roughnessMap) {
      if (metalnessMap === roughnessMap) return metalnessMap;
      function getEncodingConversion(map) {
        if (map.encoding === sRGBEncoding) {
          return function SRGBToLinear(c) {
            return c < 0.04045 ? c * 0.0773993808 : Math.pow(c * 0.9478672986 + 0.0521327014, 2.4);
          };
        }
        return function LinearToLinear(c) {
          return c;
        };
      }
      console.warn('THREE.GLTFExporter: Merged metalnessMap and roughnessMap textures.');
      var metalness = metalnessMap ? metalnessMap.image : null;
      var roughness = roughnessMap ? roughnessMap.image : null;
      var width = Math.max(metalness ? metalness.width : 0, roughness ? roughness.width : 0);
      var height = Math.max(metalness ? metalness.height : 0, roughness ? roughness.height : 0);
      var canvas = getCanvas();
      canvas.width = width;
      canvas.height = height;
      var context = canvas.getContext('2d');
      context.fillStyle = '#00ffff';
      context.fillRect(0, 0, width, height);
      var composite = context.getImageData(0, 0, width, height);
      if (metalness) {
        context.drawImage(metalness, 0, 0, width, height);
        var convert = getEncodingConversion(metalnessMap);
        var data = context.getImageData(0, 0, width, height).data;
        for (var i = 2; i < data.length; i += 4) {
          composite.data[i] = convert(data[i] / 256) * 256;
        }
      }
      if (roughness) {
        context.drawImage(roughness, 0, 0, width, height);
        var _convert = getEncodingConversion(roughnessMap);
        var _data = context.getImageData(0, 0, width, height).data;
        for (var _i = 1; _i < _data.length; _i += 4) {
          composite.data[_i] = _convert(_data[_i] / 256) * 256;
        }
      }
      context.putImageData(composite, 0, 0);

      //

      var reference = metalnessMap || roughnessMap;
      var texture = reference.clone();
      texture.source = new Source(canvas);
      texture.encoding = LinearEncoding;
      return texture;
    }

    /**
     * Process a buffer to append to the default one.
     * @param  {ArrayBuffer} buffer
     * @return {Integer}
     */
  }, {
    key: "processBuffer",
    value: function processBuffer(buffer) {
      var json = this.json;
      var buffers = this.buffers;
      if (!json.buffers) json.buffers = [{
        byteLength: 0
      }];

      // All buffers are merged before export.
      buffers.push(buffer);
      return 0;
    }

    /**
     * Process and generate a BufferView
     * @param  {BufferAttribute} attribute
     * @param  {number} componentType
     * @param  {number} start
     * @param  {number} count
     * @param  {number} target (Optional) Target usage of the BufferView
     * @return {Object}
     */
  }, {
    key: "processBufferView",
    value: function processBufferView(attribute, componentType, start, count, target) {
      var json = this.json;
      if (!json.bufferViews) json.bufferViews = [];

      // Create a new dataview and dump the attribute's array into it

      var componentSize;
      if (componentType === WEBGL_CONSTANTS.UNSIGNED_BYTE) {
        componentSize = 1;
      } else if (componentType === WEBGL_CONSTANTS.UNSIGNED_SHORT) {
        componentSize = 2;
      } else {
        componentSize = 4;
      }
      var byteLength = getPaddedBufferSize(count * attribute.itemSize * componentSize);
      var dataView = new DataView(new ArrayBuffer(byteLength));
      var offset = 0;
      for (var i = start; i < start + count; i++) {
        for (var a = 0; a < attribute.itemSize; a++) {
          var value = void 0;
          if (attribute.itemSize > 4) {
            // no support for interleaved data for itemSize > 4

            value = attribute.array[i * attribute.itemSize + a];
          } else {
            if (a === 0) value = attribute.getX(i);else if (a === 1) value = attribute.getY(i);else if (a === 2) value = attribute.getZ(i);else if (a === 3) value = attribute.getW(i);
            if (attribute.normalized === true) {
              value = MathUtils.normalize(value, attribute.array);
            }
          }
          if (componentType === WEBGL_CONSTANTS.FLOAT) {
            dataView.setFloat32(offset, value, true);
          } else if (componentType === WEBGL_CONSTANTS.UNSIGNED_INT) {
            dataView.setUint32(offset, value, true);
          } else if (componentType === WEBGL_CONSTANTS.UNSIGNED_SHORT) {
            dataView.setUint16(offset, value, true);
          } else if (componentType === WEBGL_CONSTANTS.UNSIGNED_BYTE) {
            dataView.setUint8(offset, value);
          }
          offset += componentSize;
        }
      }
      var bufferViewDef = {
        buffer: this.processBuffer(dataView.buffer),
        byteOffset: this.byteOffset,
        byteLength: byteLength
      };
      if (target !== undefined) bufferViewDef.target = target;
      if (target === WEBGL_CONSTANTS.ARRAY_BUFFER) {
        // Only define byteStride for vertex attributes.
        bufferViewDef.byteStride = attribute.itemSize * componentSize;
      }
      this.byteOffset += byteLength;
      json.bufferViews.push(bufferViewDef);

      // @TODO Merge bufferViews where possible.
      var output = {
        id: json.bufferViews.length - 1,
        byteLength: 0
      };
      return output;
    }

    /**
     * Process and generate a BufferView from an image Blob.
     * @param {Blob} blob
     * @return {Promise<Integer>}
     */
  }, {
    key: "processBufferViewImage",
    value: function processBufferViewImage(blob) {
      var writer = this;
      var json = writer.json;
      if (!json.bufferViews) json.bufferViews = [];
      return new Promise(function (resolve) {
        var reader = new FileReader();
        reader.readAsArrayBuffer(blob);
        reader.onloadend = function () {
          var buffer = getPaddedArrayBuffer(reader.result);
          var bufferViewDef = {
            buffer: writer.processBuffer(buffer),
            byteOffset: writer.byteOffset,
            byteLength: buffer.byteLength
          };
          writer.byteOffset += buffer.byteLength;
          resolve(json.bufferViews.push(bufferViewDef) - 1);
        };
      });
    }

    /**
     * Process attribute to generate an accessor
     * @param  {BufferAttribute} attribute Attribute to process
     * @param  {THREE.BufferGeometry} geometry (Optional) Geometry used for truncated draw range
     * @param  {Integer} start (Optional)
     * @param  {Integer} count (Optional)
     * @return {Integer|null} Index of the processed accessor on the "accessors" array
     */
  }, {
    key: "processAccessor",
    value: function processAccessor(attribute, geometry, start, count) {
      var json = this.json;
      var types = {
        1: 'SCALAR',
        2: 'VEC2',
        3: 'VEC3',
        4: 'VEC4',
        16: 'MAT4'
      };
      var componentType;

      // Detect the component type of the attribute array (float, uint or ushort)
      if (attribute.array.constructor === Float32Array) {
        componentType = WEBGL_CONSTANTS.FLOAT;
      } else if (attribute.array.constructor === Uint32Array) {
        componentType = WEBGL_CONSTANTS.UNSIGNED_INT;
      } else if (attribute.array.constructor === Uint16Array) {
        componentType = WEBGL_CONSTANTS.UNSIGNED_SHORT;
      } else if (attribute.array.constructor === Uint8Array) {
        componentType = WEBGL_CONSTANTS.UNSIGNED_BYTE;
      } else {
        throw new Error('THREE.GLTFExporter: Unsupported bufferAttribute component type.');
      }
      if (start === undefined) start = 0;
      if (count === undefined) count = attribute.count;

      // Skip creating an accessor if the attribute doesn't have data to export
      if (count === 0) return null;
      var minMax = getMinMax(attribute, start, count);
      var bufferViewTarget;

      // If geometry isn't provided, don't infer the target usage of the bufferView. For
      // animation samplers, target must not be set.
      if (geometry !== undefined) {
        bufferViewTarget = attribute === geometry.index ? WEBGL_CONSTANTS.ELEMENT_ARRAY_BUFFER : WEBGL_CONSTANTS.ARRAY_BUFFER;
      }
      var bufferView = this.processBufferView(attribute, componentType, start, count, bufferViewTarget);
      var accessorDef = {
        bufferView: bufferView.id,
        byteOffset: bufferView.byteOffset,
        componentType: componentType,
        count: count,
        max: minMax.max,
        min: minMax.min,
        type: types[attribute.itemSize]
      };
      if (attribute.normalized === true) accessorDef.normalized = true;
      if (!json.accessors) json.accessors = [];
      return json.accessors.push(accessorDef) - 1;
    }

    /**
     * Process image
     * @param  {Image} image to process
     * @param  {Integer} format of the image (RGBAFormat)
     * @param  {Boolean} flipY before writing out the image
     * @param  {String} mimeType export format
     * @return {Integer}     Index of the processed texture in the "images" array
     */
  }, {
    key: "processImage",
    value: function processImage(image, format, flipY) {
      var mimeType = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'image/png';
      if (image !== null) {
        var writer = this;
        var cache = writer.cache;
        var json = writer.json;
        var options = writer.options;
        var pending = writer.pending;
        if (!cache.images.has(image)) cache.images.set(image, {});
        var cachedImages = cache.images.get(image);
        var key = mimeType + ':flipY/' + flipY.toString();
        if (cachedImages[key] !== undefined) return cachedImages[key];
        if (!json.images) json.images = [];
        var imageDef = {
          mimeType: mimeType
        };
        var canvas = getCanvas();
        canvas.width = Math.min(image.width, options.maxTextureSize);
        canvas.height = Math.min(image.height, options.maxTextureSize);
        var ctx = canvas.getContext('2d');
        if (flipY === true) {
          ctx.translate(0, canvas.height);
          ctx.scale(1, -1);
        }
        if (image.data !== undefined) {
          // THREE.DataTexture

          if (format !== RGBAFormat) {
            console.error('GLTFExporter: Only RGBAFormat is supported.');
          }
          if (image.width > options.maxTextureSize || image.height > options.maxTextureSize) {
            console.warn('GLTFExporter: Image size is bigger than maxTextureSize', image);
          }
          var data = new Uint8ClampedArray(image.height * image.width * 4);
          for (var i = 0; i < data.length; i += 4) {
            data[i + 0] = image.data[i + 0];
            data[i + 1] = image.data[i + 1];
            data[i + 2] = image.data[i + 2];
            data[i + 3] = image.data[i + 3];
          }
          ctx.putImageData(new ImageData(data, image.width, image.height), 0, 0);
        } else {
          ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        }
        if (options.binary === true) {
          pending.push(getToBlobPromise(canvas, mimeType).then(function (blob) {
            return writer.processBufferViewImage(blob);
          }).then(function (bufferViewIndex) {
            imageDef.bufferView = bufferViewIndex;
          }));
        } else {
          if (canvas.toDataURL !== undefined) {
            imageDef.uri = canvas.toDataURL(mimeType);
          } else {
            pending.push(getToBlobPromise(canvas, mimeType).then(function (blob) {
              return new FileReader().readAsDataURL(blob);
            }).then(function (dataURL) {
              imageDef.uri = dataURL;
            }));
          }
        }
        var index = json.images.push(imageDef) - 1;
        cachedImages[key] = index;
        return index;
      } else {
        throw new Error('THREE.GLTFExporter: No valid image data found. Unable to process texture.');
      }
    }

    /**
     * Process sampler
     * @param  {Texture} map Texture to process
     * @return {Integer}     Index of the processed texture in the "samplers" array
     */
  }, {
    key: "processSampler",
    value: function processSampler(map) {
      var json = this.json;
      if (!json.samplers) json.samplers = [];
      var samplerDef = {
        magFilter: THREE_TO_WEBGL[map.magFilter],
        minFilter: THREE_TO_WEBGL[map.minFilter],
        wrapS: THREE_TO_WEBGL[map.wrapS],
        wrapT: THREE_TO_WEBGL[map.wrapT]
      };
      return json.samplers.push(samplerDef) - 1;
    }

    /**
     * Process texture
     * @param  {Texture} map Map to process
     * @return {Integer} Index of the processed texture in the "textures" array
     */
  }, {
    key: "processTexture",
    value: function processTexture(map) {
      var cache = this.cache;
      var json = this.json;
      if (cache.textures.has(map)) return cache.textures.get(map);
      if (!json.textures) json.textures = [];
      var mimeType = map.userData.mimeType;
      if (mimeType === 'image/webp') mimeType = 'image/png';
      var textureDef = {
        sampler: this.processSampler(map),
        source: this.processImage(map.image, map.format, map.flipY, mimeType)
      };
      if (map.name) textureDef.name = map.name;
      this._invokeAll(function (ext) {
        ext.writeTexture && ext.writeTexture(map, textureDef);
      });
      var index = json.textures.push(textureDef) - 1;
      cache.textures.set(map, index);
      return index;
    }

    /**
     * Process material
     * @param  {THREE.Material} material Material to process
     * @return {Integer|null} Index of the processed material in the "materials" array
     */
  }, {
    key: "processMaterial",
    value: function processMaterial(material) {
      var cache = this.cache;
      var json = this.json;
      if (cache.materials.has(material)) return cache.materials.get(material);
      if (material.isShaderMaterial) {
        console.warn('GLTFExporter: THREE.ShaderMaterial not supported.');
        return null;
      }
      if (!json.materials) json.materials = [];

      // @QUESTION Should we avoid including any attribute that has the default value?
      var materialDef = {
        pbrMetallicRoughness: {}
      };
      if (material.isMeshStandardMaterial !== true && material.isMeshBasicMaterial !== true) {
        console.warn('GLTFExporter: Use MeshStandardMaterial or MeshBasicMaterial for best results.');
      }

      // pbrMetallicRoughness.baseColorFactor
      var color = material.color.toArray().concat([material.opacity]);
      if (!equalArray(color, [1, 1, 1, 1])) {
        materialDef.pbrMetallicRoughness.baseColorFactor = color;
      }
      if (material.isMeshStandardMaterial) {
        materialDef.pbrMetallicRoughness.metallicFactor = material.metalness;
        materialDef.pbrMetallicRoughness.roughnessFactor = material.roughness;
      } else {
        materialDef.pbrMetallicRoughness.metallicFactor = 0.5;
        materialDef.pbrMetallicRoughness.roughnessFactor = 0.5;
      }

      // pbrMetallicRoughness.metallicRoughnessTexture
      if (material.metalnessMap || material.roughnessMap) {
        var metalRoughTexture = this.buildMetalRoughTexture(material.metalnessMap, material.roughnessMap);
        var metalRoughMapDef = {
          index: this.processTexture(metalRoughTexture)
        };
        this.applyTextureTransform(metalRoughMapDef, metalRoughTexture);
        materialDef.pbrMetallicRoughness.metallicRoughnessTexture = metalRoughMapDef;
      }

      // pbrMetallicRoughness.baseColorTexture or pbrSpecularGlossiness diffuseTexture
      if (material.map) {
        var baseColorMapDef = {
          index: this.processTexture(material.map)
        };
        this.applyTextureTransform(baseColorMapDef, material.map);
        materialDef.pbrMetallicRoughness.baseColorTexture = baseColorMapDef;
      }
      if (material.emissive) {
        // note: emissive components are limited to stay within the 0 - 1 range to accommodate glTF spec. see #21849 and #22000.
        var emissive = material.emissive.clone().multiplyScalar(material.emissiveIntensity);
        var maxEmissiveComponent = Math.max(emissive.r, emissive.g, emissive.b);
        if (maxEmissiveComponent > 1) {
          emissive.multiplyScalar(1 / maxEmissiveComponent);
          console.warn('THREE.GLTFExporter: Some emissive components exceed 1; emissive has been limited');
        }
        if (maxEmissiveComponent > 0) {
          materialDef.emissiveFactor = emissive.toArray();
        }

        // emissiveTexture
        if (material.emissiveMap) {
          var emissiveMapDef = {
            index: this.processTexture(material.emissiveMap)
          };
          this.applyTextureTransform(emissiveMapDef, material.emissiveMap);
          materialDef.emissiveTexture = emissiveMapDef;
        }
      }

      // normalTexture
      if (material.normalMap) {
        var normalMapDef = {
          index: this.processTexture(material.normalMap)
        };
        if (material.normalScale && material.normalScale.x !== 1) {
          // glTF normal scale is univariate. Ignore `y`, which may be flipped.
          // Context: https://github.com/mrdoob/three.js/issues/11438#issuecomment-507003995
          normalMapDef.scale = material.normalScale.x;
        }
        this.applyTextureTransform(normalMapDef, material.normalMap);
        materialDef.normalTexture = normalMapDef;
      }

      // occlusionTexture
      if (material.aoMap) {
        var occlusionMapDef = {
          index: this.processTexture(material.aoMap),
          texCoord: 1
        };
        if (material.aoMapIntensity !== 1.0) {
          occlusionMapDef.strength = material.aoMapIntensity;
        }
        this.applyTextureTransform(occlusionMapDef, material.aoMap);
        materialDef.occlusionTexture = occlusionMapDef;
      }

      // alphaMode
      if (material.transparent) {
        materialDef.alphaMode = 'BLEND';
      } else {
        if (material.alphaTest > 0.0) {
          materialDef.alphaMode = 'MASK';
          materialDef.alphaCutoff = material.alphaTest;
        }
      }

      // doubleSided
      if (material.side === DoubleSide) materialDef.doubleSided = true;
      if (material.name !== '') materialDef.name = material.name;
      this.serializeUserData(material, materialDef);
      this._invokeAll(function (ext) {
        ext.writeMaterial && ext.writeMaterial(material, materialDef);
      });
      var index = json.materials.push(materialDef) - 1;
      cache.materials.set(material, index);
      return index;
    }

    /**
     * Process mesh
     * @param  {THREE.Mesh} mesh Mesh to process
     * @return {Integer|null} Index of the processed mesh in the "meshes" array
     */
  }, {
    key: "processMesh",
    value: function processMesh(mesh) {
      var cache = this.cache;
      var json = this.json;
      var meshCacheKeyParts = [mesh.geometry.uuid];
      if (Array.isArray(mesh.material)) {
        for (var i = 0, l = mesh.material.length; i < l; i++) {
          meshCacheKeyParts.push(mesh.material[i].uuid);
        }
      } else {
        meshCacheKeyParts.push(mesh.material.uuid);
      }
      var meshCacheKey = meshCacheKeyParts.join(':');
      if (cache.meshes.has(meshCacheKey)) return cache.meshes.get(meshCacheKey);
      var geometry = mesh.geometry;
      var mode;

      // Use the correct mode
      if (mesh.isLineSegments) {
        mode = WEBGL_CONSTANTS.LINES;
      } else if (mesh.isLineLoop) {
        mode = WEBGL_CONSTANTS.LINE_LOOP;
      } else if (mesh.isLine) {
        mode = WEBGL_CONSTANTS.LINE_STRIP;
      } else if (mesh.isPoints) {
        mode = WEBGL_CONSTANTS.POINTS;
      } else {
        mode = mesh.material.wireframe ? WEBGL_CONSTANTS.LINES : WEBGL_CONSTANTS.TRIANGLES;
      }
      var meshDef = {};
      var attributes = {};
      var primitives = [];
      var targets = [];

      // Conversion between attributes names in threejs and gltf spec
      var nameConversion = {
        uv: 'TEXCOORD_0',
        uv2: 'TEXCOORD_1',
        color: 'COLOR_0',
        skinWeight: 'WEIGHTS_0',
        skinIndex: 'JOINTS_0'
      };
      var originalNormal = geometry.getAttribute('normal');
      if (originalNormal !== undefined && !this.isNormalizedNormalAttribute(originalNormal)) {
        console.warn('THREE.GLTFExporter: Creating normalized normal attribute from the non-normalized one.');
        geometry.setAttribute('normal', this.createNormalizedNormalAttribute(originalNormal));
      }

      // @QUESTION Detect if .vertexColors = true?
      // For every attribute create an accessor
      var modifiedAttribute = null;
      for (var attributeName in geometry.attributes) {
        // Ignore morph target attributes, which are exported later.
        if (attributeName.slice(0, 5) === 'morph') continue;
        var attribute = geometry.attributes[attributeName];
        attributeName = nameConversion[attributeName] || attributeName.toUpperCase();

        // Prefix all geometry attributes except the ones specifically
        // listed in the spec; non-spec attributes are considered custom.
        var validVertexAttributes = /^(POSITION|NORMAL|TANGENT|TEXCOORD_\d+|COLOR_\d+|JOINTS_\d+|WEIGHTS_\d+)$/;
        if (!validVertexAttributes.test(attributeName)) attributeName = '_' + attributeName;
        if (cache.attributes.has(this.getUID(attribute))) {
          attributes[attributeName] = cache.attributes.get(this.getUID(attribute));
          continue;
        }

        // JOINTS_0 must be UNSIGNED_BYTE or UNSIGNED_SHORT.
        modifiedAttribute = null;
        var array = attribute.array;
        if (attributeName === 'JOINTS_0' && !(array instanceof Uint16Array) && !(array instanceof Uint8Array)) {
          console.warn('GLTFExporter: Attribute "skinIndex" converted to type UNSIGNED_SHORT.');
          modifiedAttribute = new BufferAttribute(new Uint16Array(array), attribute.itemSize, attribute.normalized);
        }
        var accessor = this.processAccessor(modifiedAttribute || attribute, geometry);
        if (accessor !== null) {
          attributes[attributeName] = accessor;
          cache.attributes.set(this.getUID(attribute), accessor);
        }
      }
      if (originalNormal !== undefined) geometry.setAttribute('normal', originalNormal);

      // Skip if no exportable attributes found
      if (Object.keys(attributes).length === 0) return null;

      // Morph targets
      if (mesh.morphTargetInfluences !== undefined && mesh.morphTargetInfluences.length > 0) {
        var weights = [];
        var targetNames = [];
        var reverseDictionary = {};
        if (mesh.morphTargetDictionary !== undefined) {
          for (var key in mesh.morphTargetDictionary) {
            reverseDictionary[mesh.morphTargetDictionary[key]] = key;
          }
        }
        for (var _i2 = 0; _i2 < mesh.morphTargetInfluences.length; ++_i2) {
          var target = {};
          var warned = false;
          for (var _attributeName in geometry.morphAttributes) {
            // glTF 2.0 morph supports only POSITION/NORMAL/TANGENT.
            // Three.js doesn't support TANGENT yet.

            if (_attributeName !== 'position' && _attributeName !== 'normal') {
              if (!warned) {
                console.warn('GLTFExporter: Only POSITION and NORMAL morph are supported.');
                warned = true;
              }
              continue;
            }
            var _attribute = geometry.morphAttributes[_attributeName][_i2];
            var gltfAttributeName = _attributeName.toUpperCase();

            // Three.js morph attribute has absolute values while the one of glTF has relative values.
            //
            // glTF 2.0 Specification:
            // https://github.com/KhronosGroup/glTF/tree/master/specification/2.0#morph-targets

            var baseAttribute = geometry.attributes[_attributeName];
            if (cache.attributes.has(this.getUID(_attribute, true))) {
              target[gltfAttributeName] = cache.attributes.get(this.getUID(_attribute, true));
              continue;
            }

            // Clones attribute not to override
            var relativeAttribute = _attribute.clone();
            if (!geometry.morphTargetsRelative) {
              for (var j = 0, jl = _attribute.count; j < jl; j++) {
                for (var a = 0; a < _attribute.itemSize; a++) {
                  if (a === 0) relativeAttribute.setX(j, _attribute.getX(j) - baseAttribute.getX(j));
                  if (a === 1) relativeAttribute.setY(j, _attribute.getY(j) - baseAttribute.getY(j));
                  if (a === 2) relativeAttribute.setZ(j, _attribute.getZ(j) - baseAttribute.getZ(j));
                  if (a === 3) relativeAttribute.setW(j, _attribute.getW(j) - baseAttribute.getW(j));
                }
              }
            }
            target[gltfAttributeName] = this.processAccessor(relativeAttribute, geometry);
            cache.attributes.set(this.getUID(baseAttribute, true), target[gltfAttributeName]);
          }
          targets.push(target);
          weights.push(mesh.morphTargetInfluences[_i2]);
          if (mesh.morphTargetDictionary !== undefined) targetNames.push(reverseDictionary[_i2]);
        }
        meshDef.weights = weights;
        if (targetNames.length > 0) {
          meshDef.extras = {};
          meshDef.extras.targetNames = targetNames;
        }
      }
      var isMultiMaterial = Array.isArray(mesh.material);
      if (isMultiMaterial && geometry.groups.length === 0) return null;
      var materials = isMultiMaterial ? mesh.material : [mesh.material];
      var groups = isMultiMaterial ? geometry.groups : [{
        materialIndex: 0,
        start: undefined,
        count: undefined
      }];
      for (var _i3 = 0, il = groups.length; _i3 < il; _i3++) {
        var primitive = {
          mode: mode,
          attributes: attributes
        };
        this.serializeUserData(geometry, primitive);
        if (targets.length > 0) primitive.targets = targets;
        if (geometry.index !== null) {
          var cacheKey = this.getUID(geometry.index);
          if (groups[_i3].start !== undefined || groups[_i3].count !== undefined) {
            cacheKey += ':' + groups[_i3].start + ':' + groups[_i3].count;
          }
          if (cache.attributes.has(cacheKey)) {
            primitive.indices = cache.attributes.get(cacheKey);
          } else {
            primitive.indices = this.processAccessor(geometry.index, geometry, groups[_i3].start, groups[_i3].count);
            cache.attributes.set(cacheKey, primitive.indices);
          }
          if (primitive.indices === null) delete primitive.indices;
        }
        var material = this.processMaterial(materials[groups[_i3].materialIndex]);
        if (material !== null) primitive.material = material;
        primitives.push(primitive);
      }
      meshDef.primitives = primitives;
      if (!json.meshes) json.meshes = [];
      this._invokeAll(function (ext) {
        ext.writeMesh && ext.writeMesh(mesh, meshDef);
      });
      var index = json.meshes.push(meshDef) - 1;
      cache.meshes.set(meshCacheKey, index);
      return index;
    }

    /**
     * Process camera
     * @param  {THREE.Camera} camera Camera to process
     * @return {Integer}      Index of the processed mesh in the "camera" array
     */
  }, {
    key: "processCamera",
    value: function processCamera(camera) {
      var json = this.json;
      if (!json.cameras) json.cameras = [];
      var isOrtho = camera.isOrthographicCamera;
      var cameraDef = {
        type: isOrtho ? 'orthographic' : 'perspective'
      };
      if (isOrtho) {
        cameraDef.orthographic = {
          xmag: camera.right * 2,
          ymag: camera.top * 2,
          zfar: camera.far <= 0 ? 0.001 : camera.far,
          znear: camera.near < 0 ? 0 : camera.near
        };
      } else {
        cameraDef.perspective = {
          aspectRatio: camera.aspect,
          yfov: MathUtils.degToRad(camera.fov),
          zfar: camera.far <= 0 ? 0.001 : camera.far,
          znear: camera.near < 0 ? 0 : camera.near
        };
      }

      // Question: Is saving "type" as name intentional?
      if (camera.name !== '') cameraDef.name = camera.type;
      return json.cameras.push(cameraDef) - 1;
    }

    /**
     * Creates glTF animation entry from AnimationClip object.
     *
     * Status:
     * - Only properties listed in PATH_PROPERTIES may be animated.
     *
     * @param {THREE.AnimationClip} clip
     * @param {THREE.Object3D} root
     * @return {number|null}
     */
  }, {
    key: "processAnimation",
    value: function processAnimation(clip, root) {
      var json = this.json;
      var nodeMap = this.nodeMap;
      if (!json.animations) json.animations = [];
      clip = GLTFExporter.Utils.mergeMorphTargetTracks(clip.clone(), root);
      var tracks = clip.tracks;
      var channels = [];
      var samplers = [];
      for (var i = 0; i < tracks.length; ++i) {
        var track = tracks[i];
        var trackBinding = PropertyBinding.parseTrackName(track.name);
        var trackNode = PropertyBinding.findNode(root, trackBinding.nodeName);
        var trackProperty = PATH_PROPERTIES[trackBinding.propertyName];
        if (trackBinding.objectName === 'bones') {
          if (trackNode.isSkinnedMesh === true) {
            trackNode = trackNode.skeleton.getBoneByName(trackBinding.objectIndex);
          } else {
            trackNode = undefined;
          }
        }
        if (!trackNode || !trackProperty) {
          console.warn('THREE.GLTFExporter: Could not export animation track "%s".', track.name);
          return null;
        }
        var inputItemSize = 1;
        var outputItemSize = track.values.length / track.times.length;
        if (trackProperty === PATH_PROPERTIES.morphTargetInfluences) {
          outputItemSize /= trackNode.morphTargetInfluences.length;
        }
        var interpolation = void 0;

        // @TODO export CubicInterpolant(InterpolateSmooth) as CUBICSPLINE

        // Detecting glTF cubic spline interpolant by checking factory method's special property
        // GLTFCubicSplineInterpolant is a custom interpolant and track doesn't return
        // valid value from .getInterpolation().
        if (track.createInterpolant.isInterpolantFactoryMethodGLTFCubicSpline === true) {
          interpolation = 'CUBICSPLINE';

          // itemSize of CUBICSPLINE keyframe is 9
          // (VEC3 * 3: inTangent, splineVertex, and outTangent)
          // but needs to be stored as VEC3 so dividing by 3 here.
          outputItemSize /= 3;
        } else if (track.getInterpolation() === InterpolateDiscrete) {
          interpolation = 'STEP';
        } else {
          interpolation = 'LINEAR';
        }
        samplers.push({
          input: this.processAccessor(new BufferAttribute(track.times, inputItemSize)),
          output: this.processAccessor(new BufferAttribute(track.values, outputItemSize)),
          interpolation: interpolation
        });
        channels.push({
          sampler: samplers.length - 1,
          target: {
            node: nodeMap.get(trackNode),
            path: trackProperty
          }
        });
      }
      json.animations.push({
        name: clip.name || 'clip_' + json.animations.length,
        samplers: samplers,
        channels: channels
      });
      return json.animations.length - 1;
    }

    /**
     * @param {THREE.Object3D} object
     * @return {number|null}
     */
  }, {
    key: "processSkin",
    value: function processSkin(object) {
      var json = this.json;
      var nodeMap = this.nodeMap;
      var node = json.nodes[nodeMap.get(object)];
      var skeleton = object.skeleton;
      if (skeleton === undefined) return null;
      var rootJoint = object.skeleton.bones[0];
      if (rootJoint === undefined) return null;
      var joints = [];
      var inverseBindMatrices = new Float32Array(skeleton.bones.length * 16);
      var temporaryBoneInverse = new Matrix4();
      for (var i = 0; i < skeleton.bones.length; ++i) {
        joints.push(nodeMap.get(skeleton.bones[i]));
        temporaryBoneInverse.copy(skeleton.boneInverses[i]);
        temporaryBoneInverse.multiply(object.bindMatrix).toArray(inverseBindMatrices, i * 16);
      }
      if (json.skins === undefined) json.skins = [];
      json.skins.push({
        inverseBindMatrices: this.processAccessor(new BufferAttribute(inverseBindMatrices, 16)),
        joints: joints,
        skeleton: nodeMap.get(rootJoint)
      });
      var skinIndex = node.skin = json.skins.length - 1;
      return skinIndex;
    }

    /**
     * Process Object3D node
     * @param  {THREE.Object3D} node Object3D to processNode
     * @return {Integer} Index of the node in the nodes list
     */
  }, {
    key: "processNode",
    value: function processNode(object) {
      var json = this.json;
      var options = this.options;
      var nodeMap = this.nodeMap;
      if (!json.nodes) json.nodes = [];
      var nodeDef = {};
      if (options.trs) {
        var rotation = object.quaternion.toArray();
        var position = object.position.toArray();
        var scale = object.scale.toArray();
        if (!equalArray(rotation, [0, 0, 0, 1])) {
          nodeDef.rotation = rotation;
        }
        if (!equalArray(position, [0, 0, 0])) {
          nodeDef.translation = position;
        }
        if (!equalArray(scale, [1, 1, 1])) {
          nodeDef.scale = scale;
        }
      } else {
        if (object.matrixAutoUpdate) {
          object.updateMatrix();
        }
        if (isIdentityMatrix(object.matrix) === false) {
          nodeDef.matrix = object.matrix.elements;
        }
      }

      // We don't export empty strings name because it represents no-name in Three.js.
      if (object.name !== '') nodeDef.name = String(object.name);
      this.serializeUserData(object, nodeDef);
      if (object.isMesh || object.isLine || object.isPoints) {
        var meshIndex = this.processMesh(object);
        if (meshIndex !== null) nodeDef.mesh = meshIndex;
      } else if (object.isCamera) {
        nodeDef.camera = this.processCamera(object);
      }
      if (object.isSkinnedMesh) this.skins.push(object);
      if (object.children.length > 0) {
        var children = [];
        for (var i = 0, l = object.children.length; i < l; i++) {
          var child = object.children[i];
          if (child.visible || options.onlyVisible === false) {
            var _nodeIndex = this.processNode(child);
            if (_nodeIndex !== null) children.push(_nodeIndex);
          }
        }
        if (children.length > 0) nodeDef.children = children;
      }
      this._invokeAll(function (ext) {
        ext.writeNode && ext.writeNode(object, nodeDef);
      });
      var nodeIndex = json.nodes.push(nodeDef) - 1;
      nodeMap.set(object, nodeIndex);
      return nodeIndex;
    }

    /**
     * Process Scene
     * @param  {Scene} node Scene to process
     */
  }, {
    key: "processScene",
    value: function processScene(scene) {
      var json = this.json;
      var options = this.options;
      if (!json.scenes) {
        json.scenes = [];
        json.scene = 0;
      }
      var sceneDef = {};
      if (scene.name !== '') sceneDef.name = scene.name;
      json.scenes.push(sceneDef);
      var nodes = [];
      for (var i = 0, l = scene.children.length; i < l; i++) {
        var child = scene.children[i];
        if (child.visible || options.onlyVisible === false) {
          var nodeIndex = this.processNode(child);
          if (nodeIndex !== null) nodes.push(nodeIndex);
        }
      }
      if (nodes.length > 0) sceneDef.nodes = nodes;
      this.serializeUserData(scene, sceneDef);
    }

    /**
     * Creates a Scene to hold a list of objects and parse it
     * @param  {Array} objects List of objects to process
     */
  }, {
    key: "processObjects",
    value: function processObjects(objects) {
      var scene = new Scene();
      scene.name = 'AuxScene';
      for (var i = 0; i < objects.length; i++) {
        // We push directly to children instead of calling `add` to prevent
        // modify the .parent and break its original scene and hierarchy
        scene.children.push(objects[i]);
      }
      this.processScene(scene);
    }

    /**
     * @param {THREE.Object3D|Array<THREE.Object3D>} input
     */
  }, {
    key: "processInput",
    value: function processInput(input) {
      var options = this.options;
      input = input instanceof Array ? input : [input];
      this._invokeAll(function (ext) {
        ext.beforeParse && ext.beforeParse(input);
      });
      var objectsWithoutScene = [];
      for (var i = 0; i < input.length; i++) {
        if (input[i] instanceof Scene) {
          this.processScene(input[i]);
        } else {
          objectsWithoutScene.push(input[i]);
        }
      }
      if (objectsWithoutScene.length > 0) this.processObjects(objectsWithoutScene);
      for (var _i4 = 0; _i4 < this.skins.length; ++_i4) {
        this.processSkin(this.skins[_i4]);
      }
      for (var _i5 = 0; _i5 < options.animations.length; ++_i5) {
        this.processAnimation(options.animations[_i5], input[0]);
      }
      this._invokeAll(function (ext) {
        ext.afterParse && ext.afterParse(input);
      });
    }
  }, {
    key: "_invokeAll",
    value: function _invokeAll(func) {
      for (var i = 0, il = this.plugins.length; i < il; i++) {
        func(this.plugins[i]);
      }
    }
  }]);
  return GLTFWriter;
}();
/**
 * Punctual Lights Extension
 *
 * Specification: https://github.com/KhronosGroup/glTF/tree/master/extensions/2.0/Khronos/KHR_lights_punctual
 */
var GLTFLightExtension = /*#__PURE__*/function () {
  function GLTFLightExtension(writer) {
    _classCallCheck(this, GLTFLightExtension);
    this.writer = writer;
    this.name = 'KHR_lights_punctual';
  }
  _createClass(GLTFLightExtension, [{
    key: "writeNode",
    value: function writeNode(light, nodeDef) {
      if (!light.isLight) return;
      if (!light.isDirectionalLight && !light.isPointLight && !light.isSpotLight) {
        console.warn('THREE.GLTFExporter: Only directional, point, and spot lights are supported.', light);
        return;
      }
      var writer = this.writer;
      var json = writer.json;
      var extensionsUsed = writer.extensionsUsed;
      var lightDef = {};
      if (light.name) lightDef.name = light.name;
      lightDef.color = light.color.toArray();
      lightDef.intensity = light.intensity;
      if (light.isDirectionalLight) {
        lightDef.type = 'directional';
      } else if (light.isPointLight) {
        lightDef.type = 'point';
        if (light.distance > 0) lightDef.range = light.distance;
      } else if (light.isSpotLight) {
        lightDef.type = 'spot';
        if (light.distance > 0) lightDef.range = light.distance;
        lightDef.spot = {};
        lightDef.spot.innerConeAngle = (light.penumbra - 1.0) * light.angle * -1.0;
        lightDef.spot.outerConeAngle = light.angle;
      }
      if (light.decay !== undefined && light.decay !== 2) {
        console.warn('THREE.GLTFExporter: Light decay may be lost. glTF is physically-based, ' + 'and expects light.decay=2.');
      }
      if (light.target && (light.target.parent !== light || light.target.position.x !== 0 || light.target.position.y !== 0 || light.target.position.z !== -1)) {
        console.warn('THREE.GLTFExporter: Light direction may be lost. For best results, ' + 'make light.target a child of the light with position 0,0,-1.');
      }
      if (!extensionsUsed[this.name]) {
        json.extensions = json.extensions || {};
        json.extensions[this.name] = {
          lights: []
        };
        extensionsUsed[this.name] = true;
      }
      var lights = json.extensions[this.name].lights;
      lights.push(lightDef);
      nodeDef.extensions = nodeDef.extensions || {};
      nodeDef.extensions[this.name] = {
        light: lights.length - 1
      };
    }
  }]);
  return GLTFLightExtension;
}();
/**
 * Unlit Materials Extension
 *
 * Specification: https://github.com/KhronosGroup/glTF/tree/master/extensions/2.0/Khronos/KHR_materials_unlit
 */
var GLTFMaterialsUnlitExtension = /*#__PURE__*/function () {
  function GLTFMaterialsUnlitExtension(writer) {
    _classCallCheck(this, GLTFMaterialsUnlitExtension);
    this.writer = writer;
    this.name = 'KHR_materials_unlit';
  }
  _createClass(GLTFMaterialsUnlitExtension, [{
    key: "writeMaterial",
    value: function writeMaterial(material, materialDef) {
      if (!material.isMeshBasicMaterial) return;
      var writer = this.writer;
      var extensionsUsed = writer.extensionsUsed;
      materialDef.extensions = materialDef.extensions || {};
      materialDef.extensions[this.name] = {};
      extensionsUsed[this.name] = true;
      materialDef.pbrMetallicRoughness.metallicFactor = 0.0;
      materialDef.pbrMetallicRoughness.roughnessFactor = 0.9;
    }
  }]);
  return GLTFMaterialsUnlitExtension;
}();
/**
 * Clearcoat Materials Extension
 *
 * Specification: https://github.com/KhronosGroup/glTF/tree/master/extensions/2.0/Khronos/KHR_materials_clearcoat
 */
var GLTFMaterialsClearcoatExtension = /*#__PURE__*/function () {
  function GLTFMaterialsClearcoatExtension(writer) {
    _classCallCheck(this, GLTFMaterialsClearcoatExtension);
    this.writer = writer;
    this.name = 'KHR_materials_clearcoat';
  }
  _createClass(GLTFMaterialsClearcoatExtension, [{
    key: "writeMaterial",
    value: function writeMaterial(material, materialDef) {
      if (!material.isMeshPhysicalMaterial) return;
      var writer = this.writer;
      var extensionsUsed = writer.extensionsUsed;
      var extensionDef = {};
      extensionDef.clearcoatFactor = material.clearcoat;
      if (material.clearcoatMap) {
        var clearcoatMapDef = {
          index: writer.processTexture(material.clearcoatMap)
        };
        writer.applyTextureTransform(clearcoatMapDef, material.clearcoatMap);
        extensionDef.clearcoatTexture = clearcoatMapDef;
      }
      extensionDef.clearcoatRoughnessFactor = material.clearcoatRoughness;
      if (material.clearcoatRoughnessMap) {
        var clearcoatRoughnessMapDef = {
          index: writer.processTexture(material.clearcoatRoughnessMap)
        };
        writer.applyTextureTransform(clearcoatRoughnessMapDef, material.clearcoatRoughnessMap);
        extensionDef.clearcoatRoughnessTexture = clearcoatRoughnessMapDef;
      }
      if (material.clearcoatNormalMap) {
        var clearcoatNormalMapDef = {
          index: writer.processTexture(material.clearcoatNormalMap)
        };
        writer.applyTextureTransform(clearcoatNormalMapDef, material.clearcoatNormalMap);
        extensionDef.clearcoatNormalTexture = clearcoatNormalMapDef;
      }
      materialDef.extensions = materialDef.extensions || {};
      materialDef.extensions[this.name] = extensionDef;
      extensionsUsed[this.name] = true;
    }
  }]);
  return GLTFMaterialsClearcoatExtension;
}();
/**
 * Iridescence Materials Extension
 *
 * Specification: https://github.com/KhronosGroup/glTF/tree/master/extensions/2.0/Khronos/KHR_materials_iridescence
 */
var GLTFMaterialsIridescenceExtension = /*#__PURE__*/function () {
  function GLTFMaterialsIridescenceExtension(writer) {
    _classCallCheck(this, GLTFMaterialsIridescenceExtension);
    this.writer = writer;
    this.name = 'KHR_materials_iridescence';
  }
  _createClass(GLTFMaterialsIridescenceExtension, [{
    key: "writeMaterial",
    value: function writeMaterial(material, materialDef) {
      if (!material.isMeshPhysicalMaterial) return;
      var writer = this.writer;
      var extensionsUsed = writer.extensionsUsed;
      var extensionDef = {};
      extensionDef.iridescenceFactor = material.iridescence;
      if (material.iridescenceMap) {
        var iridescenceMapDef = {
          index: writer.processTexture(material.iridescenceMap)
        };
        writer.applyTextureTransform(iridescenceMapDef, material.iridescenceMap);
        extensionDef.iridescenceTexture = iridescenceMapDef;
      }
      extensionDef.iridescenceIor = material.iridescenceIOR;
      extensionDef.iridescenceThicknessMinimum = material.iridescenceThicknessRange[0];
      extensionDef.iridescenceThicknessMaximum = material.iridescenceThicknessRange[1];
      if (material.iridescenceThicknessMap) {
        var iridescenceThicknessMapDef = {
          index: writer.processTexture(material.iridescenceThicknessMap)
        };
        writer.applyTextureTransform(iridescenceThicknessMapDef, material.iridescenceThicknessMap);
        extensionDef.iridescenceThicknessTexture = iridescenceThicknessMapDef;
      }
      materialDef.extensions = materialDef.extensions || {};
      materialDef.extensions[this.name] = extensionDef;
      extensionsUsed[this.name] = true;
    }
  }]);
  return GLTFMaterialsIridescenceExtension;
}();
/**
 * Transmission Materials Extension
 *
 * Specification: https://github.com/KhronosGroup/glTF/tree/master/extensions/2.0/Khronos/KHR_materials_transmission
 */
var GLTFMaterialsTransmissionExtension = /*#__PURE__*/function () {
  function GLTFMaterialsTransmissionExtension(writer) {
    _classCallCheck(this, GLTFMaterialsTransmissionExtension);
    this.writer = writer;
    this.name = 'KHR_materials_transmission';
  }
  _createClass(GLTFMaterialsTransmissionExtension, [{
    key: "writeMaterial",
    value: function writeMaterial(material, materialDef) {
      if (!material.isMeshPhysicalMaterial || material.transmission === 0) return;
      var writer = this.writer;
      var extensionsUsed = writer.extensionsUsed;
      var extensionDef = {};
      extensionDef.transmissionFactor = material.transmission;
      if (material.transmissionMap) {
        var transmissionMapDef = {
          index: writer.processTexture(material.transmissionMap)
        };
        writer.applyTextureTransform(transmissionMapDef, material.transmissionMap);
        extensionDef.transmissionTexture = transmissionMapDef;
      }
      materialDef.extensions = materialDef.extensions || {};
      materialDef.extensions[this.name] = extensionDef;
      extensionsUsed[this.name] = true;
    }
  }]);
  return GLTFMaterialsTransmissionExtension;
}();
/**
 * Materials Volume Extension
 *
 * Specification: https://github.com/KhronosGroup/glTF/tree/master/extensions/2.0/Khronos/KHR_materials_volume
 */
var GLTFMaterialsVolumeExtension = /*#__PURE__*/function () {
  function GLTFMaterialsVolumeExtension(writer) {
    _classCallCheck(this, GLTFMaterialsVolumeExtension);
    this.writer = writer;
    this.name = 'KHR_materials_volume';
  }
  _createClass(GLTFMaterialsVolumeExtension, [{
    key: "writeMaterial",
    value: function writeMaterial(material, materialDef) {
      if (!material.isMeshPhysicalMaterial || material.transmission === 0) return;
      var writer = this.writer;
      var extensionsUsed = writer.extensionsUsed;
      var extensionDef = {};
      extensionDef.thicknessFactor = material.thickness;
      if (material.thicknessMap) {
        var thicknessMapDef = {
          index: writer.processTexture(material.thicknessMap)
        };
        writer.applyTextureTransform(thicknessMapDef, material.thicknessMap);
        extensionDef.thicknessTexture = thicknessMapDef;
      }
      extensionDef.attenuationDistance = material.attenuationDistance;
      extensionDef.attenuationColor = material.attenuationColor.toArray();
      materialDef.extensions = materialDef.extensions || {};
      materialDef.extensions[this.name] = extensionDef;
      extensionsUsed[this.name] = true;
    }
  }]);
  return GLTFMaterialsVolumeExtension;
}();
/**
 * Static utility functions
 */
GLTFExporter.Utils = {
  insertKeyframe: function insertKeyframe(track, time) {
    var tolerance = 0.001; // 1ms
    var valueSize = track.getValueSize();
    var times = new track.TimeBufferType(track.times.length + 1);
    var values = new track.ValueBufferType(track.values.length + valueSize);
    var interpolant = track.createInterpolant(new track.ValueBufferType(valueSize));
    var index;
    if (track.times.length === 0) {
      times[0] = time;
      for (var i = 0; i < valueSize; i++) {
        values[i] = 0;
      }
      index = 0;
    } else if (time < track.times[0]) {
      if (Math.abs(track.times[0] - time) < tolerance) return 0;
      times[0] = time;
      times.set(track.times, 1);
      values.set(interpolant.evaluate(time), 0);
      values.set(track.values, valueSize);
      index = 0;
    } else if (time > track.times[track.times.length - 1]) {
      if (Math.abs(track.times[track.times.length - 1] - time) < tolerance) {
        return track.times.length - 1;
      }
      times[times.length - 1] = time;
      times.set(track.times, 0);
      values.set(track.values, 0);
      values.set(interpolant.evaluate(time), track.values.length);
      index = times.length - 1;
    } else {
      for (var _i6 = 0; _i6 < track.times.length; _i6++) {
        if (Math.abs(track.times[_i6] - time) < tolerance) return _i6;
        if (track.times[_i6] < time && track.times[_i6 + 1] > time) {
          times.set(track.times.slice(0, _i6 + 1), 0);
          times[_i6 + 1] = time;
          times.set(track.times.slice(_i6 + 1), _i6 + 2);
          values.set(track.values.slice(0, (_i6 + 1) * valueSize), 0);
          values.set(interpolant.evaluate(time), (_i6 + 1) * valueSize);
          values.set(track.values.slice((_i6 + 1) * valueSize), (_i6 + 2) * valueSize);
          index = _i6 + 1;
          break;
        }
      }
    }
    track.times = times;
    track.values = values;
    return index;
  },
  mergeMorphTargetTracks: function mergeMorphTargetTracks(clip, root) {
    var tracks = [];
    var mergedTracks = {};
    var sourceTracks = clip.tracks;
    for (var i = 0; i < sourceTracks.length; ++i) {
      var sourceTrack = sourceTracks[i];
      var sourceTrackBinding = PropertyBinding.parseTrackName(sourceTrack.name);
      var sourceTrackNode = PropertyBinding.findNode(root, sourceTrackBinding.nodeName);
      if (sourceTrackBinding.propertyName !== 'morphTargetInfluences' || sourceTrackBinding.propertyIndex === undefined) {
        // Tracks that don't affect morph targets, or that affect all morph targets together, can be left as-is.
        tracks.push(sourceTrack);
        continue;
      }
      if (sourceTrack.createInterpolant !== sourceTrack.InterpolantFactoryMethodDiscrete && sourceTrack.createInterpolant !== sourceTrack.InterpolantFactoryMethodLinear) {
        if (sourceTrack.createInterpolant.isInterpolantFactoryMethodGLTFCubicSpline) {
          // This should never happen, because glTF morph target animations
          // affect all targets already.
          throw new Error('THREE.GLTFExporter: Cannot merge tracks with glTF CUBICSPLINE interpolation.');
        }
        console.warn('THREE.GLTFExporter: Morph target interpolation mode not yet supported. Using LINEAR instead.');
        sourceTrack = sourceTrack.clone();
        sourceTrack.setInterpolation(InterpolateLinear);
      }
      var targetCount = sourceTrackNode.morphTargetInfluences.length;
      var targetIndex = sourceTrackNode.morphTargetDictionary[sourceTrackBinding.propertyIndex];
      if (targetIndex === undefined) {
        throw new Error('THREE.GLTFExporter: Morph target name not found: ' + sourceTrackBinding.propertyIndex);
      }
      var mergedTrack = void 0;

      // If this is the first time we've seen this object, create a new
      // track to store merged keyframe data for each morph target.
      if (mergedTracks[sourceTrackNode.uuid] === undefined) {
        mergedTrack = sourceTrack.clone();
        var values = new mergedTrack.ValueBufferType(targetCount * mergedTrack.times.length);
        for (var j = 0; j < mergedTrack.times.length; j++) {
          values[j * targetCount + targetIndex] = mergedTrack.values[j];
        }

        // We need to take into consideration the intended target node
        // of our original un-merged morphTarget animation.
        mergedTrack.name = (sourceTrackBinding.nodeName || '') + '.morphTargetInfluences';
        mergedTrack.values = values;
        mergedTracks[sourceTrackNode.uuid] = mergedTrack;
        tracks.push(mergedTrack);
        continue;
      }
      var sourceInterpolant = sourceTrack.createInterpolant(new sourceTrack.ValueBufferType(1));
      mergedTrack = mergedTracks[sourceTrackNode.uuid];

      // For every existing keyframe of the merged track, write a (possibly
      // interpolated) value from the source track.
      for (var _j = 0; _j < mergedTrack.times.length; _j++) {
        mergedTrack.values[_j * targetCount + targetIndex] = sourceInterpolant.evaluate(mergedTrack.times[_j]);
      }

      // For every existing keyframe of the source track, write a (possibly
      // new) keyframe to the merged track. Values from the previous loop may
      // be written again, but keyframes are de-duplicated.
      for (var _j2 = 0; _j2 < sourceTrack.times.length; _j2++) {
        var keyframeIndex = this.insertKeyframe(mergedTrack, sourceTrack.times[_j2]);
        mergedTrack.values[keyframeIndex * targetCount + targetIndex] = sourceTrack.values[_j2];
      }
    }
    clip.tracks = tracks;
    return clip;
  }
};


/***/ })

}]);
//# sourceMappingURL=js_libs_GLTFExporter_js.js.map