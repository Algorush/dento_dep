if (!Detector.webgl) Detector.addGetWebGLMessage();
import { OrbitControls } from "./OrbitControls.js";

var container, stats;

var camera, scene, renderer, cameraControls;
var spotlight;

var animation = false;
var timer = 0;
var attachmentsVisibility = true;

var animations = {
  lower: [],
  upper: [],
};

var bar = 0;
var barwidth = 250;

var step = 0;

var loadersLow = [];
var loadersUp = [];

var tween = [];

var initialTrigger = false;

var pivots_up = [];
var pivots_down = [];

var initialUpperPos = [];

var upperPivots = [];

var assetsLoaded = 0;
const renderSize = new THREE.Vector2();
var grid = new THREE.Group();
grid.visible = false;

var jawBox; // bounding box for grid
var modelLower = new THREE.Group();
modelLower.name = "model-lower";
var modelUpper = new THREE.Group();
modelUpper.name = "model-upper";

var options = {
  upper: 1,
  lower: 1,
  pathLower: [],
  pathUp: [],
  pathPositionLower: {},
  pathPositionUpper: {},
};
function parseFilename(filename) {
  const fileNameParts = filename.split("_");
  const lastInd = fileNameParts.length - 1;
  let isAttach = false; // filename of attachment
  let fileInd = null;
  const lastPart = fileNameParts[lastInd].split(".")[0];
  if (lastPart == "I2M") {
    fileInd = fileNameParts[lastInd - 1];
    isAttach = true;
  } else {
    fileInd = lastPart;
  }
  return {
    fileName: filename,
    fileInd: fileInd,
    isAttach: isAttach,
  };
}
var maxSteps = options.lower;

function hideDiv() {
  $(".modal-container").hide();
  $("#canvas").addClass("full-canvas");
  $(".controls-up").addClass("full-controls-up");
  $(".controls").addClass("full-controls");
  $(".btns-up").addClass("full-btns-up");
  $(".details_btn").show();
}

function showDiv() {
  $("#canvas").removeClass("full-canvas");
  $(".controls-up").removeClass("full-controls-up");
  $(".controls").removeClass("full-controls");
  $(".btns-up").removeClass("full-btns-up");
  $(".modal-container").show();
  $(".details_btn").hide();
}

function sortFileOptions() {
  // sort file options by feliInd
  ['Lower', 'Up'].forEach(partName => {
    options[`path${partName}`].sort((data1, data2) => {
      return parseInt(data1.fileInd) - parseInt(data2.fileInd)
    });
  })
}

