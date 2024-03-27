const loadImageButton = document.getElementById('load-image-to-source');
const replicaCanvasBG = document.getElementById('canvas-replica-loaded-image');

loadImageButton.addEventListener( 'click' , function(){

    const img = document.getElementById('source-image');

    const source = document.getElementById('canvas-source');
    const sourcectx = source.getContext('2d');
    sourcectx.drawImage( img , 0, 0 );

    replicaCanvasBG.style.backgroundImage = `url('${img.getAttribute('src')}')` ;
    
})


const canvases = document.getElementsByClassName('gameCanvas');
const sourceCanvas = document.getElementById('canvas-source');
const replicaCanvas = document.getElementById('canvas-replica');
// const replicaCanvasBG = document.getElementById('canvas-replica-loaded-image');

const eraseCanvasesButton = document.getElementById('tool-erase-canvases');
// const saveSourceCanvasButton = document.getElementById('tool-save-source');
// const saveReplicaCanvasButton = document.getElementById('tool-save-replica');
const compareCanvasesButton = document.getElementById('tool-compare-canvases');
const overlapOutput = document.getElementById('tool-output-overlap');
const demo = document.getElementById('comparison__canvas')
const comparison_1 = document.getElementById('comparison__canvas_1');
const comparison_1_resized = document.getElementById('comparison__canvas_1_resized');
const comparison_2 = document.getElementById('comparison__canvas_2');
const comparison_2_resized = document.getElementById('comparison__canvas_2_resized');

// Drawing
const width = 30;

const canvasInit = ( el ) => {
    const width = el.offsetWidth;
    const height = el.offsetHeight;

    el.setAttribute( 'width' , width );
    el.setAttribute( 'height' , height );
}

const canvasesStatus = {};
let coord = {x:0 , y:0};
let paint = false;

const getPosition = ( canvas , e ) =>{
    coord.x = e.clientX - canvas.offsetLeft;
    coord.y = e.clientY - canvas.offsetTop;
}
const getPositionTouch = ( canvas , e ) =>{
    e.preventDefault();
    e.stopPropagation();
    const touch = e.touches[0]
    coord.x = touch.clientX - ( canvas.offsetLeft - window.scrollX );
    coord.y = touch.clientY - ( canvas.offsetTop - window.scrollY );
}
    
const startPainting = ( canvas , e , method ) => {
    paint = true;
    method == 'touch' ? getPositionTouch( canvas , e ) : getPosition( canvas , e );
}

const stopPainting = () =>{
    paint = false;
}

const sketch = ( canvas , e , method ) => {
    if (!paint) return;
    ctx = canvas.getContext('2d');
    ctx.beginPath();
    ctx.lineWidth = width;
    ctx.lineCap = 'round';
    ctx.strokeStyle = 'black';
    ctx.moveTo(coord.x, coord.y);
    method == 'touch' ? getPositionTouch( canvas , e ) : getPosition( canvas , e );
    ctx.lineTo(coord.x , coord.y);
    ctx.stroke();
}

for (let i = 0; i < canvases.length; i++) {

    canvasInit( canvases[i] );
    
    canvases[i].addEventListener('mousedown', (e) => {
        startPainting( canvases[i] , e , 'mouse');
    });
    canvases[i].addEventListener('pointerup', stopPainting);
    canvases[i].addEventListener('pointerout', stopPainting);
    canvases[i].addEventListener('touchcancel', stopPainting);
    canvases[i].addEventListener('mousemove', (e) => {
        sketch( canvases[i] , e , 'mouse' )
    });
    canvases[i].addEventListener('touchstart', (e) => {
        startPainting( canvases[i] , e , 'touch' );
    });
    canvases[i].addEventListener('touchmove', (e) => {
        sketch( canvases[i] , e , 'touch')
    });

}

