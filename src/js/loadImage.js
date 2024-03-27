const loadImageButton = document.getElementById('load-image-to-source');
const replicaCanvasBG = document.getElementById('canvas-replica-loaded-image');

loadImageButton.addEventListener( 'click' , function(){

    const img = document.getElementById('source-image');

    const source = document.getElementById('canvas-source');
    const sourcectx = source.getContext('2d');
    sourcectx.drawImage( img , 0, 0 );

    replicaCanvasBG.style.backgroundImage = `url('${img.getAttribute('src')}')` ;
    
})