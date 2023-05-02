"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["js_libs_OBJLoader_js"],{

/***/ "./js/libs/OBJLoader.js":
/*!******************************!*\
  !*** ./js/libs/OBJLoader.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "OBJLoader": () => (/* binding */ OBJLoader)
/* harmony export */ });
/* harmony import */ var _js_three_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../js/three.js */ "../js/three.js");
/* harmony import */ var _js_three_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_js_three_js__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
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


// o object_name | g group_name
var _object_pattern = /^[og]\s*(.+)?/;
// mtllib file_reference
var _material_library_pattern = /^mtllib /;
// usemtl material_name
var _material_use_pattern = /^usemtl /;
// usemap map_name
var _map_use_pattern = /^usemap /;
var _face_vertex_data_separator_pattern = /\s+/;
var _vA = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Vector3();
var _vB = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Vector3();
var _vC = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Vector3();
var _ab = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Vector3();
var _cb = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Vector3();
var _color = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Color();
function ParserState() {
  var state = {
    objects: [],
    object: {},
    vertices: [],
    normals: [],
    colors: [],
    uvs: [],
    materials: {},
    materialLibraries: [],
    startObject: function startObject(name, fromDeclaration) {
      // If the current object (initial from reset) is not from a g/o declaration in the parsed
      // file. We need to use it for the first parsed g/o to keep things in sync.
      if (this.object && this.object.fromDeclaration === false) {
        this.object.name = name;
        this.object.fromDeclaration = fromDeclaration !== false;
        return;
      }
      var previousMaterial = this.object && typeof this.object.currentMaterial === 'function' ? this.object.currentMaterial() : undefined;
      if (this.object && typeof this.object._finalize === 'function') {
        this.object._finalize(true);
      }
      this.object = {
        name: name || '',
        fromDeclaration: fromDeclaration !== false,
        geometry: {
          vertices: [],
          normals: [],
          colors: [],
          uvs: [],
          hasUVIndices: false
        },
        materials: [],
        smooth: true,
        startMaterial: function startMaterial(name, libraries) {
          var previous = this._finalize(false);

          // New usemtl declaration overwrites an inherited material, except if faces were declared
          // after the material, then it must be preserved for proper MultiMaterial continuation.
          if (previous && (previous.inherited || previous.groupCount <= 0)) {
            this.materials.splice(previous.index, 1);
          }
          var material = {
            index: this.materials.length,
            name: name || '',
            mtllib: Array.isArray(libraries) && libraries.length > 0 ? libraries[libraries.length - 1] : '',
            smooth: previous !== undefined ? previous.smooth : this.smooth,
            groupStart: previous !== undefined ? previous.groupEnd : 0,
            groupEnd: -1,
            groupCount: -1,
            inherited: false,
            clone: function clone(index) {
              var cloned = {
                index: typeof index === 'number' ? index : this.index,
                name: this.name,
                mtllib: this.mtllib,
                smooth: this.smooth,
                groupStart: 0,
                groupEnd: -1,
                groupCount: -1,
                inherited: false
              };
              cloned.clone = this.clone.bind(cloned);
              return cloned;
            }
          };
          this.materials.push(material);
          return material;
        },
        currentMaterial: function currentMaterial() {
          if (this.materials.length > 0) {
            return this.materials[this.materials.length - 1];
          }
          return undefined;
        },
        _finalize: function _finalize(end) {
          var lastMultiMaterial = this.currentMaterial();
          if (lastMultiMaterial && lastMultiMaterial.groupEnd === -1) {
            lastMultiMaterial.groupEnd = this.geometry.vertices.length / 3;
            lastMultiMaterial.groupCount = lastMultiMaterial.groupEnd - lastMultiMaterial.groupStart;
            lastMultiMaterial.inherited = false;
          }

          // Ignore objects tail materials if no face declarations followed them before a new o/g started.
          if (end && this.materials.length > 1) {
            for (var mi = this.materials.length - 1; mi >= 0; mi--) {
              if (this.materials[mi].groupCount <= 0) {
                this.materials.splice(mi, 1);
              }
            }
          }

          // Guarantee at least one empty material, this makes the creation later more straight forward.
          if (end && this.materials.length === 0) {
            this.materials.push({
              name: '',
              smooth: this.smooth
            });
          }
          return lastMultiMaterial;
        }
      };

      // Inherit previous objects material.
      // Spec tells us that a declared material must be set to all objects until a new material is declared.
      // If a usemtl declaration is encountered while this new object is being parsed, it will
      // overwrite the inherited material. Exception being that there was already face declarations
      // to the inherited material, then it will be preserved for proper MultiMaterial continuation.

      if (previousMaterial && previousMaterial.name && typeof previousMaterial.clone === 'function') {
        var declared = previousMaterial.clone(0);
        declared.inherited = true;
        this.object.materials.push(declared);
      }
      this.objects.push(this.object);
    },
    finalize: function finalize() {
      if (this.object && typeof this.object._finalize === 'function') {
        this.object._finalize(true);
      }
    },
    parseVertexIndex: function parseVertexIndex(value, len) {
      var index = parseInt(value, 10);
      return (index >= 0 ? index - 1 : index + len / 3) * 3;
    },
    parseNormalIndex: function parseNormalIndex(value, len) {
      var index = parseInt(value, 10);
      return (index >= 0 ? index - 1 : index + len / 3) * 3;
    },
    parseUVIndex: function parseUVIndex(value, len) {
      var index = parseInt(value, 10);
      return (index >= 0 ? index - 1 : index + len / 2) * 2;
    },
    addVertex: function addVertex(a, b, c) {
      var src = this.vertices;
      var dst = this.object.geometry.vertices;
      dst.push(src[a + 0], src[a + 1], src[a + 2]);
      dst.push(src[b + 0], src[b + 1], src[b + 2]);
      dst.push(src[c + 0], src[c + 1], src[c + 2]);
    },
    addVertexPoint: function addVertexPoint(a) {
      var src = this.vertices;
      var dst = this.object.geometry.vertices;
      dst.push(src[a + 0], src[a + 1], src[a + 2]);
    },
    addVertexLine: function addVertexLine(a) {
      var src = this.vertices;
      var dst = this.object.geometry.vertices;
      dst.push(src[a + 0], src[a + 1], src[a + 2]);
    },
    addNormal: function addNormal(a, b, c) {
      var src = this.normals;
      var dst = this.object.geometry.normals;
      dst.push(src[a + 0], src[a + 1], src[a + 2]);
      dst.push(src[b + 0], src[b + 1], src[b + 2]);
      dst.push(src[c + 0], src[c + 1], src[c + 2]);
    },
    addFaceNormal: function addFaceNormal(a, b, c) {
      var src = this.vertices;
      var dst = this.object.geometry.normals;
      _vA.fromArray(src, a);
      _vB.fromArray(src, b);
      _vC.fromArray(src, c);
      _cb.subVectors(_vC, _vB);
      _ab.subVectors(_vA, _vB);
      _cb.cross(_ab);
      _cb.normalize();
      dst.push(_cb.x, _cb.y, _cb.z);
      dst.push(_cb.x, _cb.y, _cb.z);
      dst.push(_cb.x, _cb.y, _cb.z);
    },
    addColor: function addColor(a, b, c) {
      var src = this.colors;
      var dst = this.object.geometry.colors;
      if (src[a] !== undefined) dst.push(src[a + 0], src[a + 1], src[a + 2]);
      if (src[b] !== undefined) dst.push(src[b + 0], src[b + 1], src[b + 2]);
      if (src[c] !== undefined) dst.push(src[c + 0], src[c + 1], src[c + 2]);
    },
    addUV: function addUV(a, b, c) {
      var src = this.uvs;
      var dst = this.object.geometry.uvs;
      dst.push(src[a + 0], src[a + 1]);
      dst.push(src[b + 0], src[b + 1]);
      dst.push(src[c + 0], src[c + 1]);
    },
    addDefaultUV: function addDefaultUV() {
      var dst = this.object.geometry.uvs;
      dst.push(0, 0);
      dst.push(0, 0);
      dst.push(0, 0);
    },
    addUVLine: function addUVLine(a) {
      var src = this.uvs;
      var dst = this.object.geometry.uvs;
      dst.push(src[a + 0], src[a + 1]);
    },
    addFace: function addFace(a, b, c, ua, ub, uc, na, nb, nc) {
      var vLen = this.vertices.length;
      var ia = this.parseVertexIndex(a, vLen);
      var ib = this.parseVertexIndex(b, vLen);
      var ic = this.parseVertexIndex(c, vLen);
      this.addVertex(ia, ib, ic);
      this.addColor(ia, ib, ic);

      // normals

      if (na !== undefined && na !== '') {
        var nLen = this.normals.length;
        ia = this.parseNormalIndex(na, nLen);
        ib = this.parseNormalIndex(nb, nLen);
        ic = this.parseNormalIndex(nc, nLen);
        this.addNormal(ia, ib, ic);
      } else {
        this.addFaceNormal(ia, ib, ic);
      }

      // uvs

      if (ua !== undefined && ua !== '') {
        var uvLen = this.uvs.length;
        ia = this.parseUVIndex(ua, uvLen);
        ib = this.parseUVIndex(ub, uvLen);
        ic = this.parseUVIndex(uc, uvLen);
        this.addUV(ia, ib, ic);
        this.object.geometry.hasUVIndices = true;
      } else {
        // add placeholder values (for inconsistent face definitions)

        this.addDefaultUV();
      }
    },
    addPointGeometry: function addPointGeometry(vertices) {
      this.object.geometry.type = 'Points';
      var vLen = this.vertices.length;
      for (var vi = 0, l = vertices.length; vi < l; vi++) {
        var index = this.parseVertexIndex(vertices[vi], vLen);
        this.addVertexPoint(index);
        this.addColor(index);
      }
    },
    addLineGeometry: function addLineGeometry(vertices, uvs) {
      this.object.geometry.type = 'Line';
      var vLen = this.vertices.length;
      var uvLen = this.uvs.length;
      for (var vi = 0, l = vertices.length; vi < l; vi++) {
        this.addVertexLine(this.parseVertexIndex(vertices[vi], vLen));
      }
      for (var uvi = 0, _l = uvs.length; uvi < _l; uvi++) {
        this.addUVLine(this.parseUVIndex(uvs[uvi], uvLen));
      }
    }
  };
  state.startObject('', false);
  return state;
}