$(document).ready(function () {
  var id = window.location.pathname.split("/").slice(-1)[0];

  $.ajax({
    type: "GET",
    url: "/case/files/" + id,
    success: function (data) {
      options.pathLower = data.lowerFiles.map(parseFilename);
      options.pathUp = data.upperFiles.map(parseFilename);
      // exclude attachments file names that end with '_I2M' or another chars except numbers
      options.lower = options.pathLower.filter(
        (fileNameOptions) => !fileNameOptions.isAttach
      ).length;
      options.upper = options.pathUp.filter(
        (fileNameOptions) => !fileNameOptions.isAttach
      ).length;
      sortFileOptions();
      options.pathPositionLower = data.positions.lowerFiles;
      options.pathPositionUpper = data.positions.upperFiles;
      maxSteps = options.lower;
      if (options.upper > maxSteps) {
        maxSteps = options.upper;
      }

      //disable a#attach element if there is no attachments
      if (
        options.lower == options.pathLower.length &&
        options.upper == options.pathUp.length
      ) {
        document.querySelector("#attach").style.display = "none";
      }
      const wear_days_val = parseInt(
        document.querySelector(".wear_days").innerHTML.trim()
      );
      if (wear_days_val) {
        duration_weeks.innerHTML = Math.ceil(
          (parseInt(wear_days_val) * (maxSteps - 1)) / 7
        );
      }
      initScene();
      //animate();
    },
  });

  function distanceVec(v1, v2) {
    return {
      x: v1.x - v2.x,
      y: v1.y - v2.y,
      z: v1.z - v2.z
    }
  }

  function findCenterObj(obj) {
    const centerVec = new THREE.Vector3();
    obj.geometry.computeBoundingBox();
    const bbox = new THREE.Box3().setFromObject(obj);
    bbox.getCenter(centerVec);
    return centerVec;
  }

  function centerdObj(obj, distLowToUp) {
    obj.geometry.center();
    if (distLowToUp) {
      obj.position.set(distLowToUp.x, distLowToUp.z, distLowToUp.y); 
    }
  }

  function changePosition(obj, partName) {
    const positions =
      partName == "lower"
        ? options.pathPositionLower
        : options.pathPositionUpper;

    if (positions.position_x) {
      obj.position.x = positions.position_x;
    }
    if (positions.position_y) {
      obj.position.y = positions.position_y;
    }
    if (positions.rotation_y) {
      obj.rotation.y = positions.rotation_y;
    }
  }

  function centeredModels() {
    // centering object only by X and Y axises
    let distLowToUp = 0;
    console.log(modelLower)
    for (let ind=0; ind<options.lower; ind++) {
      const objLo = modelLower.children[ind];
      const objUp = modelUpper.children[ind];

      distLowToUp = distanceVec(
        findCenterObj(objUp),
        findCenterObj(objLo)
      );
      
      centerdObj(objUp, distLowToUp);
      centerdObj(objLo);

      objLo.rotation.x = -Math.PI / 2;
      objUp.rotation.x = -Math.PI / 2;

      changePosition(objUp, "upper");
      changePosition(objLo, "lower");
      jawBox = boundingBox(jawBox, objLo);
      jawBox = boundingBox(jawBox, objUp);
    }
  }

  function boundingBox(bbox, object) {
    // return bounding box of object
    if (!bbox) {
      object.geometry.computeBoundingBox();
      bbox = new THREE.Box3();
      bbox.setFromObject(object);
    } else {
      bbox.expandByObject(object);
    }
    return bbox;
  }

  function initScene() {

    container = document.getElementById("canvas");
    camera = new THREE.PerspectiveCamera(
      60,
      window.innerWidth / window.innerHeight,
      0.1,
      10000
    );

    camera.position.set(0, 0, 130);
    camera.updateProjectionMatrix();

    scene = new THREE.Scene();

    scene.add(modelLower);
    scene.add(modelUpper);

    $("#step-lower-total").append(options.lower - 1);
    $("#step-upper-total").append(options.upper - 1);

    $(".logo").html('<img src="' + options.logo + '">');

    const manager = new THREE.LoadingManager();

    manager.onProgress = function (item, loaded, total) {
      //bar = Math.floor((barwidth * loaded) / total);
      //var percent = (100 * loaded) / total;
      //$("#bar").css("width", "" + bar + "px");
      //$("#percent").html(Math.round(percent) + " %");

    };
    manager.onLoad = function ( ) {

      console.log( 'Loading complete!');
      $("#progressbar").fadeOut("300");
      $("#progress").fadeOut("300");
      $(".loader2").fadeOut("slow");

      render();    
    };
    
    // Instantiate a loader
    //const loader = new OBJLoader();
    const loader = new THREE.DRACOLoader(manager);
    
    // Specify path to a folder containing WASM/JS decoding libraries.
    loader.setDecoderPath( '../draco/' );
    loader.preload();
    //loader.setDecoderConfig( 'js' );
  
/*    
    for (var i = 0; i < options.pathLower.length; i++) {
      loadersLow[i] = loader;
    }

    for (var i = 0; i < options.pathUp.length; i++) {
      loadersUp[i] = loader;
    }*/
/*
    onProgress = function (xhr) {
      if (xhr.lengthComputable) {
      }
    };
    onError = function (xhr) {};
*/

    function loadAnimation(
      responseData,
      animationPart,
      partName,
      modelGroup,
      optionsPart
    ) {
      let attachments = [];
      let attach_ind = 0,
        file_ind = 0;
      
      for (var i = 0; i < responseData.length; i++) {
        const geometry = responseData[i];
        const obj = new THREE.Mesh( geometry, new THREE.MeshStandardMaterial() );
        const fileInd = parseInt(optionsPart[i].fileInd);
        const isAttach = optionsPart[i].isAttach;
        obj.fileInd = fileInd;
        (obj.idU = i), modelGroup.add(obj);

        if (isAttach) {
          obj.name = "attach-" + partName + attach_ind;
          attachments[attach_ind++] = obj;
        } else {
          obj.name = "model-" + partName + file_ind;
          animationPart[file_ind++] = obj;
        }
      }
      animationPart.forEach((jawObject) => {
        const attach = attachments.find(
          (attachObj) => attachObj.fileInd == jawObject.fileInd
        );
        if (attach) reparentObject3D(attach, jawObject);
      });
      for (var i = 0; i < animationPart.length; i++) {
        animationPart[i].visible = false;
        animationPart[i].material.vertexColors = true;
        animationPart[i].material.roughness = 0.3;
      }
      if (animationPart[0]) {
        // expand bounding box by jaw model
        animationPart[0].visible = true;
        if (animationPart[0])
          animationPart[0].visible = attachmentsVisibility;
      }
    }

    const promises1 = [...new Array(options.pathLower.length)].map(
      async (number, i) => {
        const path = options.pathLower[i].fileName;
        return new Promise((resolve) => {
          //loadersLow[i].load(path, resolve);
          loader.load(path, resolve);
        });
      }
    );
    const promises2 = [...new Array(options.pathUp.length)].map(
      async (number, i) => {
        const path = options.pathUp[i].fileName;
        return new Promise((resolve) => {
          //loadersUp[i].load(path, resolve);
          loader.load(path, resolve);
        });
      }
    );
    Promise.all(promises1.concat(promises2)).then((result) => {
      const lower_result = result.slice(0, options.pathLower.length);
      const upper_result = result.slice(
        options.pathLower.length,
        result.length
      );
      loadAnimation(
        lower_result,
        animations.lower,
        "lower",
        modelLower,
        options.pathLower
      );
      loadAnimation(
        upper_result,
        animations.upper,
        "upper",
        modelUpper,
        options.pathUp
      );
      centeredModels();
      render();
      setGrid(jawBox);

      return null;
    });

    // Lights
    const hemiLight = new THREE.HemisphereLight(0x969797, 0x969797, 0.8);
    scene.add(hemiLight);

    spotlight = new THREE.SpotLight(0x969797, 1);
    spotlight.position.set(0, 0, 0);
    scene.add(spotlight);
    spotlight.shadow.mapSize.width = 1024 * 4;
    spotlight.shadow.mapSize.height = 1024 * 4;

    // renderer
    renderer = new THREE.WebGLRenderer({
      antialias: true,
      preserveDrawingBuffer: true,
      alpha: true,
    });
    renderer.setPixelRatio(window.devicePixelRatio);

    renderer.setClearColor(0x000000, 0);

    container.appendChild(renderer.domElement);

    // CONTROLS
    cameraControls = new OrbitControls(camera, renderer.domElement);
    cameraControls.addEventListener( 'change', render);
/*    cameraControls.maxDistance = 400;
    cameraControls.rotateSpeed = 1.2;
    cameraControls.staticMoving = false;
*/
    cameraControls.rotateSpeed = 1.2;
    cameraControls.minDistance = 30;
    cameraControls.maxDistance = 150;
    //cameraControls.target0 = {x:40,y:-70,z:0};
    cameraControls.target.set(0, 5, 0);
    cameraControls.update();

    window.addEventListener("resize", onWindowResize, false);
    onWindowResize();

    scene.add(camera);

    // change parent of subobject
    function reparentObject3D(subject, newParent) {
      subject.matrix.copy(subject.matrixWorld);
      //mat4.copy(mat4).invert()
      //mat4.copyInverse(mat4) // Better performance
      subject.applyMatrix4(
        new THREE.Matrix4().invert(newParent.matrixWorld)
      );
      newParent.add(subject);
      subject.position.set(0, 0, 0);
      subject.rotation.set(0, 0, 0);
    }
    function createAGrid(config, gridObject) {
      config.color = 0xa6a6a6;
      var material = new THREE.LineBasicMaterial({
        color: config.color,
        opacity: 0.2,
      });
      let halfHeight = config.height / 2;
      let halfWidth = config.width / 2;
      var stepw = config.width / config.linesWidth,
        steph = config.height / config.linesHeight;
      //width
      let positions = [];
      for (var i = -halfWidth; i <= halfWidth; i += stepw) {
        positions.push(-halfHeight, i, 0);
        positions.push(halfHeight, i, 0);
      }
      //height
      for (var i = -halfHeight; i <= halfHeight; i += steph) {
        positions.push(i, -halfWidth, 0);
        positions.push(i, halfWidth, 0);
      }
      const gridGeo = new THREE.BufferGeometry();
      const positionNumComponents = 3;
      const normalNumComponents = 3;
      const uvNumComponents = 2;
      gridGeo.setAttribute(
          'position',
          new THREE.BufferAttribute(new Float32Array(positions), positionNumComponents));

      var line = new THREE.LineSegments(gridGeo, material);
      reparentObject3D(line, gridObject);
    }

    function setGrid(bbox) {
      const boxSize = bbox.getSize(new THREE.Vector3());
      const boxCenter = bbox.getCenter(new THREE.Vector3());
      grid.position.copy(boxCenter);
      const optionsXY = {
        height: boxSize.x,
        width: boxSize.y,
        linesHeight: boxSize.x,
        linesWidth: boxSize.y,
      };
      createAGrid(optionsXY, grid); // front
      grid.children[0].position.z = boxSize.z / 2;
      const optionsYZ = {
        height: boxSize.y,
        width: boxSize.z,
        linesHeight: boxSize.y,
        linesWidth: boxSize.z,
      };
      createAGrid(optionsYZ, grid); //left
      grid.children[1].rotation.x = Math.PI / 2;
      grid.children[1].rotation.y = Math.PI / 2;
      grid.children[1].position.x += boxSize.x / 2;

      createAGrid(optionsYZ, grid); // right
      grid.children[2].rotation.x = Math.PI / 2;
      grid.children[2].rotation.y = Math.PI / 2;
      grid.children[2].position.x -= boxSize.x / 2;
      const optionsXZ = {
        height: boxSize.x,
        width: boxSize.z,
        linesHeight: boxSize.x,
        linesWidth: boxSize.z,
      };
      createAGrid(optionsXZ, grid); // up
      grid.children[3].visible = false;
      grid.children[3].rotation.x = Math.PI / 2;
      grid.children[3].position.y += boxSize.y / 2;

      createAGrid(optionsXZ, grid); // down
      grid.children[4].visible = true;
      grid.children[4].rotation.x = Math.PI / 2;
      grid.children[4].position.y -= boxSize.y / 2;
      scene.add(grid);
      if (modelLower.children.length !== 0) {
        modelLower.add(grid);
      } else if (modelUpper.children.length !== 0) {
        modelUpper.add(grid);
      }
    }
  }

  // added
  function onWindowResize() {
    const canvas = renderer.domElement;

    renderer.getSize(renderSize);
    const width = canvas.clientWidth | 0;
    const height = canvas.clientHeight | 0;
    if (renderSize.x !== width || renderSize.y !== height) {
      renderer.setSize(width, height, false);
    }
    camera.aspect = canvas.clientWidth / canvas.clientHeight;
    camera.updateProjectionMatrix();
    renderer.render(scene, camera);
  }

  function animate() {
    spotlight.position.set(
      camera.position.x + 10,
      camera.position.y + 10,
      camera.position.z + 10
    );
    //requestAnimationFrame(animate);
    //TWEEN.update();
    //cameraControls.update();
    render();
  }

  function render() {
    spotlight.position.set(
      camera.position.x + 10,
      camera.position.y + 10,
      camera.position.z + 10
    );
    TWEEN.update();
    renderer.render(scene, camera);
  }

  $("#animate").click(function () {
    animateObject();
  });

  $("#reset").click(function () {

    controlsReset();
    $("body").find(".btn-up#front").trigger("click");
    grid.visible = false;

    step = 0;
    applyStep();

    let stepUpper, stepLower;
    if (step <= options.upper - 1) {
      stepUpper = step.toString();
    } else if (options.upper >= 0) {
      stepUpper = options.upper - 1;
    }
    if (step <= options.lower - 1) {
      stepLower = step.toString();
    } else if (options.lower >= 0) {
      stepLower = options.lower - 1;
    }
    const attachUpper = modelUpper.getObjectByName("attach-upper" + stepUpper);
    const attachLower = modelLower.getObjectByName("attach-lower" + stepLower);
    if (attachUpper && stepUpper) attachUpper.visible = true;
    if (attachLower && stepLower) attachLower.visible = true;
    render();
  });

  // SLIDERS
  var sliders = document.getElementsByClassName("slider");

  for (var i = 0; i < sliders.length; i++) {
    sliders[i].addEventListener("input", onSliderChange, false);
  }

  function onSliderChange() {
    var output = "slider" + this.id + "-value";
    document.getElementById(output).innerHTML = this.value;
  }

  function changeVisibility(partName) {
    if (step <= options[partName] - 1) {
      $(`#step-${partName}`).html(step);
      for (var i = 0; i < animations[partName].length; i++) {        
        animations[partName][i].visible = false;
      }
      animations[partName][step].visible = true;
      const attachPart = animations[partName][step].children[1];
      if (attachPart) attachPart.visible = attachmentsVisibility;
    } else {
      for (var i = 0; i < animations[partName].length; i++) {
        animations[partName][i].visible = false;
      }
      if (animations[partName][options[partName] - 1]) {
        $(`#step-${partName}`).html(options[partName] - 1);
        animations[partName][options[partName] - 1].visible = true;
        const attachPart = animations[partName][options[partName] - 1].children[1];
        if (attachPart) attachPart.visible = attachmentsVisibility;
      }
    }
  }

  function applyStep() {
    changeVisibility('lower');
    changeVisibility('upper');
    render();
  }

  $("body").on("click", "a.ctrl", function () {
    animateObject($(this).data("id"));
  });

  $("body").on("click", ".play", function () {
    callFunctionWithTimer(maxSteps, 1000);
  });

  // call function (to-from) times with interval 1000ms.
  function callFunctionWithTimer(to, delay) {
    if (to - step > 1) {
      setTimeout(function go() {
        applyStep();
        if (step < to - 1) {
          setTimeout(go, delay);
          step++;
        }
      }, 100); // initial delay in ms
    }
  }

  $("body").on("click", ".back", function () {
    if (step > 0) {
      step -= 1;
    }
    applyStep();
  });

  $("body").on("click", ".next", function () {
    if (step < maxSteps - 1) {
      step += 1;
      applyStep();
    }
  });

  $("body").on("click", ".start", function () {
    step = 0;
    applyStep();
  });

  $("body").on("click", ".end", function () {
    step = maxSteps - 1;
    applyStep();
  });

  function controlsReset() {
    cameraControls.reset();
    cameraControls.target.set(0, 5, 0);
    cameraControls.update();   
  }

  function changeView(visibleUp=true, visibleLow=true, rotVec=[0, 0, 0], gridUp=true, gridLow=false) {
    controlsReset();

    modelLower.visible = visibleLow;
    modelUpper.visible = visibleUp;

    modelUpper.rotation.set(...rotVec);
    modelLower.rotation.set(...rotVec);

    grid.children[3].visible = gridLow;
    grid.children[4].visible = gridUp;
    render();    
  }

  $("body").on("click", ".btn-up#up", function () {
    modelUpper.add(grid);
    changeView(true, false, [-Math.PI / 2, 0, 0], true, false);
  });

  $("body").on("click", ".btn-up#front", function () {
    changeView();
  });

  $("body").on("click", ".btn-up#low", function () {
    modelLower.add(grid);
    changeView(false, true, [Math.PI / 2, 0, 0], false, true);
  });

  $("body").on("click", ".btn-up#right", function () {
    changeView(true, true, [0, Math.PI / 2, 0], false, true);
  });

  $("body").on("click", ".btn-up#left", function () {
    changeView(true, true, [0, -Math.PI / 2, 0], false, true);
  });

  $("body").on("click", ".btns-up #grid", function (e) {
    e.preventDefault();
    grid.visible = !grid.visible;
    render();
  });

  $("body").on("click", ".btns-up #attach", function (e) {
    e.preventDefault();
    attachmentsVisibility = !attachmentsVisibility;
    let stepUpper, stepLower;
    if (step <= options.upper - 1) {
      stepUpper = step.toString();
    } else if (options.upper >= 0) {
      stepUpper = options.upper - 1;
    }
    if (step <= options.lower - 1) {
      stepLower = step.toString();
    } else if (options.lower >= 0) {
      stepLower = options.lower - 1;
    }
    const attachUpper = modelUpper.getObjectByName("attach-upper" + stepUpper);
    const attachLower = modelLower.getObjectByName("attach-lower" + stepLower);
    if (attachUpper && stepUpper) attachUpper.visible = attachmentsVisibility;
    if (attachLower && stepLower) attachLower.visible = attachmentsVisibility;
    render();
  });

  $("body").on("click", ".btns-up #IPR-show", function (e) {
    e.preventDefault();
    $("#IPR-img").toggle();
  });

  $("#IPR-img").on("click", function () {
    $(this).hide();
  });

  function toggleModal() {
    const modal = document.querySelector(".modal-container");
    const canvas = document.getElementById("canvas");  
      modal.classList.toggle("hide");
      canvas.classList.toggle("hide");  
      onWindowResize();   
  }
  $(".modal-container").on("click", function () {
    toggleModal(); 
  });
  $(".close-btn").on("click", function (e) {
    e.stopPropagation();
    toggleModal();
  });

/*
  $("body").on("click", ".add", function () {
    $(".modal-container").fadeIn(600);
  });
*/
  $("body").on("click", ".close", function () {
    $(".modal-container").fadeOut(600);
  });

  $("body").on("click", "#ua", function () {
    if (ua) {
      ua = false;
      scene.getObjectByName("model-upper").visible = false;
      $("#ua").css("opacity", "0.5");
    } else {
      ua = true;
      scene.getObjectByName("model-upper").visible = true;
      $("#ua").css("opacity", "1");
    }
  });

  $("body").on("click", "#la", function () {
    if (la) {
      la = false;
      scene.getObjectByName("model-lower").visible = false;
      $("#la").css("opacity", "0.5");
    } else {
      la = true;
      scene.getObjectByName("model-lower").visible = true;
      $("#la").css("opacity", "1");
    }
  });

  $("body").on("click", ".pdf", function (e) {
    e.preventDefault();
    var pdf = $(this).attr("data-url");
    window.open(pdf);
  });
});
