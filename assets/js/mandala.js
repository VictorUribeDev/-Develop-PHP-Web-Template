const canvas = document.getElementById('mandalaCanvas');
const ctx = canvas.getContext('2d');

// Configuración inicial del canvas
function resizeCanvas() {
    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientWidth;
}
resizeCanvas();

const width = canvas.width;
const height = canvas.height;

// Variables del mandala
const centerX = width / 2;
const centerY = height / 2;
const maxRadius = Math.min(width, height) / 2 - 10;
const numPoints = 24; // Más puntos para suavidad
const numLayers = 50; // Capas del mandala
const speed = 0.02; // Velocidad de dibujo más lenta
let currentLayer = 0;
let transitionProgress = 0; // Progreso de transición entre capas
let isReversing = false;

// Función para calcular el gradiente dinámico del fondo
function drawBackground() {
    let gradient = ctx.createLinearGradient(0, 0, 0, height);
    gradient.addColorStop(0, "rgba(240, 240, 255, 1)");
    gradient.addColorStop(1, "rgb(68, 68, 68)");
    ctx.fillStyle = gradient;
    ctx.fillRect(0, 0, width, height);
}

// Función para calcular los puntos 3D del mandala
function calculate3DPoints(layer, progress = 1) {
    const points = [];
    const stepAngle = (Math.PI * 2) / numPoints;

    for (let i = 0; i < numPoints; i++) {
        const angle = i * stepAngle;
        const distortion = Math.sin(angle * 6) * 0.3;
        const radius = (layer + progress) * (maxRadius / numLayers);
        const depth = Math.cos(angle + transitionProgress * speed) * 10; // Profundidad ajustada

        const finalRadius = radius + distortion * radius;
        points.push({
            x: centerX + finalRadius * Math.cos(angle) + depth,
            y: centerY + finalRadius * Math.sin(angle) + depth,
            depth,
        });
    }

    return points;
}

// Función para obtener el color de cada capa
function getColor(layer) {  
    const grayValue = 50 - (layer * (100 / numLayers)); // Escala de grises  
    return `hsl(0, 0%, ${grayValue}%)`;  
}

// Función para dibujar el mandala
function draw3DMandala() {
    drawBackground(); // Dibujar el fondo
    ctx.lineWidth = 2;

    for (let layer = 0; layer < currentLayer; layer++) {
        const points = calculate3DPoints(layer);

        for (let i = 0; i < points.length; i++) {
            const start = points[i];
            const end = points[(i + 1) % points.length];

            ctx.strokeStyle = getColor(layer);
            ctx.beginPath();
            ctx.moveTo(start.x, start.y);
            ctx.lineTo(end.x, end.y);
            ctx.stroke();
        }
    }

    const progressPoints = calculate3DPoints(currentLayer, isReversing ? 1 - transitionProgress : transitionProgress);

    for (let i = 0; i < progressPoints.length; i++) {
        const start = progressPoints[i];
        const end = progressPoints[(i + 1) % progressPoints.length];

        ctx.strokeStyle = getColor(currentLayer);
        ctx.beginPath();
        ctx.moveTo(start.x, start.y);
        ctx.lineTo(end.x, end.y);
        ctx.stroke();
    }

    transitionProgress += speed;
    if (transitionProgress >= 1) {
        transitionProgress = 0;
        currentLayer += isReversing ? -1 : 1;
        if (currentLayer >= numLayers || currentLayer <= 0) {
            isReversing = !isReversing;
        }
    }

    requestAnimationFrame(draw3DMandala);
}

// Iniciar animación
draw3DMandala();

// Ajustar tamaño en cambios de ventana
window.addEventListener('resize', () => {
    resizeCanvas();
    draw3DMandala();
});
