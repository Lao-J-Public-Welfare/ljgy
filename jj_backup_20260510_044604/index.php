<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>⏳ 牢J公益 · 超级倒计时</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    background: linear-gradient(135deg, #0a0a2e 0%, #1a0030 30%, #0a0a2e 70%, #000022 100%);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Orbitron', 'Courier New', monospace;
    overflow: hidden;
    position: relative;
}
/* 粒子背景 */
#particles {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    pointer-events: none;
    z-index: 0;
}
.particle {
    position: absolute;
    border-radius: 50%;
    animation: float linear infinite;
}
@keyframes float {
    0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
}
.container {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 20px;
}
.glass-box {
    background: rgba(0, 0, 0, 0.6);
    border: 2px solid rgba(255, 0, 128, 0.4);
    border-radius: 24px;
    padding: 50px 40px;
    backdrop-filter: blur(20px);
    box-shadow: 
        0 0 60px rgba(255, 0, 128, 0.15),
        0 0 120px rgba(0, 255, 255, 0.05),
        inset 0 0 60px rgba(255, 0, 128, 0.05);
    position: relative;
    overflow: hidden;
    max-width: 900px;
    width: 95%;
}
.glass-box::before {
    content: '';
    position: absolute;
    top: -2px; left: -2px; right: -2px; bottom: -2px;
    background: conic-gradient(
        from 0deg,
        #ff0080,
        #00ffff,
        #ff0080,
        #00ffff,
        #ff0080
    );
    border-radius: 26px;
    z-index: -1;
    animation: spinBorder 6s linear infinite;
}
@keyframes spinBorder {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.badge {
    display: inline-block;
    background: linear-gradient(90deg, #ff0080, #ff6600);
    color: white;
    padding: 6px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 2px;
    margin-bottom: 20px;
    box-shadow: 0 0 20px rgba(255, 0, 128, 0.5);
    font-family: 'Courier New', monospace;
}
.title {
    color: white;
    font-size: 22px;
    font-weight: 900;
    letter-spacing: 6px;
    margin-bottom: 10px;
    text-shadow: 0 0 30px rgba(255, 0, 128, 0.3);
    font-family: 'Orbitron', monospace;
}
.subtitle {
    color: rgba(255, 255, 255, 0.4);
    font-size: 14px;
    letter-spacing: 3px;
    margin-bottom: 40px;
    font-family: 'Courier New', monospace;
}
/* 大倒计时 */
.countdown-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}
.countdown-item {
    text-align: center;
}
.countdown-number {
    font-size: 72px;
    font-weight: 900;
    background: linear-gradient(180deg, #ff0080, #ff6600);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: none;
    filter: drop-shadow(0 0 20px rgba(255, 0, 128, 0.3));
    line-height: 1;
    font-family: 'Orbitron', monospace;
    transition: all 0.3s;
}
.countdown-label {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.4);
    letter-spacing: 4px;
    margin-top: 10px;
    text-transform: uppercase;
    font-family: 'Courier New', monospace;
}
.separator {
    font-size: 60px;
    font-weight: 900;
    color: #ff0080;
    text-shadow: 0 0 20px rgba(255, 0, 128, 0.5);
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: blink 1s step-end infinite;
    font-family: 'Orbitron', monospace;
}
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.2; }
}
/* 进度条 */
.progress-container {
    margin: 30px 0;
}
.progress-bar-bg {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    height: 6px;
    overflow: hidden;
    position: relative;
}
.progress-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #ff0080, #ff6600, #ff0080);
    background-size: 200% 100%;
    border-radius: 20px;
    animation: shimmer 3s linear infinite;
    transition: width 1s ease;
}
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
.progress-text {
    color: rgba(255, 255, 255, 0.3);
    font-size: 12px;
    margin-top: 10px;
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
}
/* 底部信息 */
.footer {
    margin-top: 30px;
    color: rgba(255, 255, 255, 0.2);
    font-size: 11px;
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
}
.footer span {
    color: #ff0080;
    text-shadow: 0 0 10px rgba(255, 0, 128, 0.3);
}
/* 彩蛋按钮 */
.easter-egg {
    margin-top: 20px;
    opacity: 0.3;
    transition: all 0.3s;
    cursor: pointer;
}
.easter-egg:hover {
    opacity: 1;
}
.easter-egg:active .countdown-number {
    animation: explode 0.5s ease;
}
@keyframes explode {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); filter: brightness(2); }
    100% { transform: scale(1); }
}
/* 响应式 */
@media (max-width: 600px) {
    .countdown-number { font-size: 40px; }
    .separator { font-size: 30px; }
    .glass-box { padding: 30px 20px; }
    .title { font-size: 16px; letter-spacing: 3px; }
    .countdown-grid { gap: 8px; }
}
@media (max-width: 400px) {
    .countdown-number { font-size: 28px; }
    .separator { font-size: 20px; }
}
</style>
</head>
<body>

