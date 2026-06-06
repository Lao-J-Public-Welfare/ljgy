<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>课堂计时器 · xyydz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 24px; padding: 40px; max-width: 600px; width: 100%; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { color: #c0392b; margin-bottom: 8px; }
        .sub { color: #5a6874; margin-bottom: 24px; font-size: 0.85rem; }
        .time-display { font-size: 4rem; font-weight: bold; font-family: monospace; margin: 20px 0; color: #1e2a3a; }
        input { font-size: 1rem; padding: 8px; width: 100px; text-align: center; border: 1px solid #ddd; border-radius: 8px; margin: 10px; }
        .btn { background: #2c3e2f; color: white; border: none; padding: 10px 20px; border-radius: 30px; font-size: 0.9rem; cursor: pointer; margin: 5px; }
        .btn:hover { background: #1e2a21; }
        .btn-red { background: #c0392b; }
        .btn-red:hover { background: #a83226; }
        .back { margin-top: 20px; display: inline-block; color: #c0392b; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h1>课堂计时器</h1>
    <div class="sub">倒计时 / 正计时</div>
    <div class="time-display" id="timerDisplay">00:00</div>
    <div>
        <input type="number" id="minutes" placeholder="分钟" value="1" min="0">
        <input type="number" id="seconds" placeholder="秒" value="0" min="0" max="59">
    </div>
    <div>
        <button class="btn" onclick="startCountdown()">开始倒计时</button>
        <button class="btn" onclick="startStopwatch()">开始正计时</button>
        <button class="btn btn-red" onclick="stopTimer()">停止</button>
        <button class="btn" onclick="resetTimer()">重置</button>
    </div>
    <a href="index.php" class="back">← 返回工具箱</a>
</div>
<script>
let timerInterval = null;
let totalSeconds = 0;

function updateDisplay() {
    const mins = Math.floor(totalSeconds / 60);
    const secs = totalSeconds % 60;
    document.getElementById('timerDisplay').innerHTML = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

function startCountdown() {
    stopTimer();
    const mins = parseInt(document.getElementById('minutes').value) || 0;
    const secs = parseInt(document.getElementById('seconds').value) || 0;
    totalSeconds = mins * 60 + secs;
    if (totalSeconds <= 0) return;
    updateDisplay();
    timerInterval = setInterval(() => {
        if (totalSeconds <= 0) {
            stopTimer();
            alert('时间到！');
        } else {
            totalSeconds--;
            updateDisplay();
        }
    }, 1000);
}

function startStopwatch() {
    stopTimer();
    totalSeconds = 0;
    updateDisplay();
    timerInterval = setInterval(() => {
        totalSeconds++;
        updateDisplay();
    }, 1000);
}

function stopTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function resetTimer() {
    stopTimer();
    totalSeconds = 0;
    updateDisplay();
}
</script>
</body>
</html>
