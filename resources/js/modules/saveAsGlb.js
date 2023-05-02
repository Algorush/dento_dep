export default () => {
  document.querySelector('input[name="upper_files_files_names"]').addEventListener('onchange', saveAsGlb)
  document.querySelector('input[name="lower_files_files_names"]').addEventListener('onchange', saveAsGlb)

  function saveAsGlb(evt) {
    evt.preventDefault()
    console.log(evt) 
  }

  const { DRACOExporter } = import("three.js/examples/jsm/exporters/DRACOExporter.js");
  const { OBJLoader } = import("three.js/examples/jsm/loaders/OBJLoader.cjs");

  console.log(OBJLoader)

  function saveArrayBuffer( buffer, filename ) {

      save( new Blob( [ buffer ], { type: 'application/octet-stream' } ), filename );

  }

  function save( blob, filename ) {
      var buf = new Buffer(blob, 'base64'); // decode
      fs.writeFile(filename, buf, function(err) {
        if(err) {
          console.log("err", err);
        } else {
          return res.json({'status': 'success'});
        }
      }); 
  }

  // instantiate a loader
  const loader = new OBJLoader();

  // load a resource
  loader.load(
    // resource URL
    options.input,
    // called when resource is loaded
    function ( object ) {
          console.log(object)
      //scene.add( object );
          // Instantiate a exporter
          /*
          const exporter = new GLTFExporter();

          // Parse the input and generate the glTF output
          exporter.parse(
              object,
              // called when the gltf has been generated
              function ( gltf ) {

                  console.log( gltf );
                  saveArrayBuffer( gltf, filename );

              },
              // called when there is an error in the generation
              function ( error ) {

                  console.log( 'An error happened' );

              },
              options
          );
          */

    },
    // called when loading is in progresses
    function ( xhr ) {

      console.log( ( xhr.loaded / xhr.total * 100 ) + '% loaded' );

    },
    // called when loading has errors
    function ( error ) {

      console.log( 'An error happened' );

    }
  );
};