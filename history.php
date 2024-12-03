<?php
// データベース接続情報
require_once 'db.php';

$sql = "SELECT * FROM translation_history ORDER BY created_at ASC;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会話履歴</title>
    <!-- Tailwind CSSのリンクを追加 -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full">
        <h1 class="text-2xl font-bold text-center text-blue-500 mb-6">会話履歴</h1>

        <!-- 会話履歴表示 -->
        <div class="overflow-y-auto max-h-96">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border text-gray-600">#</th>
                        <th class="px-4 py-2 border text-gray-600">言語</th>
                        <th class="px-4 py-2 border text-gray-600">テキスト</th>
                        <th class="px-4 py-2 border text-gray-600">翻訳言語</th>
                        <th class="px-4 py-2 border text-gray-600">翻訳テキスト</th>
                        <th class="px-4 py-2 border text-gray-600"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($conversations as $index => $conversation): ?>
                        <tr>
                            <td class='border px-4 py-2 text-center'><?= $index + 1 ?></td>
                            <td class='border px-4 py-2'><?= $conversation['from_lang'] ?></td>
                            <td class='border px-4 py-2'><?= $conversation['text'] ?></td>
                            <td class='border px-4 py-2'><?= $conversation['to_lang'] ?></td>
                            <td class='border px-4 py-2'><?= $conversation['translated_text'] ?></td>
                            <td class='border px-4 py-2'>
                                <button onclick="speakText('<?= str_replace(["\r", "\n"], '', $conversation['translated_text']) ?>', '<?= $conversation['to_lang'] ?>')">
                                    <img src="images/audio-icon.png" class="w-12">
                                </button>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <!-- 戻るボタン -->
        <div class="mt-6">
            <a href="index.php" class="block text-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">アプリに戻る</a>
        </div>
    </div>

    <script src="js/config.js"></script>
    <script src="js/app.js"></script>
</body>

</html>