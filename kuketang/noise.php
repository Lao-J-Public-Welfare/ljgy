<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>课堂噪声仪 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 24px; padding: 40px; max-width: 600px; width: 100%; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { color: #c0392b; margin-bottom: 8px; }
        .sub { color: #5a6874; margin-bottom: 24px; font-size: 0.85rem; }
        .meter { width: 100%; height: 30px; background: #eee; border-radius: 15px; overflow: hidden; margin: 20px 0; }
        .meter-fill { height: 100%; width: 0%; background: #2c3e2f; transition: width 0.1s; }
        .status { font-size: 1.2rem; margin: 10px 0; }
        .btn { background: #2c3e2f; color: white; border: none; padding: 10px 20px; border-radius: 30px; font-size: 0.9rem; cursor: pointer; margin: 5px; }
        .btn:hover { background: #1e2a21; }
        .back { margin-top: 20px; display: inline-block; color: #c0392b; text-decoration: none; }
        .warning { color: #c0392b; }
    </style>
</head>
<body>
<div class="card">
    <h1>课堂噪声仪</h1>
    <div class="sub">检测课堂音量 · 自动提醒安静</div>
    <div class="meter">
        <div class="meter-fill" id="meterFill"></div>
    </div>
    <div class="status" id="status">等待授权</div>
    <button class="btn" onclick="startListening()">开始检测</button>
    <a href="index.php" class="back">← 返回工具箱</a>
</div>
<script>
let audioContext = null;
let source = null;
let isListening = false;

function startListening() {
    if (isListening) return;
    if (!audioContext) {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
    }
    
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            source = audioContext.createMediaStreamSource(stream);
            const analyser = audioContext.createAnalyser();
            analyser.fftSize = 256;
            source.connect(analyser);
            
            const dataArray = new Uint8Array(analyser.frequencyBinCount);
            
            isListening = true;
            
            function updateMeter() {
                if (!isListening) return;
                analyser.getByteFrequencyData(dataArray);
                let average = 0;
                for (let i = 0; i < dataArray.length; i++) {
                    average += dataArray[i];
                }
                average /= dataArray.length;
                let percent = (average / 255) * 100;
                percent = Math.min(100, percent);
                document.getElementById('meterFill').style.width = percent + '%';
                
                const statusDiv = document.getElementById('status');
                if (percent < 20) {
                    statusDiv.innerHTML = '安静 🤫';
                    document.getElementById('meterFill').style.background = '#2c3e2f';
                } else if (percent < 50) {
                    statusDiv.innerHTML = '正常 📢';
                    document.getElementById('meterFill').style.background = '#f39c12';
                } else {
                    statusDiv.innerHTML = '太吵了！请安静 🔔';
                    document.getElementById('meterFill').style.background = '#c0392b';
                }
                
                requestAnimationFrame(updateMeter);
            }
            
            updateMeter();
            audioContext.resume();
        })
        .catch(err => {
            document.getElementById('status').innerHTML = '无法获取麦克风权限';
        });
}

function stopListening() {
    isListening = false;
    if (source) {
        source.disconnect();
    }
    document.getElementById('status').innerHTML = '已停止';
    document.getElementById('meterFill').style.width = '0%';
}
</script>
</body>
</html>
