const canvas = document.getElementById('networkCanvas');
const ctx = canvas.getContext('2d');
let width, height;
let firewallEnabled = false;
let ddosEnabled = false;

function getPositions() {
    const w = width, h = height;
    return {
        devices: [
            { name: 'PC-1', x: w * 0.1, y: h * 0.35 },
            { name: 'PC-2', x: w * 0.1, y: h * 0.5 },
            { name: 'PC-3', x: w * 0.1, y: h * 0.65 }
        ],
        gateway: { x: w * 0.38, y: h * 0.5 },
        server: { x: w * 0.85, y: h * 0.5 }
    };
}

function drawLine(p1, p2) {
    ctx.beginPath();
    ctx.moveTo(p1.x, p1.y);
    ctx.lineTo(p2.x, p2.y);
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 1.5;
    ctx.stroke();
}

function draw() {
    if (!width) return;
    const pos = getPositions();
    ctx.clearRect(0, 0, width, height);
    
    for (const dev of pos.devices) {
        drawLine(dev, pos.gateway);
    }
    drawLine(pos.gateway, pos.server);
    
    for (const dev of pos.devices) {
        ctx.beginPath();
        ctx.arc(dev.x, dev.y, 10, 0, Math.PI * 2);
        ctx.fillStyle = 'white';
        ctx.fill();
        ctx.strokeStyle = '#cbd5e1';
        ctx.stroke();
        ctx.fillStyle = '#2c3e2f';
        ctx.font = '12px monospace';
        ctx.textAlign = 'center';
        ctx.fillText(dev.name, dev.x, dev.y - 14);
    }
    
    ctx.beginPath();
    ctx.arc(pos.gateway.x, pos.gateway.y, 12, 0, Math.PI * 2);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.strokeStyle = '#cbd5e1';
    ctx.stroke();
    ctx.fillStyle = '#5a6874';
    ctx.fillText('网关', pos.gateway.x, pos.gateway.y - 14);
    
    ctx.beginPath();
    ctx.arc(pos.server.x, pos.server.y, 14, 0, Math.PI * 2);
    ctx.fillStyle = 'white';
    ctx.fill();
    ctx.strokeStyle = '#c0392b';
    ctx.lineWidth = 2;
    ctx.stroke();
    ctx.fillStyle = '#c0392b';
    ctx.font = 'bold 12px monospace';
    ctx.fillText('服务器', pos.server.x, pos.server.y - 16);
    
    if (firewallEnabled) {
        ctx.beginPath();
        ctx.rect(pos.gateway.x - 30, pos.gateway.y - 18, 60, 36);
        ctx.fillStyle = 'rgba(100, 100, 100, 0.3)';
        ctx.fill();
        ctx.strokeStyle = '#9aaebf';
        ctx.stroke();
        ctx.fillStyle = '#7c8b9c';
        ctx.font = '11px monospace';
        ctx.fillText('防火墙', pos.gateway.x, pos.gateway.y + 4);
    }
    
    requestAnimationFrame(draw);
}

async function fetchAccessCount() {
    try {
        const res = await fetch('/traffic.php');
        const data = await res.json();
        document.getElementById('accessCount').innerText = data.access_count;
    } catch(e) { console.error(e); }
}

function resizeCanvas() {
    width = window.innerWidth;
    height = window.innerHeight - 60;
    canvas.width = width;
    canvas.height = height;
    draw();
}

document.getElementById('firewallToggle').addEventListener('click', () => {
    firewallEnabled = !firewallEnabled;
    document.getElementById('firewallToggle').classList.toggle('active', firewallEnabled);
});

document.getElementById('ddosToggle').addEventListener('click', () => {
    ddosEnabled = !ddosEnabled;
    document.getElementById('ddosToggle').classList.toggle('active', ddosEnabled);
});

window.addEventListener('resize', resizeCanvas);
resizeCanvas();
setInterval(fetchAccessCount, 3000);
fetchAccessCount();
