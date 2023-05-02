"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["js_libs_PLYLoader_js"],{

/***/ "./js/libs/PLYLoader.js":
/*!******************************!*\
  !*** ./js/libs/PLYLoader.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "PLYLoader": () => (/* binding */ PLYLoader)
/* harmony export */ });
/* harmony import */ var _js_three_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../js/three.js */ "../js/three.js");
/* harmony import */ var _js_three_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_js_three_js__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); Object.defineProperty(subClass, "prototype", { writable: false }); if (superClass) _setPrototypeOf(subClass, superClass); }
function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }
function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }
function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }


/**
 * Description: A THREE loader for PLY ASCII files (known as the Polygon
 * File Format or the Stanford Triangle Format).
 *
 * Limitations: ASCII decoding assumes file is UTF-8.
 *
 * Usage:
 *	const loader = new PLYLoader();
 *	loader.load('./models/ply/ascii/dolphins.ply', function (geometry) {
 *
 *		scene.add( new THREE.Mesh( geometry ) );
 *
 *	} );
 *
 * If the PLY file uses non standard property names, they can be mapped while
 * loading. For example, the following maps the properties
 * “diffuse_(red|green|blue)” in the file to standard color names.
 *
 * loader.setPropertyNameMapping( {
 *	diffuse_red: 'red',
 *	diffuse_green: 'green',
 *	diffuse_blue: 'blue'
 * } );
 *
 * Custom properties outside of the defaults for position, uv, normal
 * and color attributes can be added using the setCustomPropertyMapping method.
 * For example, the following maps the element properties “custom_property_a”
 * and “custom_property_b” to an attribute “customAttribute” with an item size of 2.
 * Attribute item sizes are set from the number of element properties in the property array.
 *
 * loader.setCustomPropertyMapping( {
 *	customAttribute: ['custom_property_a', 'custom_property_b'],
 * } );
 *
 */