//
var OBJLoader = /*#__PURE__*/function (_Loader) {
  _inherits(OBJLoader, _Loader);
  var _super = _createSuper(OBJLoader);
  function OBJLoader(manager) {
    var _this;
    _classCallCheck(this, OBJLoader);
    _this = _super.call(this, manager);
    _this.materials = null;
    return _this;
  }
  _createClass(OBJLoader, [{
    key: "load",
    value: function load(url, onLoad, onProgress, onError) {
      var scope = this;
      var loader = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.FileLoader(this.manager);
      loader.setPath(this.path);
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
    key: "setMaterials",
    value: function setMaterials(materials) {
      this.materials = materials;
      return this;
    }
  }, {
    key: "parse",
    value: function parse(text) {
      var state = new ParserState();
      if (text.indexOf('\r\n') !== -1) {
        // This is faster than String.split with regex that splits on both
        text = text.replace(/\r\n/g, '\n');
      }
      if (text.indexOf('\\\n') !== -1) {
        // join lines separated by a line continuation character (\)
        text = text.replace(/\\\n/g, '');
      }
      var lines = text.split('\n');
      var result = [];
      for (var i = 0, l = lines.length; i < l; i++) {
        var line = lines[i].trimStart();
        if (line.length === 0) continue;
        var lineFirstChar = line.charAt(0);

        // @todo invoke passed in handler if any
        if (lineFirstChar === '#') continue;
        if (lineFirstChar === 'v') {
          var data = line.split(_face_vertex_data_separator_pattern);
          switch (data[0]) {
            case 'v':
              state.vertices.push(parseFloat(data[1]), parseFloat(data[2]), parseFloat(data[3]));
              if (data.length >= 7) {
                _color.setRGB(parseFloat(data[4]), parseFloat(data[5]), parseFloat(data[6])).convertSRGBToLinear();
                state.colors.push(_color.r, _color.g, _color.b);
              } else {
                // if no colors are defined, add placeholders so color and vertex indices match

                state.colors.push(undefined, undefined, undefined);
              }
              break;
            case 'vn':
              state.normals.push(parseFloat(data[1]), parseFloat(data[2]), parseFloat(data[3]));
              break;
            case 'vt':
              state.uvs.push(parseFloat(data[1]), parseFloat(data[2]));
              break;
          }
        } else if (lineFirstChar === 'f') {
          var lineData = line.slice(1).trim();
          var vertexData = lineData.split(_face_vertex_data_separator_pattern);
          var faceVertices = [];

          // Parse the face vertex data into an easy to work with format

          for (var j = 0, jl = vertexData.length; j < jl; j++) {
            var vertex = vertexData[j];
            if (vertex.length > 0) {
              var vertexParts = vertex.split('/');
              faceVertices.push(vertexParts);
            }
          }

          // Draw an edge between the first vertex and all subsequent vertices to form an n-gon

          var v1 = faceVertices[0];
          for (var _j = 1, _jl = faceVertices.length - 1; _j < _jl; _j++) {
            var v2 = faceVertices[_j];
            var v3 = faceVertices[_j + 1];
            state.addFace(v1[0], v2[0], v3[0], v1[1], v2[1], v3[1], v1[2], v2[2], v3[2]);
          }
        } else if (lineFirstChar === 'l') {
          var lineParts = line.substring(1).trim().split(' ');
          var lineVertices = [];
          var lineUVs = [];
          if (line.indexOf('/') === -1) {
            lineVertices = lineParts;
          } else {
            for (var li = 0, llen = lineParts.length; li < llen; li++) {
              var parts = lineParts[li].split('/');
              if (parts[0] !== '') lineVertices.push(parts[0]);
              if (parts[1] !== '') lineUVs.push(parts[1]);
            }
          }
          state.addLineGeometry(lineVertices, lineUVs);
        } else if (lineFirstChar === 'p') {
          var _lineData = line.slice(1).trim();
          var pointData = _lineData.split(' ');
          state.addPointGeometry(pointData);
        } else if ((result = _object_pattern.exec(line)) !== null) {
          // o object_name
          // or
          // g group_name

          // WORKAROUND: https://bugs.chromium.org/p/v8/issues/detail?id=2869
          // let name = result[ 0 ].slice( 1 ).trim();
          var name = (' ' + result[0].slice(1).trim()).slice(1);
          state.startObject(name);
        } else if (_material_use_pattern.test(line)) {
          // material

          state.object.startMaterial(line.substring(7).trim(), state.materialLibraries);
        } else if (_material_library_pattern.test(line)) {
          // mtl file

          state.materialLibraries.push(line.substring(7).trim());
        } else if (_map_use_pattern.test(line)) {
          // the line is parsed but ignored since the loader assumes textures are defined MTL files
          // (according to https://www.okino.com/conv/imp_wave.htm, 'usemap' is the old-style Wavefront texture reference method)

          console.warn('THREE.OBJLoader: Rendering identifier "usemap" not supported. Textures must be defined in MTL files.');
        } else if (lineFirstChar === 's') {
          result = line.split(' ');

          // smooth shading

          // @todo Handle files that have varying smooth values for a set of faces inside one geometry,
          // but does not define a usemtl for each face set.
          // This should be detected and a dummy material created (later MultiMaterial and geometry groups).
          // This requires some care to not create extra material on each smooth value for "normal" obj files.
          // where explicit usemtl defines geometry groups.
          // Example asset: examples/models/obj/cerberus/Cerberus.obj

          /*
          	 * http://paulbourke.net/dataformats/obj/
          	 *
          	 * From chapter "Grouping" Syntax explanation "s group_number":
          	 * "group_number is the smoothing group number. To turn off smoothing groups, use a value of 0 or off.
          	 * Polygonal elements use group numbers to put elements in different smoothing groups. For free-form
          	 * surfaces, smoothing groups are either turned on or off; there is no difference between values greater
          	 * than 0."
          	 */
          if (result.length > 1) {
            var value = result[1].trim().toLowerCase();
            state.object.smooth = value !== '0' && value !== 'off';
          } else {
            // ZBrush can produce "s" lines #11707
            state.object.smooth = true;
          }
          var material = state.object.currentMaterial();
          if (material) material.smooth = state.object.smooth;
        } else {
          // Handle null terminated files without exception
          if (line === '\0') continue;
          console.warn('THREE.OBJLoader: Unexpected line: "' + line + '"');
        }
      }
      state.finalize();
      var container = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Group();
      container.materialLibraries = [].concat(state.materialLibraries);
      var hasPrimitives = !(state.objects.length === 1 && state.objects[0].geometry.vertices.length === 0);
      if (hasPrimitives === true) {
        for (var _i = 0, _l2 = state.objects.length; _i < _l2; _i++) {
          var object = state.objects[_i];
          var geometry = object.geometry;
          var materials = object.materials;
          var isLine = geometry.type === 'Line';
          var isPoints = geometry.type === 'Points';
          var hasVertexColors = false;

          // Skip o/g line declarations that did not follow with any faces
          if (geometry.vertices.length === 0) continue;
          var buffergeometry = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.BufferGeometry();
          buffergeometry.setAttribute('position', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(geometry.vertices, 3));
          if (geometry.normals.length > 0) {
            buffergeometry.setAttribute('normal', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(geometry.normals, 3));
          }
          if (geometry.colors.length > 0) {
            hasVertexColors = true;
            buffergeometry.setAttribute('color', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(geometry.colors, 3));
          }
          if (geometry.hasUVIndices === true) {
            buffergeometry.setAttribute('uv', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(geometry.uvs, 2));
          }

          // Create materials

          var createdMaterials = [];
          for (var mi = 0, miLen = materials.length; mi < miLen; mi++) {
            var sourceMaterial = materials[mi];
            var materialHash = sourceMaterial.name + '_' + sourceMaterial.smooth + '_' + hasVertexColors;
            var _material = state.materials[materialHash];
            if (this.materials !== null) {
              _material = this.materials.create(sourceMaterial.name);

              // mtl etc. loaders probably can't create line materials correctly, copy properties to a line material.
              if (isLine && _material && !(_material instanceof _js_three_js__WEBPACK_IMPORTED_MODULE_0__.LineBasicMaterial)) {
                var materialLine = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.LineBasicMaterial();
                _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Material.prototype.copy.call(materialLine, _material);
                materialLine.color.copy(_material.color);
                _material = materialLine;
              } else if (isPoints && _material && !(_material instanceof _js_three_js__WEBPACK_IMPORTED_MODULE_0__.PointsMaterial)) {
                var materialPoints = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.PointsMaterial({
                  size: 10,
                  sizeAttenuation: false
                });
                _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Material.prototype.copy.call(materialPoints, _material);
                materialPoints.color.copy(_material.color);
                materialPoints.map = _material.map;
                _material = materialPoints;
              }
            }
            if (_material === undefined) {
              if (isLine) {
                _material = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.LineBasicMaterial();
              } else if (isPoints) {
                _material = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.PointsMaterial({
                  size: 1,
                  sizeAttenuation: false
                });
              } else {
                _material = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.MeshPhongMaterial();
              }
              _material.name = sourceMaterial.name;
              _material.flatShading = sourceMaterial.smooth ? false : true;
              _material.vertexColors = hasVertexColors;
              state.materials[materialHash] = _material;
            }
            createdMaterials.push(_material);
          }

          // Create mesh

          var mesh = void 0;
          if (createdMaterials.length > 1) {
            for (var _mi = 0, _miLen = materials.length; _mi < _miLen; _mi++) {
              var _sourceMaterial = materials[_mi];
              buffergeometry.addGroup(_sourceMaterial.groupStart, _sourceMaterial.groupCount, _mi);
            }
            if (isLine) {
              mesh = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.LineSegments(buffergeometry, createdMaterials);
            } else if (isPoints) {
              mesh = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Points(buffergeometry, createdMaterials);
            } else {
              mesh = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Mesh(buffergeometry, createdMaterials);
            }
          } else {
            if (isLine) {
              mesh = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.LineSegments(buffergeometry, createdMaterials[0]);
            } else if (isPoints) {
              mesh = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Points(buffergeometry, createdMaterials[0]);
            } else {
              mesh = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Mesh(buffergeometry, createdMaterials[0]);
            }
          }
          mesh.name = object.name;
          container.add(mesh);
        }
      } else {
        // if there is only the default parser state object with no geometry data, interpret data as point cloud

        if (state.vertices.length > 0) {
          var _material2 = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.PointsMaterial({
            size: 1,
            sizeAttenuation: false
          });
          var _buffergeometry = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.BufferGeometry();
          _buffergeometry.setAttribute('position', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(state.vertices, 3));
          if (state.colors.length > 0 && state.colors[0] !== undefined) {
            _buffergeometry.setAttribute('color', new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Float32BufferAttribute(state.colors, 3));
            _material2.vertexColors = true;
          }
          var points = new _js_three_js__WEBPACK_IMPORTED_MODULE_0__.Points(_buffergeometry, _material2);
          container.add(points);
        }
      }
      return container;
    }
  }]);
  return OBJLoader;
}(_js_three_js__WEBPACK_IMPORTED_MODULE_0__.Loader);


/***/ })

}]);
//# sourceMappingURL=js_libs_OBJLoader_js.js.map