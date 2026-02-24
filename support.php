<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Finance Hub Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --accent: #7c3aed;
            --accent-2: #06b6d4;
            --bg: #020617;
            --surface: #0f172a;
            --text: #f1f5f9;
            --muted: #94a3b8;
            --line: rgba(255,255,255,.05);
            --radius: 24px;
        }

        [data-theme="light"] {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: rgba(0,0,0,.05);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            background-image: radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.05) 0, transparent 50%), 
                              radial-gradient(at 0% 0%, rgba(6, 182, 212, 0.05) 0, transparent 50%);
        }

        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(12px);
            border: 1px solid var(--line);
            border-radius: var(--radius);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .faq-item {
            border-bottom: 1px solid var(--line);
        }

        input, textarea {
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid var(--line) !important;
            color: var(--text) !important;
        }
        
        input:focus, textarea:focus {
            border-color: var(--accent) !important;
            outline: none;
        }
    </style>
</head>
<body class="min-h-screen pb-12">

    <nav class="sticky top-0 z-50 px-6 py-4 glass-card m-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#7c3aed] to-[#06b6d4] flex items-center justify-center text-white font-bold text-xl">FH</div>
            <span class="font-extrabold text-xl tracking-tight text-white font-sans">FinanceHub<span class="text-[#7c3aed]">.</span></span>
        </div>
        <a href="index.php" class="text-sm font-bold px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/5 transition-all text-white">Back to Home</a>
    </nav>

    <main class="max-w-5xl mx-auto px-6 mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="glass-card p-8 md:p-10 shadow-2xl h-fit">
            <h1 class="text-3xl font-extrabold mb-6 gradient-text">Help & FAQs</h1>
            
            <div class="space-y-6">
                <div class="faq-item pb-4">
                    <h3 class="font-bold text-lg mb-2 text-white">Data delete kaise karein?</h3>
                    <p class="text-sm text-gray-400">History section mein upar 'Clear All' button hai, usse saara data ek saath uda sakte hain.</p>
                </div>

                <div class="faq-item pb-4">
                    <h3 class="font-bold text-lg mb-2 text-white">Kya mera data safe hai?</h3>
                    <p class="text-sm text-gray-400">Haan, aapka data aapke account se link hai aur hum use kisi third-party ko nahi bechte.</p>
                </div>

                <div class="faq-item pb-4">
                    <h3 class="font-bold text-lg mb-2 text-white">Budget limit exceed alert?</h3>
                    <p class="text-sm text-gray-400">Analysis page par limit set karne ke baad agar kharcha zyada hoga, toh system automatic red indicator dikhayega.</p>
                </div>

                <div class="pt-4 text-center">
                    <p class="text-sm font-semibold text-gray-500 mb-2 tracking-widest uppercase">Reach us directly</p>
                    <p class="text-xl font-bold text-[#06b6d4]">support@financehub.com</p>
                </div>
            </div>
        </div>

        <div class="glass-card p-8 md:p-10 shadow-2xl">
            <h2 class="text-3xl font-extrabold mb-6 text-white">Contact Us</h2>
            <form action="#" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold mb-2 opacity-70">Aapka Naam</label>
                    <input type="text" placeholder="John Doe" class="w-full px-4 py-3 rounded-xl transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 opacity-70">Email Address</label>
                    <input type="email" placeholder="example@mail.com" class="w-full px-4 py-3 rounded-xl transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 opacity-70">Aapka Sawal / Feedback</label>
                    <textarea rows="5" placeholder="I need help with..." class="w-full px-4 py-3 rounded-xl transition-all" required></textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#7c3aed] to-[#9333ea] text-white font-bold rounded-xl shadow-lg shadow-purple-500/20 hover:scale-[0.98] transition-all">
                    Send Message
                </button>
            </form>
        </div>

    </main>

    <footer class="text-center mt-12 py-8 opacity-40 text-sm font-semibold">
        Finance Hub Pro &bull; Customer Success Team
    </footer>

</body>
</html>