const processCanvas = ( canvas ) =>{

    console.log("hello world");
    const ctx = canvas.getContext('2d');
    const ctxData = ctx.getImageData( 0 , 0 , canvas.width , canvas.height ).data;

    let counter = 0;
    const pixels = Array.from(ctxData).filter(() => {
        if (counter === 3) {
            counter = 0;
            return true;
        }
        counter++;
        return false;
    });
    
    let top = null , bottom = null , left = canvas.width , right = 0;
    
    for (y = 0; y < pixels.length - canvas.width; y += canvas.width) {
        const row = pixels.slice(y, y + canvas.width);
        if (row.some(pixel => pixel > 0)) {
            if (top === null)
            top = y == 0 ? 0 : y / canvas.width;
            bottom = y / canvas.width;
                
            let leftmost = null;
            let rightmost = null;
            for (x = 0; x < row.length; x++) {
            if (!!row[x]) {
                if (leftmost === null)
                leftmost = x;
                rightmost = x;
            }
            }
            
            if (leftmost < left) left = leftmost;
            if (rightmost > right) right = rightmost;
        }
    }

    const width = right - left;
    const height = bottom - top;

    // ctx.lineWidth = 5;
    // ctx.beginPath();
    // ctx.rect( left, top, width, height );
    // ctx.stroke();

    return {
        left: left,
        top: top,
        width: width,
        height: height
    };

}

const eraseCanvases = () =>{
    for (let i = 0; i < canvases.length; i++) {
        const ctx = canvases[i].getContext('2d');
        ctx.clearRect( 0 , 0 , canvases[i].offsetWidth , canvases[i].offsetHeight );
    }
    overlapOutput.textContent = '';
    demo.innerHTML = '';
    replicaCanvasBG.style.backgroundImage = '';
}

const compareCanvases = ( source , replica , source1 , replica1 ) => {

    const comparison1CTX = comparison_1.getContext('2d');
    const comparison1CTXFinal = comparison_1_resized.getContext('2d');
    const comparison2CTX = comparison_2.getContext('2d');
    const comparison2CTXFinal = comparison_2_resized.getContext('2d');


    // const imageSource = source.getContext('2d').getImageData( source1.left, source1.top, source1.width, source1.height );
    const imageSource = source.getContext('2d');
    const imageSourceData = imageSource.getImageData( source1.left, source1.top , source1.width, source1.height );
    const imageReplica = replica.getContext('2d');
    const imageReplicaData = imageReplica.getImageData( replica1.left, replica1.top , replica1.width, replica1.height );

    comparison1CTX.putImageData(imageSourceData, 0, 0);
    comparison1CTXFinal.scale( 400 / source1.width , 400 / source1.height );
    comparison1CTXFinal.drawImage(comparison_1, 0 , 0 )
    comparison2CTX.putImageData(imageReplicaData, 0, 0);
    comparison2CTXFinal.scale( 400 / replica1.width , 400 / replica1.height );
    comparison2CTXFinal.drawImage(comparison_2, 0 , 0 )


    const canvas1Final = comparison1CTXFinal.getImageData(0, 0, 400, 400).data;
    const canvas2Final = comparison2CTXFinal.getImageData(0, 0, 400, 400).data;

    let samePixels = 0, activePixels = 0 , whitePixels = 0, faultyPixels = 0, mark;

    for (let i = 0; i < canvas1Final.length / 4 ; i++) {


        if( canvas1Final[4 * i + 3] !== 0 ){
            activePixels++

            if( canvas1Final[4 * i + 3] === canvas2Final[4 * i + 3] ){
                samePixels++
            }
            
        } else if( canvas1Final[4 * i + 3] === 0 && canvas2Final[4 * i + 3] !== 0){
            faultyPixels++
        }
        
    }

   
    if( faultyPixels > activePixels ){
        mark = 0;
    } else {
        mark = Math.ceil( ( samePixels / activePixels ) * 100 );
    }

    if( replicaCanvasBG.style.backgroundImage ){

        console.log( 'loaded' );

        if( mark * 1.5 > 100 ){
            mark = Math.ceil( 85 + 13 * Math.random() );
        } else {
            marg = mark * 1.1
        }
        
    }


    overlapOutput.textContent = mark + '%';


    comparison1CTXFinal.scale( source1.width / 400 , source1.height / 400);
    comparison2CTXFinal.scale( replica1.width / 400 , replica1.height / 400);


}

eraseCanvasesButton.addEventListener( 'click' , eraseCanvases);
compareCanvasesButton.addEventListener( 'click' , () => {
    compareCanvases( sourceCanvas , replicaCanvas , processCanvas( sourceCanvas ) , processCanvas( replicaCanvas ) );
});
