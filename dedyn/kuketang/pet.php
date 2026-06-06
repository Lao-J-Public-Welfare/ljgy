<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自定义宠物 · 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: white; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        h1 { color: #c0392b; margin-bottom: 8px; }
        .sub { color: #5a6874; margin-bottom: 20px; font-size: 0.85rem; }
        .pet-display { text-align: center; padding: 20px; background: #f8f9fa; border-radius: 12px; margin-bottom: 20px; }
        .pet-image { width: 120px; height: 120px; object-fit: contain; margin: 0 auto; border-radius: 12px; background: white; border: 1px solid #e0e0e0; }
        .pet-name { font-size: 1.2rem; font-weight: bold; margin-top: 10px; }
        .pet-level { color: #c0392b; font-size: 0.85rem; }
        .pet-score { font-size: 1.5rem; font-weight: bold; margin: 8px 0; }
        .actions { display: flex; flex-wrap: wrap; gap: 8px; margin: 15px 0; }
        .action-btn { background: #2c3e2f; color: white; border: none; padding: 6px 12px; border-radius: 20px; cursor: pointer; font-size: 0.8rem; }
        .action-btn:hover { background: #1e2a21; }
        .action-btn.delete { background: #c0392b; }
        .action-btn.delete:hover { background: #a83226; }
        .add-action { display: flex; gap: 8px; margin-top: 15px; flex-wrap: wrap; align-items: center; }
        .add-action input, .add-action select { padding: 6px 10px; border: 1px solid #ddd; border-radius: 20px; font-size: 0.8rem; }
        .add-action button { background: #2c3e2f; color: white; border: none; padding: 6px 16px; border-radius: 20px; cursor: pointer; }
        .level-section { margin-top: 20px; padding-top: 15px; border-top: 1px solid #eef2f5; }
        .level-title { font-weight: bold; margin-bottom: 10px; }
        .level-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; }
        .level-btn { background: #e0e0e0; border: none; padding: 6px 12px; border-radius: 20px; cursor: pointer; }
        .level-btn.active { background: #c0392b; color: white; }
        .upload-area { margin: 10px 0; }
        .reset-btn { background: #c0392b; margin-top: 15px; }
        .back { display: inline-block; margin-top: 15px; color: #c0392b; text-decoration: none; }
        .action-item { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #f0f0f0; }
        .action-score { font-weight: bold; margin-left: 10px; }
        .action-score.positive { color: #2c5a2e; }
        .action-score.negative { color: #c0392b; }
        .no-pet { text-align: center; padding: 30px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>自定义宠物</h1>
        <div class="sub">上传图片 · 自定义行为 · 20分升级</div>

        <div id="noPet" class="no-pet">
            <p>还没有宠物，创建一只吧！</p>
            <div style="margin-top:15px">
                <input type="text" id="petNameInput" placeholder="宠物名字" style="padding:8px 12px; border:1px solid #ddd; border-radius:20px; margin-right:10px">
                <input type="file" id="petImageInput" accept="image/*" style="margin:10px 0">
                <br>
                <button onclick="createPet()" class="action-btn" style="margin-top:10px">创建宠物</button>
            </div>
        </div>

        <div id="petPanel" style="display:none">
            <div class="pet-display">
                <img id="petImg" class="pet-image" src="">
                <div class="pet-name" id="petName"></div>
                <div class="pet-level" id="petLevel">Lv.1</div>
                <div class="pet-score" id="petScore">0 分</div>
            </div>

            <h3>自定义行为</h3>
            <div id="actionList"></div>
            <div class="add-action">
                <input type="text" id="newActionName" placeholder="行为名称" style="flex:2">
                <select id="newActionType">
                    <option value="add">加分</option>
                    <option value="sub">扣分</option>
                </select>
                <input type="number" id="newActionValue" placeholder="分值" value="1" style="width:60px">
                <button onclick="addAction()">添加</button>
            </div>

            <div class="level-section">
                <div class="level-title">宠物形象 (每级可单独上传)</div>
                <div class="level-buttons" id="levelTabs"></div>
                <div id="levelUploadArea" class="upload-area">
                    <input type="file" id="levelImageInput" accept="image/*" style="display:none">
                    <button class="action-btn" onclick="uploadCurrentLevelImage()">上传当前等级图片</button>
                    <span id="uploadStatus" style="margin-left:10px; font-size:0.8rem; color:#999"></span>
                </div>
            </div>

            <button class="action-btn reset-btn" onclick="resetAll()">重置所有数据</button>
        </div>

        <a href="index.php" class="back">← 返回工具箱</a>
    </div>
</div>
<script>
let petData = null;
let currentLevelView = 1;

function loadData() {
    const saved = localStorage.getItem('customPetV2');
    if (saved) {
        petData = JSON.parse(saved);
        if (!petData.actions) petData.actions = [];
        if (!petData.levelImages) petData.levelImages = {};
        if (!petData.image) petData.image = '';
        if (!petData.name) petData.name = '我的宠物';
        if (typeof petData.score === 'undefined') petData.score = 0;
        if (typeof petData.level === 'undefined') petData.level = 1;
        showPetPanel();
    } else {
        document.getElementById('noPet').style.display = 'block';
        document.getElementById('petPanel').style.display = 'none';
    }
}

function saveData() {
    localStorage.setItem('customPetV2', JSON.stringify(petData));
}

function createPet() {
    const name = document.getElementById('petNameInput').value.trim();
    const fileInput = document.getElementById('petImageInput');
    const file = fileInput.files[0];
    
    if (!name) {
        alert('请输入宠物名字');
        return;
    }
    
    petData = {
        name: name,
        level: 1,
        score: 0,
        actions: [],
        levelImages: {},
        image: ''
    };
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            petData.image = e.target.result;
            petData.levelImages[1] = e.target.result;
            saveData();
            showPetPanel();
        };
        reader.readAsDataURL(file);
    } else {
        saveData();
        showPetPanel();
    }
}

function showPetPanel() {
    document.getElementById('noPet').style.display = 'none';
    document.getElementById('petPanel').style.display = 'block';
    
    document.getElementById('petName').innerText = petData.name;
    updateLevelDisplay();
    renderActions();
    renderLevelTabs();
    loadLevelImagePreview();
}

function updateLevelDisplay() {
    const level = petData.level;
    document.getElementById('petLevel').innerHTML = `Lv.${level}`;
    document.getElementById('petScore').innerHTML = `${petData.score} 分`;
    
    const imgSrc = petData.levelImages[level] || petData.image || '';
    const petImg = document.getElementById('petImg');
    if (imgSrc) {
        petImg.src = imgSrc;
    } else {
        petImg.src = 'data:image/svg+xml,%3Csvg xmlns="http:
    }
}

function checkLevelUp() {
    const newLevel = Math.floor(petData.score / 20) + 1;
    if (newLevel > petData.level) {
        petData.level = newLevel;
        updateLevelDisplay();
        alert(`🎉 恭喜！宠物升级到 Lv.${newLevel}！`);
        renderLevelTabs();
    }
}

function renderActions() {
    const container = document.getElementById('actionList');
    if (!petData.actions || petData.actions.length === 0) {
        container.innerHTML = '<p style="color:#999">暂无行为，添加一个吧</p>';
        return;
    }
    
    container.innerHTML = '';
    petData.actions.forEach((action, idx) => {
        const div = document.createElement('div');
        div.className = 'action-item';
        const scoreClass = action.type === 'add' ? 'positive' : 'negative';
        const scoreSign = action.type === 'add' ? '+' : '-';
        div.innerHTML = `
            <div>
                <strong>${escapeHtml(action.name)}</strong>
                <span class="action-score ${scoreClass}">${scoreSign}${action.value}分</span>
            </div>
            <div>
                <button class="action-btn" onclick="performAction(${idx})">执行</button>
                <button class="action-btn delete" onclick="deleteAction(${idx})">删除</button>
            </div>
        `;
        container.appendChild(div);
    });
}

function addAction() {
    const name = document.getElementById('newActionName').value.trim();
    const type = document.getElementById('newActionType').value;
    const value = parseInt(document.getElementById('newActionValue').value);
    
    if (!name) {
        alert('请输入行为名称');
        return;
    }
    if (isNaN(value) || value <= 0) {
        alert('分值必须是正数');
        return;
    }
    
    if (!petData.actions) petData.actions = [];
    petData.actions.push({ name: name, type: type, value: value });
    saveData();
    renderActions();
    
    document.getElementById('newActionName').value = '';
    document.getElementById('newActionValue').value = '1';
}

function deleteAction(idx) {
    petData.actions.splice(idx, 1);
    saveData();
    renderActions();
}

function performAction(idx) {
    const action = petData.actions[idx];
    let delta = action.value;
    if (action.type === 'sub') delta = -delta;
    
    let newScore = petData.score + delta;
    if (newScore < 0) newScore = 0;
    petData.score = newScore;
    
    saveData();
    updateLevelDisplay();
    checkLevelUp();
}

function renderLevelTabs() {
    const maxLevel = Math.floor(petData.score / 20) + 3;
    const container = document.getElementById('levelTabs');
    container.innerHTML = '';
    for (let i = 1; i <= maxLevel; i++) {
        const btn = document.createElement('button');
        btn.innerText = `Lv.${i}`;
        btn.className = 'level-btn';
        if (i === currentLevelView) btn.classList.add('active');
        btn.onclick = (function(level) { return function() { switchLevel(level); }; })(i);
        container.appendChild(btn);
    }
}

function switchLevel(level) {
    currentLevelView = level;
    renderLevelTabs();
    loadLevelImagePreview();
}

function loadLevelImagePreview() {
    const statusSpan = document.getElementById('uploadStatus');
    const hasImage = petData.levelImages[currentLevelView];
    if (hasImage) {
        statusSpan.innerHTML = '已有图片，可重新上传覆盖';
    } else {
        statusSpan.innerHTML = '暂无图片，请上传';
    }
}

function uploadCurrentLevelImage() {
    const input = document.getElementById('levelImageInput');
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                petData.levelImages[currentLevelView] = ev.target.result;
                if (currentLevelView === petData.level) {
                    document.getElementById('petImg').src = ev.target.result;
                }
                saveData();
                loadLevelImagePreview();
                alert(`Lv.${currentLevelView} 图片已保存`);
            };
            reader.readAsDataURL(file);
        }
    };
    input.click();
}

function resetAll() {
    if (confirm('确定要重置所有数据吗？宠物、行为、图片都会消失。')) {
        localStorage.removeItem('customPetV2');
        location.reload();
    }
}

function escapeHtml(str) {
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

loadData();
</script>
</body>
</html>
