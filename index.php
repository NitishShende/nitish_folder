<?php 
include 'db.php';
if(!isset($_SESSION['user_id'])) { 
    header("Location: auth.php"); 
    exit(); 
}
$user_display_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Hub Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { accent: '#7c3aed', 'accent-2': '#06b6d4', surface: 'var(--surface)', bg: 'var(--bg)' }
                }
            }
        }
    </script>

    <style>
        :root { --bg: #f8fafc; --surface: #ffffff; --text: #0f172a; --line: rgba(0,0,0,.05); }
        .dark { --bg: #020617; --surface: #0f172a; --text: #f1f5f9; --line: rgba(255,255,255,.05); }
        
        html, body { height: 100%; margin: 0; }
        body { 
            display: flex; flex-direction: column;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg); color: var(--text);
            background-image: radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.08) 0, transparent 50%), 
                              radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.08) 0, transparent 50%);
            transition: background-color 0.3s ease;
        }
        .main-content { flex: 1 0 auto; }
        
        .glass { 
            background: var(--surface); 
            backdrop-filter: blur(12px); 
            border: 1px solid var(--line); 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass::before {
            content: ""; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.05) 0%, transparent 70%);
            opacity: 0; transition: opacity 0.5s ease; pointer-events: none;
        }

        .glass:hover::before { opacity: 1; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(124, 58, 237, 0.2); border-color: rgba(124, 58, 237, 0.3); }
        .click-shrink:active { transform: scale(0.96); }
        canvas { filter: drop-shadow(0 0 10px rgba(124, 58, 237, 0.1)); }
    </style>
</head>
<body class="transition-colors duration-300">

