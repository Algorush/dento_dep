import * as THREE from '../../../js/three.js';
import { Buffer } from 'buffer';
import { DRACOExporter } from './DRACOExporter.js';
import { OBJLoader } from './OBJLoader.js' ;
import { PLYLoader } from './PLYLoader.js' ;

async function loadOBJLoader() {
  if (!OBJLoader) {
    var {OBJLoader} = await import('./OBJLoader.js');
  }
  return new OBJLoader();
}

async function loadPLYLoader() {
  if (!PLYLoader) {
    var {PLYLoader} = await import('./PLYLoader.js');
  }
  return new PLYLoader();
}

function saveArrBuffAsFile( buffer, filename ) {
  return new File( [ buffer ], filename, { type: 'application/octet-stream' } );
}

function saveArrBuffAsBlob( buffer, filename ) {
  return new File( [ buffer ], filename, { type: 'application/octet-stream' } );
}

function _base64ToArrayBuffer(base64) {
  const binary_string = window.atob(base64);
  const len = binary_string.length;
  let bytes = new Uint8Array(len);
  for (let i = 0; i < len; i++) {
      bytes[i] = binary_string.charCodeAt(i);
  }
  return bytes.buffer;
}

// for PLY files
function fileText(contents) {
  return new Blob( [ 
    _base64ToArrayBuffer(contents) 
    ], { type: 'application/octet-stream' } );
}

function centerObjByXY(centeredObj) {
  // center object only by X and Y axises
  const cent = new THREE.Vector3();
  const size = new THREE.Vector3();
  //const bbox = new THREE.Box3().setFromObject(centeredObj);
  centeredObj.computeBoundingBox();
  const bbox = centeredObj.boundingBox;
  bbox.getCenter(cent);
  bbox.getSize(size);

  //Rescale the object to normalized space
  const maxAxis = Math.max(size.x, size.y, size.z);
  centeredObj.scale.multiplyScalar(1.0 / maxAxis);

  //Now get the updated/scaled bounding box again..
  bbox.setFromObject(centeredObj);
  bbox.getCenter(cent);
  bbox.getSize(size);

  centeredObj.position.x = -cent.x;
  centeredObj.position.y = 0;
  centeredObj.position.z = -cent.z;
}

export async function saveAsGlb(filePondFile) {
  let loader;
  let contents;
  let object;
  let fileObj;
  if (filePondFile.file instanceof File) {
    fileObj = filePondFile.file;
  } else if (filePondFile.source instanceof File) {
    fileObj = filePondFile.source;
  }
  const fileExt = filePondFile.fileExtension.toLowerCase();
  console.log(filePondFile.file instanceof File, filePondFile.source instanceof File, filePondFile.file.arrayBuffer)

  if (fileExt == 'obj') {

    loader = new OBJLoader();
    if (!fileObj.text) {
      console.log(fileObj)
      return undefined;
    }
    contents = await fileObj.text(); 
    const result = loader.parse( contents );
    object = result.children[0];

  } else if (fileExt == 'ply') {

    loader = new PLYLoader();
    //fileObj = await filePondFile.file;
    //if (file.file.arrayBuffer) {

      contents = await fileObj.arrayBuffer();
      object = loader.parse( contents );
    //} else {
    //  return;
    //}

    object.computeVertexNormals();
    //centerObjByXY(object);
    //object.center();

  }

  const exporter = new DRACOExporter();

  const options = {
    decodeSpeed: 5,
    encodeSpeed: 5,
    encoderMethod: DRACOExporter.MESH_EDGEBREAKER_ENCODING,
    quantization: [ 16, 8, 8, 8, 8 ],
    exportUvs: false,
    exportNormals: true,
    exportColor: true
  };

  const newFilename = filePondFile.filenameWithoutExtension + '.drc';

  const gltf = await exporter.parse(
      object, options
  );

/*  let drcFile;

  if (fileExt == 'ply') {
    drcFile = saveArrBuffAsFile( gltf, newFilename );
  } else if (fileExt == 'obj') {
    drcFile = saveArrBuffAsBlob( gltf, newFilename );
  }*/

  const drcFile = saveArrBuffAsFile( gltf, newFilename );

  return drcFile;

}   