var _color = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Color();
var PLYLoader = /*#__PURE__*/function (_Loader) {
  _inherits(PLYLoader, _Loader);
  var _super = _createSuper(PLYLoader);
  function PLYLoader(manager) {
    var _this;
    _classCallCheck(this, PLYLoader);
    _this = _super.call(this, manager);
    _this.propertyNameMapping = {};
    _this.customPropertyMapping = {};
    return _this;
  }
  _createClass(PLYLoader, [{
    key: "load",
    value: function load(url, onLoad, onProgress, onError) {
      var scope = this;
      var loader = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.FileLoader(this.manager);
      loader.setPath(this.path);
      loader.setResponseType('arraybuffer');
      loader.setRequestHeader(this.requestHeader);
      loader.setWithCredentials(this.withCredentials);
      loader.load(url, function (text) {
        try {
          onLoad(scope.parse(text));
        } catch (e) {
          if (onError) {
            onError(e);
          } else {
            console.error(e);
          }
          scope.manager.itemError(url);
        }
      }, onProgress, onError);
    }
  }, {
    key: "setPropertyNameMapping",
    value: function setPropertyNameMapping(mapping) {
      this.propertyNameMapping = mapping;
    }
  }, {
    key: "setCustomPropertyNameMapping",
    value: function setCustomPropertyNameMapping(mapping) {
      this.customPropertyMapping = mapping;
    }
  }, {
    key: "parse",
    value: function parse(data) {
      function parseHeader(data) {
        var patternHeader = /^ply([\s\S]*)end_header(\r\n|\r|\n)/;
        var headerText = '';
        var headerLength = 0;
        var result = patternHeader.exec(data);
        if (result !== null) {
          headerText = result[1];
          headerLength = new Blob([result[0]]).size;
        }
        var header = {
          comments: [],
          elements: [],
          headerLength: headerLength,
          objInfo: ''
        };
        var lines = headerText.split(/\r\n|\r|\n/);
        var currentElement;
        function make_ply_element_property(propertValues, propertyNameMapping) {
          var property = {
            type: propertValues[0]
          };
          if (property.type === 'list') {
            property.name = propertValues[3];
            property.countType = propertValues[1];
            property.itemType = propertValues[2];
          } else {
            property.name = propertValues[1];
          }
          if (property.name in propertyNameMapping) {
            property.name = propertyNameMapping[property.name];
          }
          return property;
        }
        for (var i = 0; i < lines.length; i++) {
          var line = lines[i];
          line = line.trim();
          if (line === '') continue;
          var lineValues = line.split(/\s+/);
          var lineType = lineValues.shift();
          line = lineValues.join(' ');
          switch (lineType) {
            case 'format':
              header.format = lineValues[0];
              header.version = lineValues[1];
              break;
            case 'comment':
              header.comments.push(line);
              break;
            case 'element':
              if (currentElement !== undefined) {
                header.elements.push(currentElement);
              }
              currentElement = {};
              currentElement.name = lineValues[0];
              currentElement.count = parseInt(lineValues[1]);
              currentElement.properties = [];
              break;
            case 'property':
              currentElement.properties.push(make_ply_element_property(lineValues, scope.propertyNameMapping));
              break;
            case 'obj_info':
              header.objInfo = line;
              break;
            default:
              console.log('unhandled', lineType, lineValues);
          }
        }
        if (currentElement !== undefined) {
          header.elements.push(currentElement);
        }
        return header;
      }
      function parseASCIINumber(n, type) {
        switch (type) {
          case 'char':
          case 'uchar':
          case 'short':
          case 'ushort':
          case 'int':
          case 'uint':
          case 'int8':
          case 'uint8':
          case 'int16':
          case 'uint16':
          case 'int32':
          case 'uint32':
            return parseInt(n);
          case 'float':
          case 'double':
          case 'float32':
          case 'float64':
            return parseFloat(n);
        }
      }
      function parseASCIIElement(properties, line) {
        var values = line.split(/\s+/);
        var element = {};
        for (var i = 0; i < properties.length; i++) {
          if (properties[i].type === 'list') {
            var list = [];
            var n = parseASCIINumber(values.shift(), properties[i].countType);
            for (var j = 0; j < n; j++) {
              list.push(parseASCIINumber(values.shift(), properties[i].itemType));
            }
            element[properties[i].name] = list;
          } else {
            element[properties[i].name] = parseASCIINumber(values.shift(), properties[i].type);
          }
        }
        return element;
      }
      function createBuffer() {
        var buffer = {
          indices: [],
          vertices: [],
          normals: [],
          uvs: [],
          faceVertexUvs: [],
          colors: []
        };
        for (var _i = 0, _Object$keys = Object.keys(scope.customPropertyMapping); _i < _Object$keys.length; _i++) {
          var customProperty = _Object$keys[_i];
          buffer[customProperty] = [];
        }
        return buffer;
      }
      function parseASCII(data, header) {
        // PLY ascii format specification, as per http://en.wikipedia.org/wiki/PLY_(file_format)

        var buffer = createBuffer();
        var result;
        var patternBody = /end_header\s([\s\S]*)$/;
        var body = '';
        if ((result = patternBody.exec(data)) !== null) {
          body = result[1];
        }
        var lines = body.split(/\r\n|\r|\n/);
        var currentElement = 0;
        var currentElementCount = 0;
        for (var i = 0; i < lines.length; i++) {
          var line = lines[i];
          line = line.trim();
          if (line === '') {
            continue;
          }
          if (currentElementCount >= header.elements[currentElement].count) {
            currentElement++;
            currentElementCount = 0;
          }
          var element = parseASCIIElement(header.elements[currentElement].properties, line);
          handleElement(buffer, header.elements[currentElement].name, element);
          currentElementCount++;
        }
        return postProcess(buffer);
      }
      function postProcess(buffer) {
        var geometry = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.BufferGeometry();

        // mandatory buffer data

        if (buffer.indices.length > 0) {
          geometry.setIndex(buffer.indices);
        }
        geometry.setAttribute('position', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(buffer.vertices, 3));

        // optional buffer data

        if (buffer.normals.length > 0) {
          geometry.setAttribute('normal', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(buffer.normals, 3));
        }
        if (buffer.uvs.length > 0) {
          geometry.setAttribute('uv', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(buffer.uvs, 2));
        }
        if (buffer.colors.length > 0) {
          geometry.setAttribute('color', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(buffer.colors, 3));
        }
        if (buffer.faceVertexUvs.length > 0) {
          geometry = geometry.toNonIndexed();
          geometry.setAttribute('uv', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(buffer.faceVertexUvs, 2));
        }

        // custom buffer data

        for (var _i2 = 0, _Object$keys2 = Object.keys(scope.customPropertyMapping); _i2 < _Object$keys2.length; _i2++) {
          var customProperty = _Object$keys2[_i2];
          if (buffer[customProperty].length > 0) {
            geometry.setAttribute(customProperty, new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(buffer[customProperty], scope.customPropertyMapping[customProperty].length));
          }
        }
        geometry.computeBoundingSphere();
        return geometry;
      }
      function handleElement(buffer, elementName, element) {
        function findAttrName(names) {
          for (var i = 0, l = names.length; i < l; i++) {
            var name = names[i];
            if (name in element) return name;
          }
          return null;
        }
        var attrX = findAttrName(['x', 'px', 'posx']) || 'x';
        var attrY = findAttrName(['y', 'py', 'posy']) || 'y';
        var attrZ = findAttrName(['z', 'pz', 'posz']) || 'z';
        var attrNX = findAttrName(['nx', 'normalx']);
        var attrNY = findAttrName(['ny', 'normaly']);
        var attrNZ = findAttrName(['nz', 'normalz']);
        var attrS = findAttrName(['s', 'u', 'texture_u', 'tx']);
        var attrT = findAttrName(['t', 'v', 'texture_v', 'ty']);
        var attrR = findAttrName(['red', 'diffuse_red', 'r', 'diffuse_r']);
        var attrG = findAttrName(['green', 'diffuse_green', 'g', 'diffuse_g']);
        var attrB = findAttrName(['blue', 'diffuse_blue', 'b', 'diffuse_b']);
        if (elementName === 'vertex') {
          buffer.vertices.push(element[attrX], element[attrY], element[attrZ]);
          if (attrNX !== null && attrNY !== null && attrNZ !== null) {
            buffer.normals.push(element[attrNX], element[attrNY], element[attrNZ]);
          }
          if (attrS !== null && attrT !== null) {
            buffer.uvs.push(element[attrS], element[attrT]);
          }
          if (attrR !== null && attrG !== null && attrB !== null) {
            _color.setRGB(element[attrR] / 255.0, element[attrG] / 255.0, element[attrB] / 255.0).convertSRGBToLinear();
            buffer.colors.push(_color.r, _color.g, _color.b);
          }
          for (var _i3 = 0, _Object$keys3 = Object.keys(scope.customPropertyMapping); _i3 < _Object$keys3.length; _i3++) {
            var customProperty = _Object$keys3[_i3];
            var _iterator = _createForOfIteratorHelper(scope.customPropertyMapping[customProperty]),
              _step;
            try {
              for (_iterator.s(); !(_step = _iterator.n()).done;) {
                var elementProperty = _step.value;
                buffer[customProperty].push(element[elementProperty]);
              }
            } catch (err) {
              _iterator.e(err);
            } finally {
              _iterator.f();
            }
          }
        } else if (elementName === 'face') {
          var vertex_indices = element.vertex_indices || element.vertex_index; // issue #9338
          var texcoord = element.texcoord;
          if (vertex_indices.length === 3) {
            buffer.indices.push(vertex_indices[0], vertex_indices[1], vertex_indices[2]);
            if (texcoord && texcoord.length === 6) {
              buffer.faceVertexUvs.push(texcoord[0], texcoord[1]);
              buffer.faceVertexUvs.push(texcoord[2], texcoord[3]);
              buffer.faceVertexUvs.push(texcoord[4], texcoord[5]);
            }
          } else if (vertex_indices.length === 4) {
            buffer.indices.push(vertex_indices[0], vertex_indices[1], vertex_indices[3]);
            buffer.indices.push(vertex_indices[1], vertex_indices[2], vertex_indices[3]);
          }
        }
      }
      function binaryRead(dataview, at, type, little_endian) {
        switch (type) {
          // corespondences for non-specific length types here match rply:
          case 'int8':
          case 'char':
            return [dataview.getInt8(at), 1];
          case 'uint8':
          case 'uchar':
            return [dataview.getUint8(at), 1];
          case 'int16':
          case 'short':
            return [dataview.getInt16(at, little_endian), 2];
          case 'uint16':
          case 'ushort':
            return [dataview.getUint16(at, little_endian), 2];
          case 'int32':
          case 'int':
            return [dataview.getInt32(at, little_endian), 4];
          case 'uint32':
          case 'uint':
            return [dataview.getUint32(at, little_endian), 4];
          case 'float32':
          case 'float':
            return [dataview.getFloat32(at, little_endian), 4];
          case 'float64':
          case 'double':
            return [dataview.getFloat64(at, little_endian), 8];
        }
      }
      function binaryReadElement(dataview, at, properties, little_endian) {
        var element = {};
        var result,
          read = 0;
        for (var i = 0; i < properties.length; i++) {
          if (properties[i].type === 'list') {
            var list = [];
            result = binaryRead(dataview, at + read, properties[i].countType, little_endian);
            var n = result[0];
            read += result[1];
            for (var j = 0; j < n; j++) {
              result = binaryRead(dataview, at + read, properties[i].itemType, little_endian);
              list.push(result[0]);
              read += result[1];
            }
            element[properties[i].name] = list;
          } else {
            result = binaryRead(dataview, at + read, properties[i].type, little_endian);
            element[properties[i].name] = result[0];
            read += result[1];
          }
        }
        return [element, read];
      }
      function parseBinary(data, header) {
        var buffer = createBuffer();
        var little_endian = header.format === 'binary_little_endian';
        var body = new DataView(data, header.headerLength);
        var result,
          loc = 0;
        for (var currentElement = 0; currentElement < header.elements.length; currentElement++) {
          for (var currentElementCount = 0; currentElementCount < header.elements[currentElement].count; currentElementCount++) {
            result = binaryReadElement(body, loc, header.elements[currentElement].properties, little_endian);
            loc += result[1];
            var element = result[0];
            handleElement(buffer, header.elements[currentElement].name, element);
          }
        }
        return postProcess(buffer);
      }

      //

      var geometry;
      var scope = this;
      if (data instanceof ArrayBuffer) {
        var text = _js_three_js__WEBPACK_IMPORTED_MODULE_0__.LoaderUtils.decodeText(new Uint8Array(data));
        var header = parseHeader(text);
        geometry = header.format === 'ascii' ? parseASCII(text, header) : parseBinary(data, header);
      } else {
        geometry = parseASCII(data, parseHeader(data));
      }
      return geometry;
    }
  }]);
  return PLYLoader;
}(_js_three_js__WEBPACK_IMPORTED_MODULE_0__.Loader);


/***/ })

}]);
//# sourceMappingURL=js_libs_PLYLoader_js.js.map