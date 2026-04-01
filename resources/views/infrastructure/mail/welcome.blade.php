<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: sans-serif; line-height: 1.6; color: #333; }
    .container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #eee; }
    .button { background: #4a90e2; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Вітаємо, {{ $user->name }}!</h1>
    <p>Дякуємо за реєстрацію в нашому сервісі. Ми раді, що ви з нами.</p>

    <p>Ваш логін: <strong>{{ $user->email }}</strong></p>

    <div style="margin-top: 30px;">
        <a href="{{ config('app.url') }}/login" class="button">Увійти в кабінет</a>
    </div>

    <p style="margin-top: 40px; font-size: 0.8em; color: #777;">
        Якщо ви не створювали цей акаунт, просто проігноруйте цей лист.
    </p>
  </div>
</body>
</html>