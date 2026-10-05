<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    </style>

</head>
<body>

    @auth
    <div style="border: 3px solid black">
        <h3>Welcome, {{ auth()->user()->name }}!</h3>
        @if (auth()->user()->role === 'admin')
            <p>You are an admin</p>
            <div class="kpi-row">
                <div class="kpi-card"></div>
                    <p class="kpi-label">Total users</p>
                    <p class="kpi-value">{{ number_format(\App\Models\User::where('role', 'user')->count()) }}</p>
                </div>
            </div>
        @else
            <p>Welcome User</p>
            <p>Account Number: {{ auth()->user()->account?->account_number }}</p>
            <div class="kpi-row">
                <div class="kpi-card">
                    <p class="kpi-label">Account balance</p>
                    <p class="kpi-value">{{ number_format(auth()->user()->account?->account_balance ?? 0) }}</p>
                </div>
            </div>
            <form method="POST">
                @csrf
                <input type="number" name="amount" placeholder="Amount">
                <button type="submit" formaction="/deposit">Deposit</button>
                <button type="submit" formaction="/withdraw">Withdraw</button>
            </form>
            @error('amount')
                <p style="color: red">{{ $message }}</p>
            @enderror
        @endif
    </div>
    <form action="/logout" method="POST">
    @csrf
        <button type="submit">Logout</button>
    </form>
    @else
    <div style="border: 3px solid black">
        <h2>Register</h2>
        <form action="/register" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Name"><br>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <button type="submit">Register</button>

        </form>
    </div>
    <div style="border: 3px solid black">
        <h2>Login</h2>
        <form action="/login" method="POST">
            @csrf
            <input type="text" name="loginname" placeholder="Name"><br>
            <input type="password" name="loginpassword" placeholder="Password"><br>
            <button type="submit">Login</button>

        </form>
    </div>
    @endauth


</body>
</html>