<div class="main-content">
    <nav class="sticky top-0 z-50 glass px-4 md:px-[5%] py-4 flex justify-between items-center mb-6 shadow-sm border-b border-accent/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-accent to-accent-2 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">FH</div>
            <span class="font-extrabold text-xl hidden sm:inline tracking-tight text-accent">FinanceHub</span>
        </div>
        <div class="flex gap-1 md:gap-2 font-semibold text-gray-500">
            <span onclick="showPage('dashboard')" class="nav-item active cursor-pointer px-4 py-2 rounded-xl transition-all hover:text-accent hover:bg-accent/10" id="link-dashboard">Dashboard</span>
            <span onclick="showPage('history')" class="nav-item cursor-pointer px-4 py-2 rounded-xl transition-all hover:text-accent hover:bg-accent/10" id="link-history">History</span>
            <span onclick="showPage('budget')" class="nav-item cursor-pointer px-4 py-2 rounded-xl transition-all hover:text-accent hover:bg-accent/10" id="link-budget">Analysis</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="hidden md:inline font-bold text-sm text-accent bg-accent/10 px-4 py-2 rounded-xl border border-accent/20 italic">
                Hello, <?php echo htmlspecialchars($user_display_name); ?>
            </span>
            <button onclick="toggleTheme()" class="p-2 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-all click-shrink text-xl">🌓</button>
            <button onclick="window.location.href='logout.php'" class="text-red-500 border border-red-500/20 px-4 py-2 rounded-xl font-bold text-sm hover:bg-red-500 hover:text-white transition-all click-shrink">Logout</button>
        </div>
    </nav>

    <div class="container mx-auto px-4 max-w-6xl">
        <div id="dashboard" class="page block space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="glass p-6 rounded-[24px] shadow-xl hover-lift border-l-4 border-l-accent">
                        <h2 class="text-lg font-extrabold mb-6 flex items-center gap-2">💰 Financial Overview</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-white/5 shadow-inner">
                                <h4 class="text-xs text-gray-500 font-bold uppercase">Balance</h4>
                                <b id="db-bal" class="text-2xl font-black tracking-tight">₹0</b>
                            </div>
                            <div class="p-4 rounded-2xl bg-green-500/5 border border-green-500/10">
                                <h4 class="text-xs text-green-600/70 font-bold uppercase">Income</h4>
                                <b id="db-inc" class="text-2xl font-black text-green-500">₹0</b>
                            </div>
                            <div class="p-4 rounded-2xl bg-red-500/5 border border-red-500/10">
                                <h4 class="text-xs text-red-600/70 font-bold uppercase">Expense</h4>
                                <b id="db-exp" class="text-2xl font-black text-red-500">₹0</b>
                            </div>
                        </div>
                    </div>
                    <div class="glass p-6 rounded-[24px] shadow-xl hover-lift">
                        <h2 class="text-lg font-extrabold mb-4">📈 Trends</h2>
                        <canvas id="db-chart" class="w-full"></canvas>
                    </div>
                </div>
                
                <div class="lg:col-span-1">
                    <div class="glass p-6 rounded-[24px] shadow-xl hover-lift border-t-4 border-t-accent">
                        <h2 class="text-lg font-extrabold mb-6">✨ Quick Add</h2>
                        <div class="space-y-4">
                            <div><label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</label><input type="date" id="add-date" class="w-full mt-1 p-3 rounded-xl glass outline-none focus:border-accent"></div>
                            <div><label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Type</label><select id="add-type" class="w-full mt-1 p-3 rounded-xl glass outline-none focus:border-accent"><option value="income">🟢 Income (+)</option><option value="expense">🔴 Expense (-)</option></select></div>
                            <div><label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Amount</label><input type="number" id="add-amount" placeholder="0.00" class="w-full mt-1 p-3 rounded-xl glass outline-none focus:border-accent font-black text-accent text-xl"></div>
                            <div><label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Details</label><input type="text" id="add-desc" placeholder="Details" class="w-full mt-1 p-3 rounded-xl glass outline-none focus:border-accent"></div>
                            <div><label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Category</label><select id="add-cat" class="w-full mt-1 p-3 rounded-xl glass outline-none focus:border-accent"><option value="Food">All Category</option><option value="Food">🍔 Food</option><option value="Salary">💰 Salary</option><option value="Rent">🏠 Rent</option><option value="Shopping">🛍️ Shopping</option><option value="Bills">📄 Bills</option><option value="Other">✨ Other</option></select></div>
                            <button onclick="addTransaction()" class="w-full py-4 bg-gradient-to-r from-accent to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 click-shrink transition-all active:shadow-none uppercase text-xs tracking-widest">Save Transaction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="history" class="page hidden">
            <div class="glass p-4 md:p-8 rounded-[24px] shadow-xl space-y-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <h2 class="text-xl font-extrabold">Transaction History</h2>
                    <div class="flex gap-2">
                        <button onclick="clearAllTransactions()" class="px-5 py-2 bg-red-500/10 text-red-500 font-bold rounded-xl text-sm hover:bg-red-500 hover:text-white click-shrink transition-all uppercase tracking-widest">Clear All</button>
                        <button onclick="exportData()" class="px-5 py-2 glass text-gray-500 font-bold rounded-xl text-sm border border-gray-500/20 hover:text-accent hover:border-accent click-shrink transition-all">Export CSV</button>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <select id="filter-type" onchange="render()" class="p-3 rounded-xl glass outline-none"><option value="all">All Types</option><option value="income">Income</option><option value="expense">Expense</option></select>
                    <select id="filter-cat" onchange="render()" class="p-3 rounded-xl glass outline-none"><option value="all">All Categories</option><option value="Food">Food</option><option value="Salary">Salary</option><option value="Rent">Rent</option><option value="Shopping">Shopping</option><option value="Bills">Bills</option><option value="Other">Other</option></select>
                    <input type="month" id="filter-month" onchange="render()" class="p-3 rounded-xl glass outline-none">
                </div>
                <div id="history-list" class="space-y-2 max-h-[600px] overflow-y-auto pr-2"></div>
            </div>
        </div>

        <div id="budget" class="page hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass p-6 rounded-[24px] shadow-xl hover-lift">
                    <h2 class="text-lg font-extrabold mb-6">🎯 Set Budget Limit</h2>
                    <input type="number" id="limit-input" placeholder="e.g. 15000" class="w-full p-4 rounded-xl glass outline-none focus:border-accent font-bold">
                    <button onclick="setBudget()" class="w-full mt-4 py-4 bg-accent text-white font-bold rounded-xl shadow-lg click-shrink">Update Limit</button>
                    <div id="budget-section" class="mt-8 hidden text-center">
                        <div class="flex justify-between font-bold mb-2 text-sm uppercase tracking-widest text-gray-500"><span id="budget-percentage">0%</span></div>
                        <div class="h-3 w-full bg-gray-200 dark:bg-white/10 rounded-full overflow-hidden shadow-inner"><div id="budget-fill" class="h-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(124,58,237,0.5)]"></div></div>
                        <p id="budget-msg" class="mt-4 font-bold text-xs uppercase tracking-widest italic"></p>
                    </div>
                </div>
                <div class="glass p-6 rounded-[24px] shadow-xl hover-lift flex flex-col items-center border-r-4 border-r-accent-2">
                    <h2 class="text-lg font-extrabold mb-6 w-full text-left">🍕 Category Wise</h2>
                    <div class="w-full max-w-[280px]"><canvas id="cat-chart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="glass p-8 rounded-[32px] hover-lift border-b-4 border-accent-2">
                <div class="flex items-center gap-4 mb-4 text-accent-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <h3 class="text-xl font-extrabold">Contact Support</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 font-medium leading-relaxed italic">If you are experiencing any technical issues or would like to speak with our developers, please contact us at the email address provided below. We will respond within 24 hours.</p>
                <a href="mailto:nitishshende57@gmail.com" class="inline-block py-3 px-6 bg-accent-2/10 text-accent-2 font-black rounded-2xl hover:bg-accent-2 hover:text-white transition-all text-xs tracking-widest uppercase">nitishshende57@gmail.com</a>
            </div>

            <div class="glass p-8 rounded-[32px] hover-lift border-b-4 border-accent">
                <div class="flex items-center gap-4 mb-4 text-accent">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <h3 class="text-xl font-extrabold">Privacy & Security</h3>
                </div>
                <p class="text-sm text-gray-500 mb-6 font-medium leading-relaxed italic">Your financial data is our top priority. All your transactions are securely linked to your User ID. We do not sell your data to any third parties.</p>
                <div class="flex gap-4">
                    <a href="privacy.php" class="text-xs font-black uppercase tracking-widest text-accent hover:underline">Read Policy</a>
                    <a href="terms.php" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-accent transition-all">Terms of Use</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-12 glass pt-10 pb-6 rounded-t-[40px] shrink-0 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] dark:shadow-[0_-10px_40px_rgba(0,0,0,0.5)] border-t border-accent/10">
    <div class="max-w-6xl mx-auto px-4 flex flex-col items-center text-center space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-gradient-to-br from-accent to-accent-2 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">FH</div>
            <span class="font-extrabold text-lg text-accent-2 uppercase tracking-tighter">FinanceHub Pro<span class="text-accent">.</span></span>
        </div>
        <p class="text-gray-400 text-[10px] tracking-[0.3em] font-bold opacity-60 uppercase">&copy; <span id="year"></span> Finance Hub Pro. Nitro Visual Engine 2.0</p>
    </div>
