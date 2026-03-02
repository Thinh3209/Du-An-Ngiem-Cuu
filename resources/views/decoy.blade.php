<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Administration Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-green-500 font-mono p-10 h-screen flex flex-col">
    <div class="mb-4">
        <p>Ubuntu 22.04.1 LTS (GNU/Linux 5.15.0-101-generic x86_64)</p>
        <p>* Documentation:  https://help.ubuntu.com</p>
        <p>* Management:     https://landscape.canonical.com</p>
        <p>* Support:        https://ubuntu.com/advantage</p>
        <br>
        <p>System load:  0.01               Processes:             115</p>
        <p>Usage of /:   18.5% of 49.10GB   Users logged in:       1</p>
        <br>
        <p class="text-red-500 font-bold">WARNING: SYSTEM RUNNING IN UNSECURE MODE.</p>
    </div>
    
    <div id="terminal" class="flex-1 overflow-auto">
        <p>root@server-main:~# Connection established.</p>
        <p>root@server-main:~# Please enter administrative password to continue:</p>
        <div class="flex mt-2">
            <span class="mr-2">Password:</span>
            <input type="password" id="hack-input" class="bg-black text-green-500 outline-none flex-1" autofocus>
        </div>
    </div>
<script>
        // Kịch bản câu giờ: Bất kể hacker nhập gì cũng báo sai + Âm thầm gửi Log
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const input = document.getElementById('hack-input');
                const val = input.value;
                input.value = '';
                
                // --- BẮT ĐẦU ĐOẠN CẤY GHÉP: ÂM THẦM GỬI DATA VỀ SERVER ---
                if(val.trim() !== '') {
                    fetch('/honeypot-catch', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            password_attempt: val,
                            attack_path: window.location.pathname
                        })
                    }).catch(error => console.error("Lưới điện gặp sự cố:", error));
                }
                // --- KẾT THÚC ĐOẠN CẤY GHÉP ---

                const term = document.getElementById('terminal');
                term.innerHTML += `<p class="mt-2 text-red-500">Access denied for password: ${'*'.repeat(val.length)}</p>`;
                term.innerHTML += `<p class="mt-2">root@server-main:~# Invalid credentials. Please try again:</p>`;
                term.innerHTML += `<div class="flex mt-2"><span class="mr-2">Password:</span><input type="password" class="bg-black text-green-500 outline-none flex-1" autofocus></div>`;
                
                // Trỏ chuột lại vào ô mới
                const inputs = document.querySelectorAll('input');
                inputs[inputs.length - 1].focus();
                inputs[inputs.length - 1].id = 'hack-input';
            }
        });
    </script>
</body>
</html>
