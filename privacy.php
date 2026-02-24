<?php 
// session check agar aap chahte hain ki sirf logged in user dekhe, warna ise hata sakte hain
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Finance Hub Pro</title>
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
            background-image: radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.05) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, rgba(6, 182, 212, 0.05) 0, transparent 50%);
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
    </style>
</head>
<body class="min-h-screen pb-12">

    <nav class="sticky top-0 z-50 px-6 py-4 glass-card m-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#7c3aed] to-[#06b6d4] flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-purple-500/20">FH</div>
            <span class="font-extrabold text-xl tracking-tight">FinanceHub<span class="text-[#7c3aed]">.</span></span>
        </div>
        <a href="index.php" class="text-sm font-bold px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/5 transition-all">Back to Home</a>
    </nav>

    <main class="max-w-4xl mx-auto px-6 mt-12">
        <div class="glass-card p-8 md:p-12 shadow-2xl">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 gradient-text">Privacy Policy</h1>
            <p class="text-sm text-gray-400 mb-10 font-medium">Last Updated: <?php echo date('F d, Y'); ?></p>

            <div class="space-y-8 text-lg leading-relaxed opacity-90">
                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-[#7c3aed] rounded-full"></span>
                        Introduction
                    </h2>
                    <p>Welcome to Finance Hub Pro. We value your privacy and are committed to protecting your personal data. This policy explains how we handle your information when you use our ledger and tracking services.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-[#06b6d4] rounded-full"></span>
                        Data We Collect
                    </h2>
                    <p class="mb-4">To provide you with the best financial tracking experience, we collect:</p>
                    <ul class="list-disc pl-6 space-y-2 text-base md:text-lg">
                        <li><strong>Account Info:</strong> Your name and email address provided during authentication.</li>
                        <li><strong>Financial Records:</strong> Transaction descriptions, amounts, categories, and dates that you manually enter.</li>
                        <li><strong>Usage Data:</strong> Preferences like your theme (dark/light mode) and budget settings stored locally.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-purple-500 rounded-full"></span>
                        How We Use Your Data
                    </h2>
                    <p>We use your data solely for the purpose of showing you your financial trends, managing your budget goals, and generating reports. We <strong>do not</strong> sell your data to any third-party advertisers.</p>
                </section>

                <section class="p-6 rounded-2xl bg-gradient-to-r from-purple-500/10 to-cyan-500/10 border border-purple-500/20">
                    <h2 class="text-2xl font-bold mb-3">Security Notice</h2>
                    <p class="text-base">All your transactions are tied to your unique User ID. While we take measures to encrypt data, we recommend not sharing your login credentials with anyone.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-red-500 rounded-full"></span>
                        Data Deletion
                    </h2>
                    <p>You have full control over your data. Using the <strong>'Clear All'</strong> button in the History section will permanently erase all your transaction records from our database. This action cannot be undone.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-4 flex items-center gap-3">
                        <span class="w-2 h-8 bg-yellow-500 rounded-full"></span>
                        Contact Us
                    </h2>
                    <p>If you have any questions about this Privacy Policy, please contact us at:</p>
                    <div class="mt-4 p-4 glass-card inline-block border-dashed">
                        <p class="font-bold text-cyan-400">support@financehub.com</p>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer class="text-center mt-12 py-6 opacity-60 text-sm">
        &copy; <?php echo date('Y'); ?> Finance Hub Pro. All Rights Reserved.
    </footer>

</body>
</html>