</footer>

<div id="toast" class="fixed bottom-6 right-6 glass px-6 py-3 rounded-2xl shadow-2xl z-[100] hidden transition-all duration-300"></div>

<script>
    let transactions = [];
    let budgetLimit = localStorage.getItem('fh_budget') || 0;
    const catIcons = { 'Food': '🍔', 'Salary': '💰', 'Rent': '🏠', 'Shopping': '🛍️', 'Bills': '📄', 'Other': '✨' };
    let myChart = null, catChart = null;

    window.onload = () => {
        document.getElementById('add-date').value = new Date().toISOString().split('T')[0];
        document.getElementById('limit-input').value = budgetLimit;
        if(localStorage.getItem('fh_theme') === 'dark') document.documentElement.classList.add('dark');
        fetchTransactions();
        document.getElementById('year').innerText = new Date().getFullYear();
    };

    function showToast(msg, isError = false) {
        const t = document.getElementById('toast');
        t.innerText = msg; t.classList.remove('hidden');
        t.className = `fixed bottom-6 right-6 px-6 py-3 rounded-2xl shadow-2xl z-[100] transition-all text-white font-bold text-xs uppercase tracking-widest ${isError ? 'bg-red-500 shadow-red-500/30' : 'bg-accent shadow-purple-500/30'}`;
        setTimeout(() => t.classList.add('hidden'), 3000);
    }

    async function fetchTransactions() {
        try {
            const res = await fetch('api.php');
            transactions = await res.json();
            transactions.sort((a, b) => new Date(b.date) - new Date(a.date));
            render();
        } catch (e) { console.error(e); }
    }

    async function addTransaction() {
        const date = document.getElementById('add-date').value;
        const amt = document.getElementById('add-amount').value;
        const desc = document.getElementById('add-desc').value;
        const type = document.getElementById('add-type').value;
        const cat = document.getElementById('add-cat').value;
        if(!amt || !desc || !date) return showToast("⚠️ Fill all fields", true);
        const fd = new FormData();
        fd.append('date', date); fd.append('amount', amt); fd.append('desc', desc); fd.append('type', type); fd.append('cat', cat);
        const res = await fetch('api.php', { method: 'POST', body: fd });
        const data = await res.json();
        if(data.status === 'success') {
            document.getElementById('add-amount').value = '';
            document.getElementById('add-desc').value = '';
            showToast("✅ Entry Saved!");
            fetchTransactions();
        }
    }

    async function deleteTx(id) {
        if(!confirm("Delete?")) return;
        await fetch(`api.php?delete=${id}`);
        showToast("🗑️ Deleted");
        fetchTransactions();
    }

    async function clearAllTransactions() {
        if(!confirm("⚠️ Delete ALL data?")) return;
        try {
            const res = await fetch('api.php?delete=all');
            const data = await res.json();
            if(data.status === 'success' || data.status === 'deleted') {
                showToast("💥 All data cleared!");
                transactions = [];
                render(); 
            }
        } catch (e) { transactions = []; render(); showToast("⚠️ List Cleared Locally", true); }
    }

    function setBudget() {
        budgetLimit = document.getElementById('limit-input').value;
        localStorage.setItem('fh_budget', budgetLimit);
        showToast("🎯 Budget Updated!");
        render();
    }

    function formatDateDisplay(dateStr) {
        if (!dateStr || dateStr === '0000-00-00') return 'Not Set';
        const [year, month, day] = dateStr.split('-');
        return `${day}-${month}-${year}`;
    }

    function render() {
        let inc = 0, exp = 0;
        const list = document.getElementById('history-list');
        list.innerHTML = '';
        const catTotals = {};

        const fType = document.getElementById('filter-type').value;
        const fCat = document.getElementById('filter-cat').value;
        const fMonth = document.getElementById('filter-month').value;

        const filtered = transactions.filter(t => {
            const typeMatch = fType === 'all' || t.type === fType;
            const catMatch = fCat === 'all' || t.category === fCat;
            const monthMatch = !fMonth || t.date.startsWith(fMonth);
            return typeMatch && catMatch && monthMatch;
        });

        filtered.forEach(t => {
            const amount = parseFloat(t.amount);
            if(t.type === 'income') inc += amount;
            else { exp += amount; catTotals[t.category] = (catTotals[t.category] || 0) + amount; }

            const item = document.createElement('div');
            item.className = 'flex justify-between items-center p-4 rounded-2xl glass mb-2 hover-lift group';
            item.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center glass group-hover:bg-accent group-hover:text-white transition-all text-lg">${catIcons[t.category] || '💰'}</div>
                    <div class="flex flex-col">
                        <b class="text-sm font-bold tracking-tight">${t.description}</b>
                        <small class="text-gray-400 text-[10px] font-black uppercase tracking-[0.1em] italic">${formatDateDisplay(t.date)} &bull; ${t.category}</small>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-black ${t.type === 'income' ? 'text-green-500 shadow-green-500/20' : 'text-red-500 shadow-red-500/20'}">
                        ${t.type === 'income' ? '+' : '-'} ₹${amount.toLocaleString()}
                    </span>
                    <button onclick="deleteTx(${t.id})" class="text-red-500/30 hover:text-red-500 transition-all">✕</button>
                </div>`;
            list.appendChild(item);
        });

        document.getElementById('db-bal').innerText = `₹${(inc - exp).toLocaleString()}`;
        document.getElementById('db-inc').innerText = `₹${inc.toLocaleString()}`;
        document.getElementById('db-exp').innerText = `₹${exp.toLocaleString()}`;

        updateBudgetUI(exp);
        updateCharts(inc, exp, catTotals);
    }

    function updateBudgetUI(spent) {
        const sec = document.getElementById('budget-section');
        if(budgetLimit > 0) {
            sec.classList.remove('hidden');
            const pct = Math.min((spent / budgetLimit) * 100, 100);
            const fill = document.getElementById('budget-fill');
            fill.style.width = pct + '%';
            fill.className = `h-full rounded-full transition-all duration-1000 ${pct >= 100 ? 'bg-red-500 shadow-[0_0_15px_rgba(239,68,68,0.5)]' : 'bg-accent shadow-[0_0_15px_rgba(124,58,237,0.5)]'}`;
            document.getElementById('budget-percentage').innerText = `${Math.round(pct)}% Used`;
            const msg = document.getElementById('budget-msg');
            msg.innerHTML = spent > budgetLimit ? "<span class='text-red-500 animate-pulse'>⚠️ Warning: Budget Exceeded</span>" : "<span class='text-green-500 tracking-[0.2em] italic font-bold'>Everything is On Track</span>";
        } else sec.classList.add('hidden');
    }

    function updateCharts(inc, exp, catData) {
        const txt = document.documentElement.classList.contains('dark') ? '#f1f5f9' : '#0f172a';
        if(myChart) myChart.destroy();
        const ctxBar = document.getElementById('db-chart');
        if (ctxBar) {
            myChart = new Chart(ctxBar.getContext('2d'), {
                type: 'bar',
                data: { labels: ['Income', 'Expenses'], datasets: [{ data: [inc, exp], backgroundColor: ['#10b981', '#ef4444'], borderRadius: 12 }] },
                options: { responsive: true, plugins: { legend: false }, scales: { y: { ticks: { color: txt }, grid: { display: false } }, x: { ticks: { color: txt }, grid: { display: false } } } }
            });
        }
        if(catChart) catChart.destroy();
        const ctxPie = document.getElementById('cat-chart');
        if (ctxPie) {
            catChart = new Chart(ctxPie.getContext('2d'), {
                type: 'doughnut',
                data: { labels: Object.keys(catData), datasets: [{ data: Object.values(catData), backgroundColor: ['#7c3aed', '#06b6d4', '#f59e0b', '#ef4444', '#10b981'], borderWidth: 0, hoverOffset: 15 }] },
                options: { cutout: '75%', responsive: true, plugins: { legend: { position: 'bottom', labels: { color: txt, padding: 20, font: { weight: 'bold' } } } } }
            });
        }
    }

    function showPage(id) {
        document.querySelectorAll('.page').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.nav-item').forEach(l => l.classList.remove('text-accent', 'bg-accent/10'));
        document.getElementById(id).classList.remove('hidden');
        document.getElementById('link-' + id).classList.add('text-accent', 'bg-accent/10');
        render(); 
    }

    function toggleTheme() {
        const root = document.documentElement;
        root.classList.toggle('dark');
        localStorage.setItem('fh_theme', root.classList.contains('dark') ? 'dark' : 'light');
        render();
    }

    function exportData() {
        if (transactions.length === 0) return showToast("No data to export", true);
        let csv = "Date,Description,Category,Type,Amount\n";
        transactions.forEach(t => { csv += `${t.date},"${t.description}",${t.category},${t.type},${t.amount}\n`; });
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Report_${new Date().toLocaleDateString()}.csv`;
        document.body.appendChild(a); a.click(); document.body.removeChild(a);
    }
</script>
</body>
</html>