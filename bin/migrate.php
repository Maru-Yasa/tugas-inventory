<?php

require __DIR__ . '/../src/bootstrap.php';

use Maru\Inventory\Core\DB;

$command = $argv[1] ?? 'migrate';

if ($command === 'create') {
    $name = $argv[2] ?? null;

    if (!$name) {
        echo "❌ Migration name required.\n";
        exit(1);
    }

    $timestamp = date('YmdHis');
    $filename = $timestamp . '_' . $name . '.php';
    $path = __DIR__ . '/../migrations/' . $filename;

    $template = <<<PHP
<?php

return function (\$db) {
    // Write your migration logic here
    // Example:
    // \$db->query(\"CREATE TABLE ...\");
};
PHP;

    file_put_contents($path, $template);

    echo "✅ Migration created: migrations/{$filename}\n";
    exit;
}

// === Migration runner logic starts here ===

$db = DB::make();

$db->query("
    CREATE TABLE IF NOT EXISTS migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INTEGER NOT NULL,
        migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$executed = array_column($db->select('migrations', 'migration'), 'migration');
$migrationsDir = __DIR__ . '/../migrations';
$allFiles = glob($migrationsDir . '/*.php');
sort($allFiles);

$batch = (int) $db->max('migrations', 'batch') + 1;
$newMigrations = [];

foreach ($allFiles as $file) {
    $filename = basename($file);

    if (in_array($filename, $executed)) {
        continue;
    }

    echo "🔄 Running migration: $filename\n";
    $migration = require $file;

    if (!is_callable($migration)) {
        echo "❌ Invalid migration file: $filename\n";
        exit(1);
    }

    if (!empty($db->select('migrations', 'migration', ['migration' => $filename]))) {
        continue;
    }

    try {
        $migration($db);
        $db->insert('migrations', [
            'migration' => $filename,
            'batch' => $batch,
        ]);
        echo "✅ Migrated: $filename\n";
        $newMigrations[] = $filename;
    } catch (Throwable $e) {
        echo "❌ Failed: $filename - " . $e->getMessage() . "\n";
        exit(1);
    }
}

if (empty($newMigrations)) {
    echo "✅ No new migrations.\n";
}
