<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Master - Spaghetti</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; color: #333; display: flex; justify-content: center; padding-top: 50px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 520px; }
        h1 { font-size: 1.5rem; text-align: center; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .error { color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px; font-size: 0.9rem; }
        .form-group { display: grid; gap: 10px; margin-top: 20px; margin-bottom: 20px; }
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #2563eb; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        ul { list-style: none; padding: 0; }
        li { display: flex; justify-content: space-between; align-items: flex-start; padding: 12px; border-bottom: 1px solid #eee; }
        li.done span { text-decoration: line-through; color: #9ca3af; }
        .actions a { text-decoration: none; margin-left: 10px; cursor: pointer; }
        .meta { font-size: 0.85rem; color: #555; margin-top: 4px; }
        .description { margin-top: 6px; color: #4b5563; font-size: 0.95rem; white-space: pre-wrap; }
    </style>
</head>
<body>

<div class="container">
    <h1>Task Master - Spaghetti</h1>

    <?php if (isset($error) && $error): ?>
        <div class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=create" class="form-group">
        <input type="text" name="title" placeholder="Título" required>
        <input type="text" name="description" placeholder="Descrição">
        <input type="date" name="due_date" required>
        <input type="text" name="responsible" placeholder="Responsável" required>
        <button type="submit">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?php echo $task['done'] ? 'done' : ''; ?>">
                <div>
                    <strong><?php echo htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
                    <small><?php echo htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8'); ?> | Vence em: <?php echo htmlspecialchars($task['due_date'], ENT_QUOTES, 'UTF-8'); ?> | Responsável: <?php echo htmlspecialchars($task['responsible'], ENT_QUOTES, 'UTF-8'); ?></small>
                </div>
                <div class="actions">
                    <?php if (!$task['done']): ?>
                        <a href="index.php?action=complete&id=<?php echo $task['id']; ?>">✅</a>
                    <?php endif; ?>
                    <a href="index.php?action=delete&id=<?php echo $task['id']; ?>">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