<div id="particles"></div>

<div class="container">
    <div class="glass-box">
        <div class="badge">⚡ 牢 J 公 益 · 特 供 ⚡</div>
        <div class="title">✦ 超 级 倒 计 时 ✦</div>
        <div class="subtitle">距离某个神秘时刻还有...</div>

        <div class="countdown-grid" id="countdown">
            <div class="countdown-item">
                <div class="countdown-number" id="days">00</div>
                <div class="countdown-label">天</div>
            </div>
            <div class="separator">:</div>
            <div class="countdown-item">
                <div class="countdown-number" id="hours">00</div>
                <div class="countdown-label">时</div>
            </div>
            <div class="separator">:</div>
            <div class="countdown-item">
                <div class="countdown-number" id="minutes">00</div>
                <div class="countdown-label">分</div>
            </div>
            <div class="separator">:</div>
            <div class="countdown-item">
                <div class="countdown-number" id="seconds">00</div>
                <div class="countdown-label">秒</div>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" id="progressBar"></div>
            </div>
            <div class="progress-text">
                已过去 <span id="elapsed">0</span> 小时 · 总共 20,000,000 小时
            </div>
        </div>

        <div class="footer">
            ❖ 与你一起 <span>等</span> 到天荒地老 ❖<br>
            <span style="font-size:10px;opacity:0.5;">点击数字有彩蛋</span>
        </div>
    </div>
</div>

<script>
// 目标时间：当前时间 + 20000000小时
// 使用PHP生成确切的JS目标时间
const targetDate = new Date('<?php 
    $now = new DateTime('now', new DateTimeZone('Asia/Shanghai'));
    $target = clone $now;
    $target->modify('+20000000 hours');
    echo $target->format('Y-m-d\TH:i:s');
?>+08:00');

const totalHours = 20000000;
const totalMs = totalHours * 3600 * 1000;
const startMs = targetDate.getTime() - totalMs;

function updateCountdown() {
    const now = new Date().getTime();
    const distance = targetDate.getTime() - now;
    
    if (distance < 0) {
        document.getElementById('days').textContent = '00';
        document.getElementById('hours').textContent = '00';
        document.getElementById('minutes').textContent = '00';
        document.getElementById('seconds').textContent = '00';
        document.getElementById('elapsed').textContent = totalHours.toLocaleString();
        document.getElementById('progressBar').style.width = '100%';
        return;
    }
    
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById('days').textContent = String(days).padStart(2, '0');
    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    
    // 已过去的小时数
    const elapsedMs = now - startMs;
    const elapsedHours = Math.floor(elapsedMs / (3600 * 1000));
    document.getElementById('elapsed').textContent = elapsedHours.toLocaleString();
    
    // 进度条
    const progress = Math.min((elapsedMs / totalMs) * 100, 100);
    document.getElementById('progressBar').style.width = progress + '%';
}

// 粒子效果
function createParticles() {
    const container = document.getElementById('particles');
    const colors = ['#ff0080', '#00ffff', '#ff6600', '#ff00ff', '#00ff88'];
    
    for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        const size = Math.random() * 4 + 2;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        particle.style.boxShadow = '0 0 ' + (size * 2) + 'px ' + particle.style.background;
        particle.style.animationDuration = (Math.random() * 15 + 10) + 's';
        particle.style.animationDelay = (Math.random() * 15) + 's';
        container.appendChild(particle);
    }
}

// 点击彩蛋
document.querySelectorAll('.countdown-number').forEach(el => {
    el.addEventListener('click', function() {
        this.style.transform = 'scale(1.3)';
        this.style.filter = 'brightness(2)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
            this.style.filter = 'none';
        }, 300);
    });
});

createParticles();
updateCountdown();
setInterval(updateCountdown, 1000);

// 控制台彩蛋
console.log('%c⏳ 20000000小时倒计时 ⏳', 'font-size:24px; color:#ff0080; text-shadow: 0 0 20px #ff0080;');
console.log('%cJONGN 等得起！', 'font-size:18px; color:#00ffff;');
console.log('%c人民万岁！', 'font-size:14px; color:#ff6600;');
</script>

</body>
</html>