// DNS 类型映射配置
window.DNS_CONFIG = {
  Dnspod: { name: '腾讯云', badge: 'layui-badge-blue' },
  hydns: { name: '幻影DNS', badge: 'layui-badge-blue' },
  pxxdns: { name: '派小星DNS', badge: 'layui-badge-blue' },
  DnsAli: { name: '阿里云', badge: 'layui-badge-blue' },
  Huawei: { name: '华为云', badge: 'layui-badge-blue' },
  dnsla: { name: 'DNSLA', badge: 'layui-badge-blue' },
  baidu: { name: '百度云', badge: 'layui-badge-blue' },
  cloudflare: { name: 'cloudflare', badge: 'layui-badge-blue' },
  huoshan: { name: '火山引擎', badge: 'layui-badge-blue' },
  west: { name: '西部数码', badge: 'layui-badge-blue' },
  spdns: { name: '迅风DNS', badge: 'layui-badge-blue' },
  ccdns: { name: '彩虹聚合', badge: 'layui-badge-blue' }
};

// 通用渲染函数
window.renderDnsType = function(dnsKey) {
  const config = window.DNS_CONFIG[dnsKey];
  if (config) {
    return `<span class="layui-badge ${config.badge}">${config.name}</span>`;
  }
  return `<span class="layui-badge layui-badge-blue">${dnsKey || '未知'}</span>`;
};

// 2. 获取中文名称（纯文本）
window.getDnsName = function(dnsKey) {
    const config = window.DNS_CONFIG[dnsKey];
    return config ? config.name : dnsKey;
};
