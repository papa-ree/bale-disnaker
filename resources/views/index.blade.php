<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Disnaker - Coming Soon</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .container {
            text-align: center;
            padding: 2rem;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeIn 0.8s ease-in;
        }

        p {
            font-size: 1.25rem;
            opacity: 0.9;
            animation: fadeIn 1s ease-in;
        }

        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            margin-top: 2rem;
            animation: fadeIn 1.2s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🚀 Bale Disnaker</h1>
        <p>Landing Page Dinas Tenaga Kerja</p>
        <div class="badge">Coming Soon</div>
    </div>
</body>

</html>